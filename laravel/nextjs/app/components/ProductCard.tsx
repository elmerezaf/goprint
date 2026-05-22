'use client';

import Image from 'next/image';
import Link from 'next/link';
import { Product } from '../../types';
import { useCartStore } from '../../store/cartStore';

export default function ProductCard({ product }: { product: Product }) {
  const addItem = useCartStore((state) => state.addItem);
  
  const imageUrl = product.pro_image
    ? `http://127.0.0.1:8000/storage/products/${product.pro_image}`
    : 'data:image/svg+xml,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200"><rect fill="%23e5e7eb" width="200" height="200"/><text x="100" y="110" font-size="40" text-anchor="middle" fill="%239ca3af">🖨️</text></svg>');

  const productId = product.pro_id || product.id;

  return (
    <div className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
      <Link href={`/products/${productId}`}>
        <div className="relative h-48 overflow-hidden">
          <Image
            src={imageUrl}
            alt={product.pro_name}
            fill
            className="object-cover"
            sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 25vw"
          />
        </div>
      </Link>
      
      <div className="p-4">
        <Link href={`/products/${productId}`}>
          <h3 className="font-semibold text-lg mb-2 line-clamp-1 hover:text-blue-600">
            {product.pro_name}
          </h3>
        </Link>
        
        <p className="text-gray-600 text-sm mb-3 line-clamp-2">
          {product.pro_description || 'High-quality printing product'}
        </p>
        
        <div className="flex justify-between items-center">
          <span className="text-xl font-bold text-blue-600">
            ${product.pro_price.toFixed(2)}
          </span>
          <button
            onClick={() => addItem(product)}
            className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium"
          >
            Add to Cart
          </button>
        </div>
      </div>
    </div>
  );
}
