import Image from 'next/image';

interface Product {
  id: number;
  pro_name: string;
  pro_price: number;
  pro_description: string;
  pro_image?: string;
}

export default function ProductCard({ product }: { product: Product }) {
  const imageUrl = product.pro_image
    ? `http://127.0.0.1:8000/storage/products/${product.pro_image}`
    : '/api/placeholder/200/200';

  return (
    <div className="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
      <div className="relative h-48 overflow-hidden">
        <Image
          src={imageUrl}
          alt={product.pro_name}
          fill
          className="object-cover"
          sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 25vw"
        />
      </div>
      <div className="p-4">
        <h3 className="font-semibold text-lg mb-2 line-clamp-1">{product.pro_name}</h3>
        <p className="text-gray-600 text-sm mb-3 line-clamp-2">{product.pro_description}</p>
        <div className="flex justify-between items-center">
          <span className="text-xl font-bold text-blue-600">${product.pro_price}</span>
          <button className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Add to Cart
          </button>
        </div>
      </div>
    </div>
  );
}
