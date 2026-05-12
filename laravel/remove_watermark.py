#!/usr/bin/env python
import os
import sys
try:
    from PIL import Image
except ImportError:
    try:
        import Image
    except:
        print("PIL not found, trying to install...")
        os.system('pip install pillow')
        from PIL import Image

def remove_watermark(input_path):
    try:
        img = Image.open(input_path)
        width, height = img.size
        
        # Watermark region (bottom-right 15%)
        wm_x_start = int(width * 0.85)
        wm_y_start = int(height * 0.85)
        wm_width = width - wm_x_start
        wm_height = height - wm_y_start
        
        # Sample colors from left of watermark
        sample_width = min(80, wm_x_start)
        total_r, total_g, total_b, count = 0, 0, 0, 0
        
        for x in range(max(0, wm_x_start - sample_width), wm_x_start):
            for y in range(wm_y_start, min(height, wm_y_start + wm_height)):
                r, g, b = img.getpixel((x, y))
                total_r += r
                total_g += g
                total_b += b
                count += 1
        
        if count > 0:
            avg_r = total_r // count
            avg_g = total_g // count
            avg_b = total_b // count
            
            # Fill watermark area with average color
            for x in range(wm_x_start, width):
                for y in range(wm_y_start, height):
                    img.putpixel((x, y), (avg_r, avg_g, avg_b))
        
        # Save with same format
        img.save(input_path)
        return True
    except Exception as e:
        print(f"Error processing {input_path}: {str(e)}")
        return False

def main():
    input_dir = r"C:\xampp\htdocs\goprint\laravel\storage\app\public\products"
    
    print("=" * 60)
    print("GoPrint Image Watermark Remover")
    print("=" * 60)
    print(f"\nProcessing directory: {input_dir}\n")
    
    files = []
    for f in os.listdir(input_dir):
        if f.lower().endswith(('.png', '.jpg', '.jpeg')):
            files.append(os.path.join(input_dir, f))
    
    print(f"Found {len(files)} images to process")
    print("-" * 60)
    
    success = 0
    failed = 0
    
    for i, filepath in enumerate(files, 1):
        filename = os.path.basename(filepath)
        print(f"[{i}/{len(files)}] Processing: {filename}")
        
        if remove_watermark(filepath):
            print("   SUCCESS")
            success += 1
        else:
            print("   FAILED")
            failed += 1
    
    print("-" * 60)
    print(f"\nCompleted!")
    print(f"Success: {success}")
    print(f"Failed: {failed}")

if __name__ == "__main__":
    main()
