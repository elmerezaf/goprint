import { create } from 'zustand';

export const useDesignerStore = create((set, get) => ({
  canvas: null,
  selectedObject: null,
  history: [],
  historyIndex: -1,
  activeTool: 'select',
  activePanel: 'text',
  canvasWidth: 600,
  canvasHeight: 600,
  productImage: null,
  productPrice: 0,
  productName: '',

  setCanvas: (canvas) => set({ canvas }),

  setSelectedObject: (obj) => set({ selectedObject: obj }),

  setActiveTool: (tool) => set({ activeTool: tool }),

  setActivePanel: (panel) => set({ activePanel: panel }),

  setProductInfo: (name, price, image) => set({
    productName: name,
    productPrice: price,
    productImage: image
  }),

  saveToHistory: () => {
    const { canvas, history, historyIndex } = get();
    if (!canvas) return;

    const json = JSON.stringify(canvas.toJSON());
    const newHistory = history.slice(0, historyIndex + 1);
    newHistory.push(json);

    if (newHistory.length > 50) {
      newHistory.shift();
    }

    set({
      history: newHistory,
      historyIndex: newHistory.length - 1
    });
  },

  undo: () => {
    const { canvas, history, historyIndex } = get();
    if (!canvas || historyIndex <= 0) return;

    const newIndex = historyIndex - 1;
    canvas.loadFromJSON(JSON.parse(history[newIndex]), () => {
      canvas.renderAll();
      set({ historyIndex: newIndex });
    });
  },

  redo: () => {
    const { canvas, history, historyIndex } = get();
    if (!canvas || historyIndex >= history.length - 1) return;

    const newIndex = historyIndex + 1;
    canvas.loadFromJSON(JSON.parse(history[newIndex]), () => {
      canvas.renderAll();
      set({ historyIndex: newIndex });
    });
  },

  canUndo: () => get().historyIndex > 0,
  canRedo: () => get().historyIndex < get().history.length - 1,

  clearCanvas: () => {
    const { canvas } = get();
    if (!canvas) return;
    canvas.clear();
    canvas.backgroundColor = '#ffffff';
    get().saveToHistory();
  },

  exportDesign: () => {
    const { canvas } = get();
    if (!canvas) return null;
    return canvas.toDataURL({
      format: 'png',
      quality: 1,
      multiplier: 2
    });
  },

  loadTemplate: (templateData) => {
    const { canvas } = get();
    if (!canvas || !templateData) return;

    canvas.loadFromJSON(templateData, () => {
      canvas.renderAll();
      get().saveToHistory();
    });
  }
}));
