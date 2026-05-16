// 产品类型
export interface Product {
  pro_id: number | string;
  pro_name: string;
  pro_price: number;
  pro_image?: string;
  pro_desc?: string;
}

// 购物车项类型
export interface CartItem {
  product: Product;
  quantity: number;
  custom_design?: string;
}

// 购物车状态类型
export interface CartState {
  items: CartItem[];
  error: string | null;
  isLoading: boolean;
}

// 购物车操作类型
export interface CartActions {
  addItem: (product: Product, quantity?: number) => void;
  removeItem: (productId: number | string) => void;
  updateQuantity: (productId: number | string, quantity: number) => void;
  clearCart: () => void;
  getTotal: () => number;
  getItemCount: () => number;
  setError: (error: string | null) => void;
  setItems: (items: CartItem[]) => void;
}