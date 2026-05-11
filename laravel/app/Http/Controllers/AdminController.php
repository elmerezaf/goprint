<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        return view('admin.dashboard', compact('totalOrders', 'pendingOrders', 'completedOrders'));
    }

    public function orders()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order-detail', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()->with('success', '訂單狀態已更新');
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        
        return redirect()->route('admin.orders')->with('success', '訂單已刪除');
    }

    public function products()
    {
        $products = Product::with('category')->get();
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.create-product', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'pro_name' => 'required|string|max:255',
            'pro_price' => 'required|numeric|min:0',
            'pro_stock' => 'required|integer|min:0',
            'pro_desc' => 'nullable|string',
            'cat_id' => 'required|exists:category,cat_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $productData = [
            'pro_name' => $request->pro_name,
            'pro_price' => $request->pro_price,
            'pro_stock' => $request->pro_stock,
            'pro_desc' => $request->pro_desc,
            'cat_id' => $request->cat_id,
            'create_time' => now()->toDateTimeString(),
        ];

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/products', $filename);
            $productData['pro_image'] = $filename;
        }

        Product::create($productData);

        return redirect()->route('admin.products')->with('success', '產品創建成功！');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-product', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'pro_name' => 'required|string|max:255',
            'pro_price' => 'required|numeric|min:0',
            'pro_stock' => 'required|integer|min:0',
            'pro_desc' => 'nullable|string',
            'cat_id' => 'required|exists:category,cat_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $productData = [
            'pro_name' => $request->pro_name,
            'pro_price' => $request->pro_price,
            'pro_stock' => $request->pro_stock,
            'pro_desc' => $request->pro_desc,
            'cat_id' => $request->cat_id,
        ];

        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/products', $filename);
            $productData['pro_image'] = $filename;
        }

        Product::findOrFail($id)->update($productData);

        return redirect()->route('admin.products')->with('success', '產品更新成功！');
    }

    public function deleteProduct($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products')->with('success', '產品已刪除！');
    }

    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/products', $filename);
        
        Product::find($id)->update(['pro_image' => $filename]);
        
        return back()->with('success', '圖片上傳成功！');
    }

    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.create-category');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'cat_name' => 'required|string|max:255',
            'cat_desc' => 'nullable|string',
        ]);

        Category::create([
            'cat_name' => $request->cat_name,
            'cat_desc' => $request->cat_desc,
            'create_time' => now()->toDateTimeString(),
        ]);

        return redirect()->route('admin.categories')->with('success', '分類創建成功！');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit-category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'cat_name' => 'required|string|max:255',
            'cat_desc' => 'nullable|string',
        ]);

        Category::findOrFail($id)->update([
            'cat_name' => $request->cat_name,
            'cat_desc' => $request->cat_desc,
        ]);

        return redirect()->route('admin.categories')->with('success', '分類更新成功！');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return back()->with('error', '該分類下有產品，無法刪除！');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', '分類刪除成功！');
    }

    public function reports()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $totalPendingOrders = Order::where('status', 'pending')->count();
        $totalCompletedOrders = Order::where('status', 'completed')->count();
        
        $categoryStats = Category::withCount('products')->get();
        
        $totalRevenue = Order::where('status', 'completed')->sum('price');
        
        $recentOrders = Order::orderBy('created_at', 'desc')->take(10)->get();

        return view('admin.reports', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalPendingOrders',
            'totalCompletedOrders',
            'categoryStats',
            'totalRevenue',
            'recentOrders'
        ));
    }
}
