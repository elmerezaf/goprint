import React from 'react';
import { fabric } from 'fabric';
import { useDesignerStore } from '../store/useDesignerStore';

export const ShapePanel = () => {
  const { canvas, saveToHistory } = useDesignerStore();

  const addShape = (shapeType) => {
    if (!canvas) return;

    let shape;
    const center = { x: canvas.width / 2, y: canvas.height / 2 };

    switch (shapeType) {
      case 'rectangle':
        shape = new fabric.Rect({
          left: center.x,
          top: center.y,
          originX: 'center',
          originY: 'center',
          width: 100,
          height: 80,
          fill: 'transparent',
          stroke: '#333333',
          strokeWidth: 2
        });
        break;

      case 'circle':
        shape = new fabric.Circle({
          left: center.x,
          top: center.y,
          originX: 'center',
          originY: 'center',
          radius: 50,
          fill: 'transparent',
          stroke: '#333333',
          strokeWidth: 2
        });
        break;

      case 'triangle':
        shape = new fabric.Triangle({
          left: center.x,
          top: center.y,
          originX: 'center',
          originY: 'center',
          width: 100,
          height: 100,
          fill: 'transparent',
          stroke: '#333333',
          strokeWidth: 2
        });
        break;

      case 'line':
        shape = new fabric.Line([50, 50, 200, 50], {
          stroke: '#333333',
          strokeWidth: 2
        });
        break;

      case 'star':
        const points = [];
        for (let i = 0; i < 5; i++) {
          points.push({
            x: Math.cos((18 + i * 72) * Math.PI / 180) * 40,
            y: Math.sin((18 + i * 72) * Math.PI / 180) * 40
          });
          points.push({
            x: Math.cos((54 + i * 72) * Math.PI / 180) * 15,
            y: Math.sin((54 + i * 72) * Math.PI / 180) * 15
          });
        }
        shape = new fabric.Polygon(points, {
          left: center.x,
          top: center.y,
          originX: 'center',
          originY: 'center',
          fill: 'transparent',
          stroke: '#333333',
          strokeWidth: 2
        });
        break;

      default:
        return;
    }

    canvas.add(shape);
    canvas.setActiveObject(shape);
    canvas.renderAll();
    saveToHistory();
  };

  return (
    <div className="panel shape-panel">
      <h3>形状工具</h3>
      <div className="shape-grid">
        <button className="shape-btn" onClick={() => addShape('rectangle')} title="Rectangle">
          <i className="far fa-square"></i>
        </button>
        <button className="shape-btn" onClick={() => addShape('circle')} title="Circle">
          <i className="far fa-circle"></i>
        </button>
        <button className="shape-btn" onClick={() => addShape('triangle')} title="Triangle">
          <i className="fas fa-caret-up"></i>
        </button>
        <button className="shape-btn" onClick={() => addShape('line')} title="Line">
          <i className="fas fa-minus"></i>
        </button>
        <button className="shape-btn" onClick={() => addShape('star')} title="Star">
          <i className="far fa-star"></i>
        </button>
      </div>
    </div>
  );
};
