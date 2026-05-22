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
      <div className="card shadow-sm">
        <div className="card-body text-center py-5">
          <i className="fas fa-shopping-cart text-muted" style={{ fontSize: '64px', opacity: 0.3 }}></i>
          <h3 className="fw-bold mt-3">購物車是空的</h3>
          <p className="text-muted mb-4">快去挑選心儀的產品吧！</p>
          <a href="/products" className="btn btn-primary btn-lg">
            <i className="fas fa-shopping-bag me-2"></i>
            去購物
          </a>
        </div>
      </div>
    );
  }

  return (
    <div className="card shadow-sm">
      <div className="card-body p-4">
        {showError && error && (
          <div className="alert alert-danger alert-dismissible fade show" role="alert">
            {error}
            <button type="button" className="btn-close" onClick={() => setShowError(false)}></button>
          </div>
        )}

        {items.length > 0 ? (
          <>
            <div className="table-responsive">
              <table className="table table-hover align-middle">
                <thead className="table-light">
                  <tr>
                    <th>商品</th>
                    <th>名稱</th>
                    <th>單價</th>
                    <th>數量</th>
                    <th>小計</th>
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
          <div className="text-center py-5">
            <i className="fas fa-shopping-cart text-muted" style={{ fontSize: '64px', opacity: 0.3 }}></i>
            <h3 className="fw-bold mt-3">購物車是空的</h3>
            <p className="text-muted mb-4">快去挑選心儀的產品吧！</p>
            <a href="/products" className="btn btn-primary btn-lg">
              <i className="fas fa-shopping-bag me-2"></i>
              去購物
            </a>
          </div>
        )}
      </div>
    </div>
  );
};
