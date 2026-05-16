import React, { useEffect, useState } from 'react';
import { useCartStore } from './store/useCartStore';
import { Product, CartItem as CartItemType } from './types';

// 购物车项组件
const CartItemComponent: React.FC<{ item: CartItemType }> = ({ item }) => {
  const { updateQuantity, removeItem } = useCartStore();

  return (
    <tr>
      <td>
        <div className="d-flex align-items-center">
          {item.product.pro_image && (
            <img
              src={`/storage/products/${item.product.pro_image}`}
              alt={item.product.pro_name}
              style={{ width: '50px', height: '50px', objectFit: 'cover', borderRadius: '4px' }}
            />
          )}
          <span className="ms-2">{item.product.pro_name}</span>
        </div>
      </td>
      <td>${item.product.pro_price.toFixed(2)}</td>
      <td>
        <div className="input-group" style={{ width: '120px' }}>
          <button
            className="btn btn-outline-secondary"
            onClick={() => updateQuantity(item.product.pro_id, item.quantity - 1)}
          >
            -
          </button>
          <input
            type="number"
            className="form-control text-center"
            value={item.quantity}
            min="1"
            onChange={(e) =>
              updateQuantity(item.product.pro_id, parseInt(e.target.value) || 1)
            }
          />
          <button
            className="btn btn-outline-secondary"
            onClick={() => updateQuantity(item.product.pro_id, item.quantity + 1)}
          >
            +
          </button>
        </div>
      </td>
      <td>${(item.product.pro_price * item.quantity).toFixed(2)}</td>
      <td>
        <button
          className="btn btn-danger btn-sm"
          onClick={() => removeItem(item.product.pro_id)}
        >
          <i className="fas fa-trash"></i>
        </button>
      </td>
    </tr>
  );
};

// 购物车为空组件
const CartEmpty: React.FC = () => (
  <div className="text-center py-5">
    <i className="fas fa-shopping-cart" style={{ fontSize: '4rem', color: '#dee2e6' }}></i>
    <p className="mt-3 text-muted">购物车是空的</p>
    <a href="/products" className="btn btn-primary mt-2">
      去购物
    </a>
  </div>
);

// 购物车摘要组件
const CartSummary: React.FC<{ total: number; itemCount: number }> = ({ total, itemCount }) => (
  <div className="mt-4">
    <div className="d-flex justify-content-between align-items-center">
      <div>
        <h5>总计</h5>
        <p className="text-muted">{itemCount} 件商品</p>
      </div>
      <div>
        <h4 className="text-primary">${total.toFixed(2)}</h4>
        <button className="btn btn-success btn-lg mt-2">
          结算
        </button>
      </div>
    </div>
  </div>
);

// 主购物车组件
export const Cart: React.FC<{ initialItems?: CartItemType[] }> = ({ initialItems = [] }) => {
  const { items, setItems, getTotal, getItemCount, error } = useCartStore();
  const [showError, setShowError] = useState(false);

  useEffect(() => {
    if (initialItems && initialItems.length > 0) {
      setItems(initialItems);
    }
  }, [initialItems, setItems]);

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
                      <th>单价</th>
                      <th>数量</th>
                      <th>小计</th>
                      <th>操作</th>
                    </tr>
                  </thead>
                  <tbody>
                    {items.map((item, index) => (
                      <CartItemComponent key={item.product.pro_id || index} item={item} />
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