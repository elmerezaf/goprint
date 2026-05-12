# GoPrint Watermark Remover Installation & Run Script

Write-Host "`n=========================================" -ForegroundColor Cyan
Write-Host "   GoPrint Professional Watermark Remover" -ForegroundColor Cyan
Write-Host "=========================================`n" -ForegroundColor Cyan

# Check if Python is installed
try {
    $python = Get-Command python -ErrorAction Stop
    Write-Host "✅ Python found: $($python.Source)" -ForegroundColor Green
} catch {
    Write-Host "❌ Python not found. Installing Python..." -ForegroundColor Yellow
    
    # Create temp directory
    New-Item -ItemType Directory -Path "C:\temp" -Force | Out-Null
    
    # Download Python installer
    Write-Host "Downloading Python 3.11..." -ForegroundColor Yellow
    $url = "https://www.python.org/ftp/python/3.11.9/python-3.11.9-amd64.exe"
    $output = "C:\temp\python_installer.exe"
    
    $webClient = New-Object System.Net.WebClient
    $webClient.DownloadFile($url, $output)
    Write-Host "✅ Download completed" -ForegroundColor Green
    
    # Install Python silently
    Write-Host "Installing Python..." -ForegroundColor Yellow
    Start-Process -FilePath $output -ArgumentList "/quiet InstallAllUsers=1 PrependPath=1" -Wait
    Write-Host "✅ Python installed successfully" -ForegroundColor Green
    
    # Cleanup
    Remove-Item $output -Force
}

# Refresh PATH
$env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")

# Check if OpenCV is installed
Write-Host "`nChecking OpenCV..." -ForegroundColor Yellow
try {
    python -c "import cv2; print('OpenCV version:', cv2.__version__)"
    Write-Host "✅ OpenCV is installed" -ForegroundColor Green
} catch {
    Write-Host "Installing OpenCV..." -ForegroundColor Yellow
    python -m pip install opencv-python numpy
    Write-Host "✅ OpenCV installed successfully" -ForegroundColor Green
}

# Run the watermark remover
Write-Host "`n🚀 Starting AI Watermark Removal..." -ForegroundColor Cyan
Write-Host "----------------------------------------`n" -ForegroundColor Cyan

python "C:\xampp\htdocs\goprint\laravel\professional_watermark_remover.py"

Write-Host "`n=========================================" -ForegroundColor Cyan
Write-Host "          Process Completed!" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
