export interface Product {
  id: number;
  pro_id: number;
  pro_name: string;
  pro_price: number;
  pro_description: string;
  pro_image?: string;
  category_id?: number;
  pro_stock?: number;
}

export interface CartItem {
  product: Product;
  quantity: number;
}

export interface CartState {
  items: CartItem[];
  addItem: (product: Product) => void;
  removeItem: (productId: number) => void;
  updateQuantity: (productId: number, quantity: number) => void;
  clearCart: () => void;
  getTotal: () => number;
  getItemCount: () => number;
}
