import Link from 'next/link';
import ProductCard from '../components/ProductCard';
import { Product } from '../../types';

async function fetchProducts(): Promise<Product[]> {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/products', {
      cache: 'no-store',
    });
    
    if (!res.ok) {
      console.error('Failed to fetch products');
      return [];
    }
    
    return res.json();
  } catch (error) {
    console.error('Error fetching products:', error);
    return [];
  }
}

export default async function ProductsPage() {
  const products = await fetchProducts();
  
  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <Link href="/" className="text-2xl font-bold text-blue-600">GoPrint</Link>
            <nav className="flex space-x-4">
              <Link href="/" className="text-gray-700 hover:text-blue-600">Home</Link>
              <Link href="/products" className="text-blue-600 font-semibold">Products</Link>
              <Link href="/cart" className="text-gray-700 hover:text-blue-600">Cart</Link>
            </nav>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 className="text-3xl font-bold mb-8">All Products</h1>
        
        {products.length === 0 ? (
          <div className="text-center py-12">
            <p className="text-gray-500 text-lg">No products available</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {products.map((product) => (
              <ProductCard key={product.id || product.pro_id} product={product} />
            ))}
          </div>
        )}
      </main>

      <footer className="bg-gray-800 text-white py-8 mt-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <p>© 2024 GoPrint. All rights reserved.</p>
        </div>
      </footer>
    </div>
  );
}
