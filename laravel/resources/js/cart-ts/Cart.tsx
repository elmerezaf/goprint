import React, { useEffect, useState } from 'react';
import { useCartStore } from './store/useCartStore';
import { CartItemComponent, CartEmpty, CartSummary } from './components/CartItem';
import { CartItem as CartItemType } from './types';

interface CartProps {
  initialItems?: CartItemType[];
}

export const Cart: React.FC<CartProps> = ({ initialItems = [] }) => {
  const { items, setItems, getTotal, getItemCount, error } = useCartStore();
  const [showError, setShowError] = useState(false);
  const [hasInitialized, setHasInitialized] = useState(false);

  useEffect(() => {
    if (!hasInitialized && initialItems && initialItems.length > 0) {
      setItems(initialItems);
      setHasInitialized(true);
    }
  }, [initialItems, hasInitialized]);

  useEffect(() => {
    if (error) {
      setShowError(true);
      const timer = setTimeout(() => setShowError(false), 5000);
      return () => clearTimeout(timer);
    }
  }, [error]);

  const total = getTotal();
  const itemCount = getItemCount();

  return (
    <div className="container py-5">
      <h1 className="fw-bold mb-4">購物車</h1>

      {showError && error && (
        <div className="alert alert-danger alert-dismissible fade show" role="alert">
          {error}
          <button type="button" className="btn-close" onClick={() => setShowError(false)}></button>
        </div>
      )}

      {items.length > 0 ? (
        <div className="card shadow-sm">
          <div className="card-body p-4">
            <div className="table-responsive">
              <table className="table table-hover align-middle">
                <thead className="table-light">
                  <tr>
                    <th></th>
                    <th>商品</th>
                    <th>單價</th>
                    <th>數量</th>
                    <th>小計</th>
                    <th>操作</th>
                  </tr>
                </thead>
                <tbody>
                  {items.map((item) => (
                    <CartItemComponent key={item.product.pro_id} item={item} />
                  ))}
                </tbody>
              </table>
            </div>
            <CartSummary total={total} itemCount={itemCount} />
          </div>
        </div>
      ) : (
        <CartEmpty />
      )}
    </div>
  );
};
