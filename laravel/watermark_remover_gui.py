#!/usr/bin/env python3
"""
GoPrint Watermark Remover - Desktop GUI Version
Professional watermark removal using OpenCV Inpainting
"""

import tkinter as tk
from tkinter import ttk, filedialog, messagebox, scrolledtext
import cv2
import numpy as np
import os
import threading
from pathlib import Path
import sys

# Try to import tkinterdnd2 for drag-and-drop
try:
    from tkinterdnd2 import TkinterDnD, DND_FILES
    HAS_DND = True
except ImportError:
    HAS_DND = False

class WatermarkRemoverGUI:
    def __init__(self, root):
        self.root = root
        self.root.title("GoPrint 水印移除工具 - OpenCV Inpainting")
        self.root.geometry("800x600")
        self.root.minsize(600, 500)
        
        # Variables
        self.file_paths = []
        self.processing = False
        
        # Setup drag-and-drop if available
        if HAS_DND:
            self.root.drop_target_register(DND_FILES)
            self.root.dnd_bind('<<Drop>>', self.on_drop)
        
        # Create UI
        self.create_widgets()
    
    def on_drop(self, event):
        # Handle dropped files/folders
        files = self.root.tk.splitlist(event.data)
        image_files = []
        
        for path in files:
            # Remove curly braces from paths with spaces
            path = path.strip('{}')
            path_obj = Path(path)
            
            if path_obj.is_file():
                if path_obj.suffix.lower() in ['.png', '.jpg', '.jpeg']:
                    image_files.append(str(path_obj))
            elif path_obj.is_dir():
                for ext in ['*.png', '*.jpg', '*.jpeg']:
                    image_files.extend([str(f) for f in path_obj.glob(ext)])
                    image_files.extend([str(f) for f in path_obj.glob(ext.upper())])
        
        if image_files:
            self.add_files(image_files)
        
    def create_widgets(self):
        # Main frame
        main_frame = ttk.Frame(self.root, padding="10")
        main_frame.grid(row=0, column=0, sticky=(tk.W, tk.E, tk.N, tk.S))
        
        self.root.columnconfigure(0, weight=1)
        self.root.rowconfigure(0, weight=1)
        main_frame.columnconfigure(1, weight=1)
        main_frame.rowconfigure(3, weight=1)
        
        # Title
        title_label = ttk.Label(main_frame, text="🎨 水印移除工具", font=("Arial", 16, "bold"))
        title_label.grid(row=0, column=0, columnspan=3, pady=(0, 20))
        
        # File selection section
        ttk.Label(main_frame, text="选择文件或文件夹:").grid(row=1, column=0, sticky=tk.W, pady=5)
        
        button_frame = ttk.Frame(main_frame)
        button_frame.grid(row=1, column=1, columnspan=2, sticky=(tk.W, tk.E), pady=5)
        
        ttk.Button(button_frame, text="选择图片", command=self.select_files).pack(side=tk.LEFT, padx=(0, 5))
        ttk.Button(button_frame, text="选择文件夹", command=self.select_folder).pack(side=tk.LEFT, padx=5)
        ttk.Button(button_frame, text="清空列表", command=self.clear_files).pack(side=tk.LEFT, padx=5)
        
        # File list
        ttk.Label(main_frame, text="待处理文件:").grid(row=2, column=0, sticky=tk.NW, pady=5)
        
        self.file_listbox = tk.Listbox(main_frame, height=10)
        self.file_listbox.grid(row=2, column=1, columnspan=2, sticky=(tk.W, tk.E, tk.N, tk.S), pady=5)
        
        # Scrollbar for file list
        scrollbar = ttk.Scrollbar(main_frame, orient=tk.VERTICAL, command=self.file_listbox.yview)
        scrollbar.grid(row=2, column=3, sticky=(tk.N, tk.S), pady=5)
        self.file_listbox.configure(yscrollcommand=scrollbar.set)
        
        # Watermark position settings
        settings_frame = ttk.LabelFrame(main_frame, text="水印位置设置", padding="10")
        settings_frame.grid(row=3, column=0, columnspan=4, sticky=(tk.W, tk.E), pady=10)
        
        ttk.Label(settings_frame, text="从右边距 (%):").grid(row=0, column=0, sticky=tk.W, padx=5)
        self.wm_right_var = tk.DoubleVar(value=18)
        ttk.Entry(settings_frame, textvariable=self.wm_right_var, width=10).grid(row=0, column=1, padx=5)
        
        ttk.Label(settings_frame, text="从下边距 (%):").grid(row=0, column=2, sticky=tk.W, padx=5)
        self.wm_bottom_var = tk.DoubleVar(value=15)
        ttk.Entry(settings_frame, textvariable=self.wm_bottom_var, width=10).grid(row=0, column=3, padx=5)
        
        # Process button
        self.process_button = ttk.Button(main_frame, text="🚀 开始处理", command=self.start_processing)
        self.process_button.grid(row=4, column=0, columnspan=4, pady=10)
        
        # Progress bar
        self.progress = ttk.Progressbar(main_frame, mode='determinate')
        self.progress.grid(row=5, column=0, columnspan=4, sticky=(tk.W, tk.E), pady=5)
        
        # Log area
        ttk.Label(main_frame, text="处理日志:").grid(row=6, column=0, sticky=tk.NW, pady=5)
        self.log_text = scrolledtext.ScrolledText(main_frame, height=8, state='disabled')
        self.log_text.grid(row=6, column=1, columnspan=3, sticky=(tk.W, tk.E, tk.N, tk.S), pady=5)
        
        # Configure grid weights
        main_frame.rowconfigure(6, weight=1)
    
    def log(self, message):
        self.log_text.config(state='normal')
        self.log_text.insert(tk.END, message + '\n')
        self.log_text.see(tk.END)
        self.log_text.config(state='disabled')
        self.root.update_idletasks()
    
    def select_files(self):
        files = filedialog.askopenfilenames(
            title="选择图片文件",
            filetypes=[("Image files", "*.png *.jpg *.jpeg"), ("All files", "*.*")]
        )
        if files:
            self.add_files(files)
    
    def select_folder(self):
        folder = filedialog.askdirectory(title="选择包含图片的文件夹")
        if folder:
            image_files = []
            for ext in ['*.png', '*.jpg', '*.jpeg']:
                image_files.extend([str(f) for f in Path(folder).glob(ext)])
                image_files.extend([str(f) for f in Path(folder).glob(ext.upper())])
            self.add_files(image_files)
    
    def add_files(self, files):
        for file in files:
            if file not in self.file_paths:
                self.file_paths.append(file)
                self.file_listbox.insert(tk.END, Path(file).name)
        self.log(f"✅ 添加了 {len(files)} 个文件")
    
    def clear_files(self):
        self.file_paths = []
        self.file_listbox.delete(0, tk.END)
        self.log("📋 文件列表已清空")
    
    def remove_watermark(self, input_path, output_path=None):
        if output_path is None:
            output_path = input_path
        
        img = cv2.imread(str(input_path))
        if img is None:
            return False, "无法读取图片"
        
        h, w = img.shape[:2]
        
        # Get watermark position from settings
        right_margin = self.wm_right_var.get()
        bottom_margin = self.wm_bottom_var.get()
        
        wm_x_start = int(w * (100 - right_margin) / 100)
        wm_y_start = int(h * (100 - bottom_margin) / 100)
        
        # Create mask
        mask = np.zeros((h, w), dtype=np.uint8)
        cv2.rectangle(mask, (wm_x_start, wm_y_start), (w, h), 255, -1)
        
        # Smooth edges
        mask = cv2.GaussianBlur(mask, (31, 31), 0)
        mask = mask / 255.0
        
        # Inpainting
        result_telea = cv2.inpaint(img, (mask * 255).astype(np.uint8), 3, cv2.INPAINT_TELEA)
        result_ns = cv2.inpaint(img, (mask * 255).astype(np.uint8), 5, cv2.INPAINT_NS)
        result = cv2.addWeighted(result_telea, 0.6, result_ns, 0.4, 0)
        
        # Refine
        result = self.refine_inpainting(result, img, mask, wm_x_start, wm_y_start, 
                                        w - wm_x_start, h - wm_y_start)
        
        # Save
        cv2.imwrite(str(output_path), result, [cv2.IMWRITE_JPEG_QUALITY, 95])
        return True, "成功"
    
    def refine_inpainting(self, result, original, mask, x, y, w, h):
        margin = 20
        y_start = max(0, y - margin)
        y_end = min(result.shape[0], y + h + margin)
        x_start = max(0, x - margin)
        x_end = min(result.shape[1], x + w + margin)
        
        blend_region = result[y_start:y_end, x_start:x_end]
        blended = cv2.GaussianBlur(blend_region, (5, 5), 0)
        result[y_start:y_end, x_start:x_end] = blended
        return result
    
    def start_processing(self):
        if not self.file_paths:
            messagebox.showwarning("警告", "请先选择要处理的文件！")
            return
        
        if self.processing:
            return
        
        self.processing = True
        self.process_button.config(state='disabled')
        self.progress['maximum'] = len(self.file_paths)
        self.progress['value'] = 0
        
        # Run in thread
        thread = threading.Thread(target=self.process_files)
        thread.start()
    
    def process_files(self):
        success = 0
        failed = []
        
        self.log("\n" + "="*60)
        self.log("🎨 开始处理...")
        self.log("="*60)
        
        for i, filepath in enumerate(self.file_paths, 1):
            filename = Path(filepath).name
            self.log(f"\n[{i}/{len(self.file_paths)}] 处理中: {filename}")
            
            try:
                ok, msg = self.remove_watermark(filepath)
                if ok:
                    self.log(f"   ✅ 成功 - OpenCV Inpainting")
                    success += 1
                else:
                    self.log(f"   ❌ 失败 - {msg}")
                    failed.append(filename)
            except Exception as e:
                self.log(f"   ❌ 错误 - {str(e)}")
                failed.append(filename)
            
            # Update progress
            self.progress['value'] = i
            self.root.update_idletasks()
        
        self.log("\n" + "="*60)
        self.log(f"📊 处理完成:")
        self.log(f"   ✅ 成功: {success}/{len(self.file_paths)}")
        if failed:
            self.log(f"   ❌ 失败: {', '.join(failed)}")
        self.log("="*60)
        
        self.processing = False
        self.process_button.config(state='normal')
        messagebox.showinfo("完成", f"处理完成！\n成功: {success}\n失败: {len(failed)}")

def main():
    if HAS_DND:
        root = TkinterDnD.Tk()
    else:
        root = tk.Tk()
    app = WatermarkRemoverGUI(root)
    root.mainloop()

if __name__ == "__main__":
    main()
