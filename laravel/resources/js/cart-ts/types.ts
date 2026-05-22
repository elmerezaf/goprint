export interface Product {
  pro_id: number;
  pro_name: string;
  pro_price: number;
  pro_image: string | null;
}

export interface CartItem {
  product: Product;
  quantity: number;
  price: number;
  total: number;
}

export interface CartStore {
  items: CartItem[];
  isLoading: boolean;
  error: string | null;
  setItems: (items: CartItem[]) => void;
  setLoading: (isLoading: boolean) => void;
  setError: (error: string | null) => void;
  updateQuantity: (productId: number, quantity: number) => Promise<boolean>;
  removeItem: (productId: number) => Promise<boolean>;
  clearCart: () => Promise<boolean>;
  getTotal: () => number;
  getItemCount: () => number;
}
