# GoPrint Image Watermark Remover - PowerShell Version
# Uses System.Drawing for image processing

Write-Host ""
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host "       GoPrint Image Watermark Remover v1.0" -ForegroundColor Cyan
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host ""

# Configuration
$InputDir = "C:\xampp\htdocs\goprint\laravel\storage\app\public\products"
$OutputDir = $InputDir  # Overwrite original files

# Get all image files
$ImageFiles = Get-ChildItem -Path $InputDir -Include *.png, *.jpg, *.jpeg -File | Sort-Object Name

if ($ImageFiles.Count -eq 0) {
    Write-Host "❌ No images found in $InputDir" -ForegroundColor Red
    exit
}

Write-Host "📂 Found $($ImageFiles.Count) images to process" -ForegroundColor Yellow
Write-Host ""

$SuccessCount = 0
$FailCount = 0

foreach ($File in $ImageFiles) {
    Write-Host "[$($SuccessCount + $FailCount + 1)/$($ImageFiles.Count)] Processing: $($File.Name)" -ForegroundColor White
    
    try {
        # Load the image
        $Image = [System.Drawing.Image]::FromFile($File.FullName)
        $Width = $Image.Width
        $Height = $Image.Height
        
        # Calculate watermark region (bottom-right corner)
        $WM_X_Start = [int]($Width * 0.88)
        $WM_Y_Start = [int]($Height * 0.90)
        $WM_Width = $Width - $WM_X_Start
        $WM_Height = $Height - $WM_Y_Start
        
        Write-Host "   📐 Size: $($Width)x$($Height), Watermark region: ($($WM_X_Start), $($WM_Y_Start))" -ForegroundColor Gray
        
        # Create a bitmap for processing
        $Bitmap = New-Object System.Drawing.Bitmap($Image)
        $Graphics = [System.Drawing.Graphics]::FromImage($Bitmap)
        
        # Set high quality rendering
        $Graphics.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
        $Graphics.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::HighQuality
        $Graphics.PixelOffsetMode = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality
        $Graphics.CompositingQuality = [System.Drawing.Drawing2D.CompositingQuality]::HighQuality
        
        # Sample colors from nearby area (left of watermark) for seamless fill
        $SampleX = [int]($WM_X_Start - $WM_Width - 20)
        if ($SampleX -lt 0) { $SampleX = 0 }
        $SampleY = $WM_Y_Start
        
        # Create a brush with averaged color
        $AvgColor = Get-AverageColor -Bitmap $Bitmap -X $SampleX -Y $SampleY -Width 50 -Height $WM_Height
        
        # Fill the watermark region with averaged color
        $FillBrush = New-Object System.Drawing.SolidBrush($AvgColor)
        $Graphics.FillRectangle($FillBrush, $WM_X_Start, $WM_Y_Start, $WM_Width, $WM_Height)
        
        # Apply subtle gradient from left to blend better
        for ($i = 0; $i -lt 20; $i++) {
            $Alpha = [int](255 * ($i / 20) * 0.3)
            $BlendColor = [System.Drawing.Color]::FromArgb($Alpha, $AvgColor)
            $BlendBrush = New-Object System.Drawing.SolidBrush($BlendColor)
            $Graphics.FillRectangle($BlendBrush, ($WM_X_Start - 20 + $i), $WM_Y_Start, 1, $WM_Height)
            $BlendBrush.Dispose()
        }
        
        # Apply slight blur effect by drawing semi-transparent pixels
        $Random = New-Object System.Random
        for ($x = $WM_X_Start; $x -lt ($WM_X_Start + $WM_Width); $x += 2) {
            for ($y = $WM_Y_Start; $y -lt ($WM_Y_Start + $WM_Height); $y += 2) {
                $OffsetX = $Random.Next(-3, 4)
                $OffsetY = $Random.Next(-3, 4)
                $SrcX = [Math]::Max(0, [Math]::Min($Width - 1, $x + $OffsetX))
                $SrcY = [Math]::Max(0, [Math]::Min($Height - 1, $y + $OffsetY))
                
                $SrcColor = $Bitmap.GetPixel($SrcX, $SrcY)
                $BlendColor = [System.Drawing.Color]::FromArgb(200, $SrcColor)
                $BlendBrush = New-Object System.Drawing.SolidBrush($BlendColor)
                $Graphics.FillRectangle($BlendBrush, $x, $y, 2, 2)
                $BlendBrush.Dispose()
            }
        }
        
        # Save the processed image
        $TempFile = $File.FullName + ".tmp"
        
        # Determine format
        if ($File.Extension -eq ".jpg" -or $File.Extension -eq ".jpeg") {
            $Bitmap.Save($TempFile, [System.Drawing.Imaging.ImageFormat]::Jpeg)
        } else {
            $Bitmap.Save($TempFile, [System.Drawing.Imaging.ImageFormat]::Png)
        }
        
        # Clean up
        $Graphics.Dispose()
        $Bitmap.Dispose()
        $Image.Dispose()
        $FillBrush.Dispose()
        
        # Replace original with processed
        Remove-Item $File.FullName -Force
        Move-Item $TempFile $File.FullName -Force
        
        $SuccessCount++
        Write-Host "   ✅ Watermark removed successfully" -ForegroundColor Green
        
    } catch {
        $FailCount++
        Write-Host "   ❌ Error: $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host "                    Processing Complete" -ForegroundColor Cyan
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "✅ Successfully processed: $SuccessCount images" -ForegroundColor Green
if ($FailCount -gt 0) {
    Write-Host "❌ Failed: $FailCount images" -ForegroundColor Red
}
Write-Host ""

# Helper function to get average color
function Get-AverageColor {
    param(
        [System.Drawing.Bitmap]$Bitmap,
        [int]$X,
        [int]$Y,
        [int]$Width,
        [int]$Height
    )
    
    $TotalR = 0
    $TotalG = 0
    $TotalB = 0
    $Count = 0
    
    $EndX = [Math]::Min($Bitmap.Width, $X + $Width)
    $EndY = [Math]::Min($Bitmap.Height, $Y + $Height)
    
    for ($x = $X; $x -lt $EndX; $x++) {
        for ($y = $Y; $y -lt $EndY; $y++) {
            $Pixel = $Bitmap.GetPixel($x, $y)
            $TotalR += $Pixel.R
            $TotalG += $Pixel.G
            $TotalB += $Pixel.B
            $Count++
        }
    }
    
    if ($Count -gt 0) {
        return [System.Drawing.Color]::FromArgb(
            [int]($TotalR / $Count),
            [int]($TotalG / $Count),
            [int]($TotalB / $Count)
        )
    } else {
        return [System.Drawing.Color]::White
    }
}
