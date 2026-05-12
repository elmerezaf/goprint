<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\DesignerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 測試翻譯功能
Route::get('/test-translation', function () {
    return response()->json([
        'current_locale' => app()->getLocale(),
        'test_translation' => __('messages.welcome'),
        'available_locales' => ['zh-HK', 'zh-CN', 'en']
    ]);
});

// 語言切換路由
Route::get('/locale/{locale}', function ($locale) {
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
})->name('setlocale');

// 默認首頁
Route::get('/', function () {
    $products = \App\Models\Product::take(8)->get();
    $categories = \App\Models\Category::all();
    $popularProducts = \App\Models\Product::inRandomOrder()->take(6)->get();
    return view('home', compact('products', 'categories', 'popularProducts'));
});

// 產品列表
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 產品詳情
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// 關於我們
Route::get('/about', [InfoController::class, 'about']);

// 聯繫我們
Route::get('/contact', [InfoController::class, 'contact']);

// 下單路由
Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// 設計器路由
Route::get('/designer', [DesignerController::class, 'index'])->name('designer.index');
Route::get('/designer/{productId}', [DesignerController::class, 'index'])->name('designer.product');
Route::post('/designer/export', [DesignerController::class, 'export'])->name('designer.export');

// 購物車路由
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// 支付路由（无需登录即可付款）
Route::post('/payment/create', [PaymentController::class, 'createCheckoutSession'])->name('payment.create');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Dashboard (需要登入驗證)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 個人資料路由 (需要登入驗證)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // 訂單歷史路由
    Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderHistoryController::class, 'show'])->name('orders.show');
    
    // 地址管理路由
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::get('/addresses/{id}/set-default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
});

// 管理後台路由 (需要管理員權限)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/order/{id}', [AdminController::class, 'orderDetail'])->name('admin.order-detail');
    Route::post('/admin/order/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.update-status');
    Route::delete('/admin/order/{id}', [AdminController::class, 'deleteOrder'])->name('admin.delete-order');
    
    // 產品管理路由
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::post('/admin/products/{id}/upload', [AdminController::class, 'uploadImage'])->name('admin.products.upload');
    
    // 產品分類管理路由
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/admin/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/admin/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');
    
    // 數據統計報表路由
    Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

// 水印移除路由
Route::post('/watermark/upload', function () {
    if (request()->hasFile('image')) {
        $image = request()->file('image');
        $path = public_path('products/' . $image->getClientOriginalName());
        $image->move(public_path('products'), $image->getClientOriginalName());
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 400);
});

// Breeze 認證路由
require __DIR__.'/auth.php';
