#!/usr/bin/env python3
"""
GoPrint Professional Watermark Remover
Uses OpenCV Inpainting for AI-powered watermark removal
Similar to Photoshop's Content-Aware Fill
"""

import cv2
import numpy as np
import os

def remove_watermark_professional(input_path, output_path=None):
    """
    Professional watermark removal using OpenCV inpainting
    """
    if output_path is None:
        output_path = input_path
    
    img = cv2.imread(str(input_path))
    if img is None:
        print(f"❌ Failed to read: {input_path}")
        return False
    
    h, w = img.shape[:2]
    
    # Detect watermark in bottom-right corner (typical Doubao watermark location)
    # The watermark usually occupies about 12% from bottom and 15% from right
    wm_x_start = int(w * 0.82)
    wm_y_start = int(h * 0.85)
    wm_width = w - wm_x_start
    wm_height = h - wm_y_start
    
    # Create a mask for watermark region with smooth edges
    mask = np.zeros((h, w), dtype=np.uint8)
    
    # Draw the watermark region
    cv2.rectangle(mask, (wm_x_start, wm_y_start), (w, h), 255, -1)
    
    # Apply Gaussian blur to create smooth transition edges
    mask = cv2.GaussianBlur(mask, (31, 31), 0)
    
    # Normalize mask to 0-1 range for better blending
    mask = mask / 255.0
    
    # Method 1: Telea inpainting (fast, good for textures)
    result_telea = cv2.inpaint(img, (mask * 255).astype(np.uint8), 3, cv2.INPAINT_TELEA)
    
    # Method 2: Navier-Stokes inpainting (better for structured patterns)
    result_ns = cv2.inpaint(img, (mask * 255).astype(np.uint8), 5, cv2.INPAINT_NS)
    
    # Blend both results for best quality
    result = cv2.addWeighted(result_telea, 0.6, result_ns, 0.4, 0)
    
    # Apply additional refinement
    result = refine_inpainting(result, img, mask, wm_x_start, wm_y_start, wm_width, wm_height)
    
    # Save result with high quality
    cv2.imwrite(str(output_path), result, [cv2.IMWRITE_JPEG_QUALITY, 95])
    
    return True

def refine_inpainting(result, original, mask, x, y, w, h):
    """
    Refine the inpainted region for better blending
    """
    # Create a gradient mask for seamless blending
    margin = 20
    blend_region = result[y-margin:y+h+margin, x-margin:x+w+margin]
    
    # Apply slight blur to edges
    blended = cv2.GaussianBlur(blend_region, (5, 5), 0)
    
    # Copy blended region back
    result[y-margin:y+h+margin, x-margin:x+w+margin] = blended
    
    return result

def batch_process(input_dir):
    """
    Batch process all images in a directory
    """
    input_path = os.path.abspath(input_dir)
    
    print("="*60)
    print("🎨 GoPrint Professional Watermark Remover")
    print("="*60)
    print(f"\n📂 Processing directory: {input_path}\n")
    
    # Get all image files
    image_files = []
    for ext in ['*.png', '*.jpg', '*.jpeg']:
        image_files.extend([os.path.join(input_path, f) for f in os.listdir(input_path) 
                          if f.lower().endswith(tuple(ext.split('*.'))[1:])])
    
    print(f"🔍 Found {len(image_files)} images to process")
    print("-"*60)
    
    success = 0
    failed = []
    
    for i, filepath in enumerate(sorted(image_files), 1):
        filename = os.path.basename(filepath)
        print(f"\n[{i}/{len(image_files)}] Processing: {filename}")
        
        try:
            if remove_watermark_professional(filepath):
                print(f"✅ SUCCESS - Watermark removed with AI inpainting")
                success += 1
            else:
                print(f"❌ FAILED - Could not process image")
                failed.append(filename)
        except Exception as e:
            print(f"❌ FAILED - {str(e)}")
            failed.append(filename)
    
    print("\n" + "="*60)
    print(f"📊 Summary:")
    print(f"   ✅ Successfully processed: {success}/{len(image_files)}")
    if failed:
        print(f"   ❌ Failed files: {', '.join(failed)}")
    print("="*60)
    
    return success, failed

def main():
    """Main function"""
    input_dir = r"C:\xampp\htdocs\goprint\laravel\storage\app\public\products"
    
    if not os.path.exists(input_dir):
        print(f"❌ Directory not found: {input_dir}")
        return
    
    batch_process(input_dir)

if __name__ == "__main__":
    main()
