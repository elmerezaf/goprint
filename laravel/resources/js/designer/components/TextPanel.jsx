import React, { useState } from 'react';
import { fabric } from 'fabric';
import { useDesignerStore } from '../store/useDesignerStore';

export const TextPanel = () => {
  const { canvas, selectedObject, saveToHistory } = useDesignerStore();
  const [fontFamily, setFontFamily] = useState('Arial');
  const [fontSize, setFontSize] = useState(24);
  const [fontWeight, setFontWeight] = useState('normal');
  const [textColor, setTextColor] = useState('#000000');
  const [textAlign, setTextAlign] = useState('left');

  const addText = () => {
    if (!canvas) return;

    const text = new fabric.IText('双击编辑文本', {
      left: canvas.width / 2,
      top: canvas.height / 2,
      originX: 'center',
      originY: 'center',
      fontFamily: fontFamily,
      fontSize: fontSize,
      fontWeight: fontWeight,
      fill: textColor,
      textAlign: textAlign
    });

    canvas.add(text);
    canvas.setActiveObject(text);
    canvas.renderAll();
    saveToHistory();
  };

  const updateSelectedText = (property, value) => {
    const activeObj = canvas?.getActiveObject();
    if (!activeObj) return;

    activeObj.set(property, value);
    canvas.renderAll();
    saveToHistory();

    if (property === 'fontFamily') setFontFamily(value);
    if (property === 'fontSize') setFontSize(value);
    if (property === 'fontWeight') setFontWeight(value);
    if (property === 'fill') setTextColor(value);
    if (property === 'textAlign') setTextAlign(value);
  };

  const fonts = [
    'Arial', 'Helvetica', 'Times New Roman', 'Georgia',
    'Verdana', 'Courier New', 'Impact', 'Comic Sans MS'
  ];

  return (
    <div className="panel text-panel">
      <h3>文本工具</h3>

      <button className="panel-btn primary" onClick={addText}>
        <i className="fas fa-plus"></i> 添加文本
      </button>

      {selectedObject && selectedObject.type === 'i-text' && (
        <div className="text-controls">
          <div className="control-group">
            <label>字体</label>
            <select
              value={fontFamily}
              onChange={(e) => updateSelectedText('fontFamily', e.target.value)}
            >
              {fonts.map(font => (
                <option key={font} value={font}>{font}</option>
              ))}
            </select>
          </div>

          <div className="control-group">
            <label>字号</label>
            <input
              type="number"
              value={fontSize}
              min="8"
              max="200"
              onChange={(e) => updateSelectedText('fontSize', parseInt(e.target.value))}
            />
          </div>

          <div className="control-group">
            <label>样式</label>
            <div className="btn-group">
              <button
                className={fontWeight === 'normal' ? 'active' : ''}
                onClick={() => updateSelectedText('fontWeight', 'normal')}
              >
                常规
              </button>
              <button
                className={fontWeight === 'bold' ? 'active' : ''}
                onClick={() => updateSelectedText('fontWeight', 'bold')}
              >
                粗体
              </button>
            </div>
          </div>

          <div className="control-group">
            <label>对齐</label>
            <div className="btn-group">
              <button
                className={textAlign === 'left' ? 'active' : ''}
                onClick={() => updateSelectedText('textAlign', 'left')}
              >
                <i className="fas fa-align-left"></i>
              </button>
              <button
                className={textAlign === 'center' ? 'active' : ''}
                onClick={() => updateSelectedText('textAlign', 'center')}
              >
                <i className="fas fa-align-center"></i>
              </button>
              <button
                className={textAlign === 'right' ? 'active' : ''}
                onClick={() => updateSelectedText('textAlign', 'right')}
              >
                <i className="fas fa-align-right"></i>
              </button>
            </div>
          </div>

          <div className="control-group">
            <label>颜色</label>
            <input
              type="color"
              value={textColor}
              onChange={(e) => updateSelectedText('fill', e.target.value)}
            />
          </div>
        </div>
      )}
    </div>
  );
};
