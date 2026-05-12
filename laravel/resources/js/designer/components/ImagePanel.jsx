import React, { useRef } from 'react';
import { fabric } from 'fabric';
import { useDesignerStore } from '../store/useDesignerStore';

export const ImagePanel = () => {
  const { canvas, saveToHistory } = useDesignerStore();
  const fileInputRef = useRef(null);

  const handleImageUpload = (e) => {
    const file = e.target.files[0];
    if (!file || !canvas) return;

    const reader = new FileReader();
    reader.onload = (event) => {
      fabric.Image.fromURL(event.target.result, (img) => {
        if (img) {
          const scale = Math.min(
            (canvas.width * 0.6) / img.width,
            (canvas.height * 0.6) / img.height
          );

          img.set({
            left: canvas.width / 2,
            top: canvas.height / 2,
            originX: 'center',
            originY: 'center',
            scaleX: scale,
            scaleY: scale
          });

          canvas.add(img);
          canvas.setActiveObject(img);
          canvas.renderAll();
          saveToHistory();
        }
      }, { crossOrigin: 'anonymous' });
    };
    reader.readAsDataURL(file);
  };

  const triggerFileInput = () => {
    fileInputRef.current?.click();
  };

  const presetImages = [
    { name: 'Logo 1', url: '/images/presets/logo1.png' },
    { name: 'Logo 2', url: '/images/presets/logo2.png' },
    { name: 'Icon Set', url: '/images/presets/icons.png' }
  ];

  return (
    <div className="panel image-panel">
      <h3>图片工具</h3>

      <button className="panel-btn primary" onClick={triggerFileInput}>
        <i className="fas fa-upload"></i> 上传图片
      </button>
      <input
        ref={fileInputRef}
        type="file"
        accept="image/*"
        onChange={handleImageUpload}
        style={{ display: 'none' }}
      />

      <div className="preset-images">
        <h4>预设图片</h4>
        <div className="preset-grid">
          {presetImages.map((img, index) => (
            <button
              key={index}
              className="preset-img-btn"
              onClick={() => {
                fabric.Image.fromURL(img.url, (fabricImg) => {
                  if (fabricImg && canvas) {
                    const scale = Math.min(
                      (canvas.width * 0.4) / fabricImg.width,
                      (canvas.height * 0.4) / fabricImg.height
                    );
                    fabricImg.set({
                      left: canvas.width / 2,
                      top: canvas.height / 2,
                      originX: 'center',
                      originY: 'center',
                      scaleX: scale,
                      scaleY: scale
                    });
                    canvas.add(fabricImg);
                    canvas.setActiveObject(fabricImg);
                    canvas.renderAll();
                    saveToHistory();
                  }
                }, { crossOrigin: 'anonymous' });
              }}
              title={img.name}
            >
              <img src={img.url} alt={img.name} />
            </button>
          ))}
        </div>
      </div>
    </div>
  );
};
