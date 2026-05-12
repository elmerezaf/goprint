import { create } from 'zustand';

export const useCartStore = create((set, get) => ({
  items: [],
  isLoading: false,
  error: null,

  setItems: (items) => set({ items }),

  setLoading: (isLoading) => set({ isLoading }),

  setError: (error) => set({ error }),

  updateQuantity: async (productId, quantity) => {
    set({ isLoading: true, error: null });
    try {
      const response = await fetch('/cart/update', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
        },
        body: JSON.stringify({ product_id: productId, quantity }),
      });

      const data = await response.json();
      
      if (response.ok) {
        const items = get().items.map(item =>
          item.product.pro_id === productId
            ? { ...item, quantity: parseInt(quantity), total: parseFloat(data.itemTotal) }
            : item
        );
        set({ items, isLoading: false });
        return true;
      } else {
        set({ error: data.error || '更新失败', isLoading: false });
        return false;
      }
    } catch (error) {
      set({ error: '网络错误', isLoading: false });
      return false;
    }
  },

  removeItem: async (productId) => {
    set({ isLoading: true, error: null });
    try {
      const response = await fetch('/cart/remove', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
        },
        body: JSON.stringify({ product_id: productId }),
      });

      const data = await response.json();
      
      if (response.ok) {
        const items = get().items.filter(item => item.product.pro_id !== productId);
        set({ items, isLoading: false });
        return true;
      } else {
        set({ error: data.error || '删除失败', isLoading: false });
        return false;
      }
    } catch (error) {
      set({ error: '网络错误', isLoading: false });
      return false;
    }
  },

  clearCart: async () => {
    set({ isLoading: true, error: null });
    try {
      const response = await fetch('/cart/clear', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
        },
      });

      if (response.ok) {
        set({ items: [], isLoading: false });
        return true;
      } else {
        set({ error: '清空失败', isLoading: false });
        return false;
      }
    } catch (error) {
      set({ error: '网络错误', isLoading: false });
      return false;
    }
  },

  getTotal: () => {
    return get().items.reduce((sum, item) => sum + item.total, 0);
  },

  getItemCount: () => {
    return get().items.reduce((sum, item) => sum + item.quantity, 0);
  }
}));
