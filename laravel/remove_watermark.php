<?php
/**
 * GoPrint Image Watermark Remover
 * PHP version - works with Laravel environment
 */

set_time_limit(300);

$inputDir = 'C:\\xampp\\htdocs\\goprint\\laravel\\storage\\app\\public\\products';

echo "========================================\n";
echo "GoPrint Image Watermark Remover\n";
echo "========================================\n\n";

echo "Processing directory: $inputDir\n\n";

$files = glob($inputDir . '/*.{png,jpg,jpeg}', GLOB_BRACE);

echo "Found " . count($files) . " images to process\n";
echo "----------------------------------------\n\n";

$success = 0;
$failed = 0;

foreach ($files as $file) {
    $filename = basename($file);
    echo "Processing: $filename\n";
    
    try {
        $info = getimagesize($file);
        $width = $info[0];
        $height = $info[1];
        $mime = $info['mime'];
        
        switch ($mime) {
            case 'image/jpeg':
                $img = imagecreatefromjpeg($file);
                break;
            case 'image/png':
                $img = imagecreatefrompng($file);
                break;
            default:
                echo "   SKIPPED (unsupported format)\n";
                continue 2;
        }
        
        // Watermark region (bottom-right 15%)
        $wm_x_start = (int)($width * 0.85);
        $wm_y_start = (int)($height * 0.85);
        $wm_width = $width - $wm_x_start;
        $wm_height = $height - $wm_y_start;
        
        // Sample colors from left of watermark
        $sample_width = min(80, $wm_x_start);
        $total_r = $total_g = $total_b = $count = 0;
        
        for ($x = max(0, $wm_x_start - $sample_width); $x < $wm_x_start; $x++) {
            for ($y = $wm_y_start; $y < min($height, $wm_y_start + $wm_height); $y++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $total_r += $r;
                $total_g += $g;
                $total_b += $b;
                $count++;
            }
        }
        
        if ($count > 0) {
            $avg_r = (int)($total_r / $count);
            $avg_g = (int)($total_g / $count);
            $avg_b = (int)($total_b / $count);
            
            $fill_color = imagecolorallocate($img, $avg_r, $avg_g, $avg_b);
            
            // Fill watermark area
            imagefilledrectangle($img, $wm_x_start, $wm_y_start, $width, $height, $fill_color);
        }
        
        // Save back to original file
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($img, $file, 90);
                break;
            case 'image/png':
                imagepng($img, $file);
                break;
        }
        
        imagedestroy($img);
        
        echo "   SUCCESS\n";
        $success++;
        
    } catch (Exception $e) {
        echo "   FAILED: " . $e->getMessage() . "\n";
        $failed++;
    }
}

echo "\n----------------------------------------\n";
echo "Completed!\n";
echo "Success: $success\n";
echo "Failed: $failed\n";
echo "========================================\n";
?>
