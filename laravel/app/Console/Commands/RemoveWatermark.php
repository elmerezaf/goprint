<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RemoveWatermark extends Command
{
    protected $signature = 'watermark:remove';
    protected $description = 'Remove watermarks from product images';

    public function handle()
    {
        $this->info('========================================');
        $this->info('GoPrint Image Watermark Remover');
        $this->info('========================================');
        $this->newLine();

        $path = storage_path('app/public/products');
        $this->info("Processing directory: $path");
        $this->newLine();

        $files = glob($path . '/*.{png,jpg,jpeg}', GLOB_BRACE);
        $total = count($files);
        
        $this->info("Found $total images to process");
        $this->line('----------------------------------------');
        $this->newLine();

        $success = 0;
        $failed = 0;

        foreach ($files as $file) {
            $filename = basename($file);
            $this->line("Processing: $filename");

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
                        $this->warn("   SKIPPED (unsupported format)");
                        continue 2;
                }

                $wm_x_start = (int)($width * 0.85);
                $wm_y_start = (int)($height * 0.85);

                $sample_width = min(80, $wm_x_start);
                $total_r = $total_g = $total_b = $count = 0;

                for ($x = max(0, $wm_x_start - $sample_width); $x < $wm_x_start; $x++) {
                    for ($y = $wm_y_start; $y < min($height, $wm_y_start + ($height - $wm_y_start)); $y++) {
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
                    imagefilledrectangle($img, $wm_x_start, $wm_y_start, $width, $height, $fill_color);
                }

                switch ($mime) {
                    case 'image/jpeg':
                        imagejpeg($img, $file, 90);
                        break;
                    case 'image/png':
                        imagepng($img, $file);
                        break;
                }

                imagedestroy($img);

                $this->info("   SUCCESS");
                $success++;

            } catch (\Exception $e) {
                $this->error("   FAILED: " . $e->getMessage());
                $failed++;
            }
        }

        $this->newLine();
        $this->line('----------------------------------------');
        $this->info('Completed!');
        $this->info("Success: $success");
        $this->info("Failed: $failed");
        $this->line('========================================');

        return 0;
    }
}
