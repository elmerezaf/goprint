import { create } from 'zustand';
import { CartState, CartActions, CartItem, Product } from '../types';

// 完整的Cart Store类型
type CartStore = CartState & CartActions;

export const useCartStore = create<CartStore>((set, get) => ({
  items: [],
  error: null,
  isLoading: false,

  addItem: (product: Product, quantity = 1) => {
    set((state) => {
      const existingItem = state.items.find(
        (item) => item.product.pro_id === product.pro_id
      );

      if (existingItem) {
        return {
          items: state.items.map((item) =>
            item.product.pro_id === product.pro_id
              ? { ...item, quantity: item.quantity + quantity }
              : item
          ),
        };
      }

      return {
        items: [...state.items, { product, quantity }],
      };
    });
  },

  removeItem: (productId: number | string) => {
    set((state) => ({
      items: state.items.filter((item) => item.product.pro_id !== productId),
    }));
  },

  updateQuantity: (productId: number | string, quantity: number) => {
    if (quantity <= 0) {
      get().removeItem(productId);
      return;
    }

    set((state) => ({
      items: state.items.map((item) =>
        item.product.pro_id === productId ? { ...item, quantity } : item
      ),
    }));
  },

  clearCart: () => {
    set({ items: [] });
  },

  getTotal: () => {
    return get().items.reduce((total, item) => {
      return total + item.product.pro_price * item.quantity;
    }, 0);
  },

  getItemCount: () => {
    return get().items.reduce((count, item) => count + item.quantity, 0);
  },

  setError: (error: string | null) => {
    set({ error });
  },

  setItems: (items: CartItem[]) => {
    set({ items });
  },
}));