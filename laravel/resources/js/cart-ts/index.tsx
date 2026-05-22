import React from 'react';
import { createRoot } from 'react-dom/client';
import { Cart } from './Cart';

const container = document.getElementById('cart-root');
if (container) {
    const initialItems = JSON.parse(container.dataset.cartItems || '[]');
    const root = createRoot(container);
    root.render(<Cart initialItems={initialItems} />);
}
