import { Metadata } from 'next';
import ProductCard from '../components/ProductCard';

export const metadata: Metadata = {
  title: 'GoPrint - Professional Printing Services',
  description: 'Discover high-quality printing products and services in Hong Kong. Business cards, flyers, posters, and more.',
};

async function fetchProducts() {
  const res = await fetch('http://127.0.0.1:8000/api/products', {
    cache: 'no-store',
  });
  
  if (!res.ok) {
    throw new Error('Failed to fetch products');
  }
  
  return res.json();
}

export default async function Home() {
  const products = await fetchProducts();
  
  return (
    <div className="min-h-screen bg-gray-50">
      <header className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <div className="flex items-center">
              <span className="text-2xl font-bold text-blue-600">GoPrint</span>
            </div>
            <nav className="flex space-x-4">
              <a href="/" className="text-gray-700 hover:text-blue-600">Home</a>
              <a href="/products" className="text-gray-700 hover:text-blue-600">Products</a>
              <a href="/about" className="text-gray-700 hover:text-blue-600">About</a>
              <a href="/contact" className="text-gray-700 hover:text-blue-600">Contact</a>
            </nav>
          </div>
        </div>
      </header>

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section className="mb-12">
          <div className="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-8 text-white">
            <h1 className="text-4xl font-bold mb-4">Professional Printing Services</h1>
            <p className="text-xl mb-6">High-quality printing for your business needs</p>
            <button className="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
              Start Designing
            </button>
          </div>
        </section>

        <section>
          <h2 className="text-2xl font-bold mb-6">Featured Products</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {products.map((product: any) => (
              <ProductCard key={product.id} product={product} />
            ))}
          </div>
        </section>
      </main>

      <footer className="bg-gray-800 text-white py-8 mt-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
              <h3 className="font-bold mb-4">GoPrint</h3>
              <p>Professional printing services in Hong Kong</p>
            </div>
            <div>
              <h3 className="font-bold mb-4">Products</h3>
              <ul className="space-y-2">
                <li><a href="#" className="text-gray-400 hover:text-white">Business Cards</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Flyers</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Posters</a></li>
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
              <ul className="space-y-2">
                <li className="text-gray-400">Phone: +852 1234 5678</li>
                <li className="text-gray-400">Email: info@goprint.com.hk</li>
                <li className="text-gray-400">Address: Hong Kong</li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
}
