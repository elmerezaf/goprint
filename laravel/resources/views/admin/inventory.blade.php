<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            庫存管理
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm">總產品數</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $products->count() }}</div>
                </div>
                <div class="bg-yellow-50 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-yellow-700 text-sm">庫存不足</div>
                    <div class="text-3xl font-bold text-yellow-900">{{ $lowStockProducts->count() }}</div>
                </div>
                <div class="bg-red-50 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-red-700 text-sm">缺貨</div>
                    <div class="text-3xl font-bold text-red-900">{{ $outOfStockProducts->count() }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">產品</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">分類</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">價格</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">庫存</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">狀態</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($product->pro_image)
                                                    <img src="{{ asset('storage/products/' . $product->pro_image) }}" alt="{{ $product->pro_name }}" class="w-12 h-12 object-cover rounded mr-3">
                                                @endif
                                                <div class="text-sm font-medium text-gray-900">{{ $product->pro_name }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->category ? $product->category->cat_name : '未分類' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($product->pro_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('admin.products.update-stock', $product->pro_id) }}" method="POST" class="flex items-center">
                                                @csrf
                                                <input type="number" name="pro_stock" value="{{ $product->pro_stock }}" min="0" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm">
                                                <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">更新</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->stock_status === 'out_of_stock')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">缺貨</span>
                                            @elseif($product->stock_status === 'low_stock')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">庫存不足</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">庫存充足</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.products.edit', $product->pro_id) }}" class="text-blue-600 hover:text-blue-900">編輯</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>