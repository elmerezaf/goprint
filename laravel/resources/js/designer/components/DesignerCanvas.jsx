import React, { useEffect, useRef, useState } from 'react';
import { fabric } from 'fabric';
import { useDesignerStore } from './store/useDesignerStore';

export const DesignerCanvas = ({ productImage, canvasWidth = 600, canvasHeight = 600 }) => {
  const canvasRef = useRef(null);
  const fabricRef = useRef(null);
  const { setCanvas, saveToHistory, setSelectedObject, canvas } = useDesignerStore();

  useEffect(() => {
    if (!canvasRef.current || fabricRef.current) return;

    const fabricCanvas = new fabric.Canvas(canvasRef.current, {
      width: canvasWidth,
      height: canvasHeight,
      backgroundColor: '#ffffff',
      preserveObjectStacking: true
    });

    fabricRef.current = fabricCanvas;
    setCanvas(fabricCanvas);

    if (productImage) {
      fabric.Image.fromURL(productImage, (img) => {
        if (img && canvasWidth && canvasHeight) {
          const scale = Math.min(
            (canvasWidth * 0.8) / img.width,
            (canvasHeight * 0.8) / img.height
          );
          img.set({
            left: canvasWidth / 2,
            top: canvasHeight / 2,
            originX: 'center',
            originY: 'center',
            scaleX: scale,
            scaleY: scale,
            selectable: false,
            evented: false
          });
          fabricCanvas.add(img);
          fabricCanvas.sendToBack(img);
        }
      }, { crossOrigin: 'anonymous' });
    }

    fabricCanvas.on('selection:created', (e) => {
      setSelectedObject(e.selected[0]);
    });

    fabricCanvas.on('selection:updated', (e) => {
      setSelectedObject(e.selected[0]);
    });

    fabricCanvas.on('selection:cleared', () => {
      setSelectedObject(null);
    });

    fabricCanvas.on('object:modified', () => {
      saveToHistory();
    });

    fabricCanvas.on('object:added', () => {
      saveToHistory();
    });

    return () => {
      fabricCanvas.dispose();
      fabricRef.current = null;
    };
  }, [canvasWidth, canvasHeight, productImage]);

  return (
    <div className="designer-canvas-container">
      <canvas ref={canvasRef} />
    </div>
  );
};
