import { Metadata } from 'next';
import Link from 'next/link';
import ProductCard from './components/ProductCard';
import { Product } from '../types';

export const metadata: Metadata = {
  title: 'GoPrint - Professional Printing Services',
  description: 'Discover high-quality printing products and services in Hong Kong. Business cards, flyers, posters, and more.',
};

async function fetchProducts(): Promise<Product[]> {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/products', {
      cache: 'no-store',
    });
    
    if (!res.ok) {
      throw new Error('Failed to fetch products');
    }
    
    return res.json();
  } catch (error) {
    console.error('Error fetching products:', error);
    return [];
  }
}

export default async function Home() {
  const products = await fetchProducts();
  const featuredProducts = products.slice(0, 8);
  
  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <div className="flex items-center">
              <Link href="/" className="text-2xl font-bold text-blue-600">GoPrint</Link>
            </div>
            <nav className="flex space-x-4">
              <Link href="/" className="text-blue-600 font-semibold">Home</Link>
              <Link href="/products" className="text-gray-700 hover:text-blue-600">Products</Link>
              <Link href="/cart" className="text-gray-700 hover:text-blue-600">Cart</Link>
            </nav>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section className="mb-12">
          <div className="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-8 text-white">
            <h1 className="text-4xl font-bold mb-4">Professional Printing Services</h1>
            <p className="text-xl mb-6">High-quality printing for your business needs</p>
            <Link href="/products" className="inline-block bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
              Browse Products
            </Link>
          </div>
        </section>

        <section className="mb-12">
          <div className="flex justify-between items-center mb-6">
            <h2 className="text-2xl font-bold">Featured Products</h2>
            <Link href="/products" className="text-blue-600 hover:underline">
              View All →
            </Link>
          </div>
          
          {featuredProducts.length === 0 ? (
            <div className="text-center py-12 bg-white rounded-lg">
              <p className="text-gray-500">No products available</p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              {featuredProducts.map((product) => (
                <ProductCard key={product.id || product.pro_id} product={product} />
              ))}
            </div>
          )}
        </section>

        <section className="grid md:grid-cols-3 gap-6 mb-12">
          <div className="bg-white p-6 rounded-lg shadow-md text-center">
            <div className="text-4xl mb-4">🚚</div>
            <h3 className="text-lg font-semibold mb-2">Fast Delivery</h3>
            <p className="text-gray-600">Express delivery across Hong Kong</p>
          </div>
          <div className="bg-white p-6 rounded-lg shadow-md text-center">
            <div className="text-4xl mb-4">🎨</div>
            <h3 className="text-lg font-semibold mb-2">Design Service</h3>
            <p className="text-gray-600">Professional design assistance</p>
          </div>
          <div className="bg-white p-6 rounded-lg shadow-md text-center">
            <div className="text-4xl mb-4">💰</div>
            <h3 className="text-lg font-semibold mb-2">Bulk Discounts</h3>
            <p className="text-gray-600">Save more when you order more</p>
          </div>
        </section>
      </main>

      <footer className="bg-gray-800 text-white py-8 mt-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
              <h3 className="font-bold mb-4 text-lg">GoPrint</h3>
              <p className="text-gray-400">Professional printing services in Hong Kong</p>
            </div>
            <div>
              <h3 className="font-bold mb-4">Products</h3>
              <ul className="space-y-2">
                <li><a href="#" className="text-gray-400 hover:text-white">Business Cards</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Flyers</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Posters</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Banners</a></li>
              </ul>
            </div>
            <div>
              <h3 className="font-bold mb-4">Services</h3>
              <ul className="space-y-2">
                <li><a href="#" className="text-gray-400 hover:text-white">Design Service</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Fast Delivery</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Bulk Discounts</a></li>
              </ul>
            </div>
            <div>
              <h3 className="font-bold mb-4">Contact</h3>
              <ul className="space-y-2 text-gray-400">
                <li>Phone: +852 2565 7997</li>
                <li>Email: sales@giftandpremium.com.hk</li>
                <li>Address: Hong Kong</li>
              </ul>
            </div>
          </div>
          <div className="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>© 2024 GoPrint. All rights reserved.</p>
          </div>
        </div>
      </footer>
    </div>
  );
}
