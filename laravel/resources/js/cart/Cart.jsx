import React, { useEffect, useState } from 'react';
import { useCartStore } from './store/useCartStore';
import { CartItem, CartEmpty, CartSummary } from './components/CartItem';

export const Cart = ({ initialItems = [] }) => {
  const { items, setItems, getTotal, getItemCount, error } = useCartStore();
  const [showError, setShowError] = useState(false);

  useEffect(() => {
    if (initialItems && initialItems.length > 0) {
      setItems(initialItems);
    }
  }, [initialItems]);

  useEffect(() => {
    if (error) {
      setShowError(true);
      const timer = setTimeout(() => setShowError(false), 5000);
      return () => clearTimeout(timer);
    }
  }, [error]);

  const total = getTotal();
  const itemCount = getItemCount();

  if (items.length === 0 && initialItems.length === 0) {
    return (
      <div className="container py-4">
        <h1 className="fw-bold mb-4">购物车</h1>
        <CartEmpty />
      </div>
    );
  }

  return (
    <div className="container py-4">
      <h1 className="fw-bold mb-4">购物车</h1>

      {showError && error && (
        <div className="alert alert-danger alert-dismissible fade show" role="alert">
          {error}
          <button type="button" className="btn-close" onClick={() => setShowError(false)}></button>
        </div>
      )}

      <div className="card shadow-sm">
        <div className="card-body p-4">
          {items.length > 0 ? (
            <>
              <div className="table-responsive">
                <table className="table table-hover align-middle">
                  <thead className="table-light">
                    <tr>
                      <th>商品</th>
                      <th>名称</th>
                      <th>单价</th>
                      <th>数量</th>
                      <th>小计</th>
                      <th>操作</th>
                    </tr>
                  </thead>
                  <tbody>
                    {items.map((item, index) => (
                      <CartItem key={item.product.pro_id || index} item={item} />
                    ))}
                  </tbody>
                </table>
              </div>

              <CartSummary total={total} itemCount={itemCount} />
            </>
          ) : (
            <CartEmpty />
          )}
        </div>
      </div>
    </div>
  );
};
