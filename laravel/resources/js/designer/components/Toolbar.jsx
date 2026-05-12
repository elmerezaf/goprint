import React from 'react';
import { useDesignerStore } from '../store/useDesignerStore';

export const Toolbar = () => {
  const { undo, redo, canUndo, canRedo, clearCanvas, activeTool, setActiveTool } = useDesignerStore();

  return (
    <div className="designer-toolbar">
      <div className="toolbar-section">
        <button
          className={`toolbar-btn ${activeTool === 'select' ? 'active' : ''}`}
          onClick={() => setActiveTool('select')}
          title="Select"
        >
          <i className="fas fa-mouse-pointer"></i>
        </button>
        <button
          className={`toolbar-btn ${activeTool === 'move' ? 'active' : ''}`}
          onClick={() => setActiveTool('move')}
          title="Move"
        >
          <i className="fas fa-arrows-alt"></i>
        </button>
      </div>

      <div className="toolbar-divider"></div>

      <div className="toolbar-section">
        <button
          className="toolbar-btn"
          onClick={undo}
          disabled={!canUndo()}
          title="Undo (Ctrl+Z)"
        >
          <i className="fas fa-undo"></i>
        </button>
        <button
          className="toolbar-btn"
          onClick={redo}
          disabled={!canRedo()}
          title="Redo (Ctrl+Y)"
        >
          <i className="fas fa-redo"></i>
        </button>
      </div>

      <div className="toolbar-divider"></div>

      <div className="toolbar-section">
        <button className="toolbar-btn" onClick={clearCanvas} title="Clear Canvas">
          <i className="fas fa-trash"></i>
        </button>
      </div>

      <div className="toolbar-divider"></div>

      <div className="toolbar-section">
        <button
          className={`toolbar-btn ${activeTool === 'zoom-in' ? 'active' : ''}`}
          onClick={() => setActiveTool('zoom-in')}
          title="Zoom In"
        >
          <i className="fas fa-search-plus"></i>
        </button>
        <button
          className={`toolbar-btn ${activeTool === 'zoom-out' ? 'active' : ''}`}
          onClick={() => setActiveTool('zoom-out')}
          title="Zoom Out"
        >
          <i className="fas fa-search-minus"></i>
        </button>
      </div>
    </div>
  );
};
