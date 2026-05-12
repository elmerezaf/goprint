import React, { useState, useEffect } from 'react';
import { useCartStore } from '../store/useCartStore';

export const CartItem = ({ item }) => {
  const { updateQuantity, removeItem, isLoading } = useCartStore();
  const [localQuantity, setLocalQuantity] = useState(item.quantity);

  const handleQuantityChange = async (newQuantity) => {
    if (newQuantity < 1 || newQuantity > 999) return;
    setLocalQuantity(newQuantity);
    await updateQuantity(item.product.pro_id, newQuantity);
  };

  const handleRemove = async () => {
    if (window.confirm('确定要删除这个商品吗？')) {
      await removeItem(item.product.pro_id);
    }
  };

  return (
    <tr>
      <td style={{ width: '80px' }}>
        {item.product.pro_image ? (
          <img
            src={`/storage/products/${item.product.pro_image}`}
            alt={item.product.pro_name}
            className="img-fluid rounded"
            style={{ width: '60px', height: '60px', objectFit: 'cover' }}
          />
        ) : (
          <div
            className="bg-primary bg-opacity-10 text-primary rounded d-flex align-items-center justify-content-center"
            style={{ width: '60px', height: '60px', fontSize: '24px' }}
          >
            <i className="fas fa-print"></i>
          </div>
        )}
      </td>
      <td className="fw-bold">{item.product.pro_name}</td>
      <td>${item.price.toFixed(2)}</td>
      <td style={{ width: '180px' }}>
        <div className="d-flex align-items-center gap-2">
          <button
            className="btn btn-sm btn-outline-secondary"
            onClick={() => handleQuantityChange(localQuantity - 1)}
            disabled={localQuantity <= 1 || isLoading}
          >
            <i className="fas fa-minus"></i>
          </button>
          <input
            type="number"
            value={localQuantity}
            onChange={(e) => setLocalQuantity(parseInt(e.target.value) || 1)}
            onBlur={(e) => handleQuantityChange(parseInt(e.target.value) || 1)}
            className="form-control text-center"
            style={{ width: '70px' }}
            min="1"
            max="999"
          />
          <button
            className="btn btn-sm btn-outline-secondary"
            onClick={() => handleQuantityChange(localQuantity + 1)}
            disabled={localQuantity >= 999 || isLoading}
          >
            <i className="fas fa-plus"></i>
          </button>
        </div>
      </td>
      <td className="fw-bold text-primary">${item.total.toFixed(2)}</td>
      <td>
        <button
          className="btn btn-sm btn-outline-danger"
          onClick={handleRemove}
          disabled={isLoading}
        >
          <i className="fas fa-trash"></i>
        </button>
      </td>
    </tr>
  );
};

export const CartEmpty = () => {
  return (
    <div className="card shadow-sm">
      <div className="card-body text-center py-5">
        <i className="fas fa-shopping-cart text-muted" style={{ fontSize: '64px', opacity: 0.3 }}></i>
        <h3 className="fw-bold mt-3">购物车是空的</h3>
        <p className="text-muted mb-4">快去挑选心仪的产品吧！</p>
        <a href="/products" className="btn btn-primary btn-lg">
          <i className="fas fa-shopping-bag me-2"></i>
          去购物
        </a>
      </div>
    </div>
  );
};

export const CartSummary = ({ total, itemCount }) => {
  const { clearCart, isLoading } = useCartStore();

  const handleClear = async () => {
    if (window.confirm('确定要清空购物车吗？')) {
      await clearCart();
    }
  };

  return (
    <div className="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
      <div>
        <h4 className="fw-bold">
          共 {itemCount} 件商品
          <span className="text-primary ms-3">合计: ${total.toFixed(2)}</span>
        </h4>
      </div>
      <div className="d-flex gap-2 mt-2 mt-sm-0">
        <button
          className="btn btn-outline-secondary"
          onClick={handleClear}
          disabled={isLoading}
        >
          <i className="fas fa-trash-alt me-2"></i>
          清空购物车
        </button>
        <a href="/products" className="btn btn-outline-primary">
          <i className="fas fa-arrow-left me-2"></i>
          继续购物
        </a>
        <a href="/order/create" className="btn btn-warning text-white">
          <i className="fas fa-credit-card me-2"></i>
          去结账
        </a>
      </div>
    </div>
  );
};
