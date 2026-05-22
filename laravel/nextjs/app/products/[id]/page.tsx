'use client';

import { useEffect, useState } from 'react';
import Image from 'next/image';
import Link from 'next/link';
import { Product } from '../../../types';
import { useCartStore } from '../../../store/cartStore';

export default function ProductDetailPage({ params }: { params: { id: string } }) {
  const [product, setProduct] = useState<Product | null>(null);
  const [loading, setLoading] = useState(true);
  const addItem = useCartStore((state) => state.addItem);

  useEffect(() => {
    async function fetchProduct() {
      try {
        const res = await fetch(`http://127.0.0.1:8000/api/products/${params.id}`);
        if (res.ok) {
          const data = await res.json();
          setProduct(data);
        }
      } catch (error) {
        console.error('Error fetching product:', error);
      } finally {
        setLoading(false);
      }
    }

    fetchProduct();
  }, [params.id]);

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <p className="text-gray-500">Loading...</p>
      </div>
    );
  }

  if (!product) {
    return (
      <div className="min-h-screen bg-gray-50">
        <header className="bg-white shadow-sm">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex justify-between items-center h-16">
              <Link href="/" className="text-2xl font-bold text-blue-600">GoPrint</Link>
            </div>
          </div>
        </header>
        <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div className="text-center py-12">
            <h2 className="text-2xl font-bold text-gray-700 mb-4">Product Not Found</h2>
            <Link href="/products" className="text-blue-600 hover:underline">
              Back to Products
            </Link>
          </div>
        </main>
      </div>
    );
  }

  const imageUrl = product.pro_image
    ? `http://127.0.0.1:8000/storage/products/${product.pro_image}`
    : '/api/placeholder/400/400';

  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <Link href="/" className="text-2xl font-bold text-blue-600">GoPrint</Link>
            <nav className="flex space-x-4">
              <Link href="/" className="text-gray-700 hover:text-blue-600">Home</Link>
              <Link href="/products" className="text-gray-700 hover:text-blue-600">Products</Link>
              <Link href="/cart" className="text-gray-700 hover:text-blue-600">Cart</Link>
            </nav>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <Link href="/products" className="text-blue-600 hover:underline mb-4 inline-block">
          ← Back to Products
        </Link>

        <div className="grid md:grid-cols-2 gap-8">
          <div className="relative bg-white rounded-lg shadow-md overflow-hidden aspect-square">
            <Image
              src={imageUrl}
              alt={product.pro_name}
              fill
              className="object-contain p-8"
              sizes="(max-width: 768px) 100vw, 50vw"
            />
          </div>

          <div>
            <h1 className="text-3xl font-bold mb-4">{product.pro_name}</h1>
            <p className="text-3xl text-blue-600 font-bold mb-6">${product.pro_price.toFixed(2)}</p>
            
            {product.pro_description && (
              <div className="mb-6">
                <h2 className="text-xl font-semibold mb-2">Description</h2>
                <p className="text-gray-600">{product.pro_description}</p>
              </div>
            )}

            {product.pro_stock !== undefined && (
              <p className={`mb-6 ${product.pro_stock > 0 ? 'text-green-600' : 'text-red-600'}`}>
                {product.pro_stock > 0 
                  ? `${product.pro_stock} in stock` 
                  : 'Out of stock'}
              </p>
            )}

            <button
              onClick={() => addItem(product)}
              disabled={product.pro_stock !== undefined && product.pro_stock <= 0}
              className="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
            >
              Add to Cart
            </button>
          </div>
        </div>
      </main>

      <footer className="bg-gray-800 text-white py-8 mt-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <p>© 2024 GoPrint. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}
