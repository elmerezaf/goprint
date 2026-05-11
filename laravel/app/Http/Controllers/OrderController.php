<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    // 顯示下單表單
    public function create()
    {
        $products = Product::all();
        return view('order.create', compact('products'));
    }

    // 處理表單提交，保存訂單並計算價格
    public function store(Request $request)
    {
        // Build dynamic validation rules for product
        $productNames = Product::pluck('pro_name')->toArray();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{8}$/',
            'email' => 'required|email:rfc,dns|max:255',
            'product' => 'required|string|in:' . implode(',', $productNames),
            'size' => 'required|string|in:A6,A5,A4,A3,A2,A1,DL,100x200mm,150x210mm,210x297mm,自訂',
            'material' => 'required|string|in:128g銅版,157g銅版,200g啞粉,250g白卡,300g銅版,PVC防水,PP防水紙,防水帆布,牛皮紙,80g書紙',
            'printing_side' => 'required|string|in:單面,雙面',
            'binding' => 'required|string|in:無,騎馬釘,膠裝,精裝,線圈裝',
            'quantity' => 'required|integer|min:1',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,ai,psd|max:10240',
        ], [
            'phone.regex' => '請輸入正確的香港電話號碼格式（8位數字）',
            'email.email' => '請輸入有效的電子郵箱地址',
            'file.mimes' => '只支持 PDF, JPG, JPEG, PNG, AI, PSD 格式',
            'file.max' => '文件大小不能超過 10MB',
            'quantity.min' => '數量必須至少為1',
            'quantity.integer' => '數量必須是整數',
        ]);

        // 計算價格
        $price = $this->calculatePrice(
            $request->product,
            $request->size,
            $request->material,
            $request->printing_side,
            $request->binding,
            $request->quantity
        );

        // 處理文件上傳
        $fileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('orders', $fileName, 'public');
        }

        // 使用 DB facade 直接插入
        $insertId = \DB::table('orders')->insertGetId([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'product' => $request->product,
            'size' => $request->size,
            'material' => $request->material,
            'printing_side' => $request->printing_side,
            'binding' => $request->binding,
            'quantity' => $request->quantity,
            'price' => $price,
            'file' => $fileName,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 獲取剛插入的訂單資訊
        $order = Order::find($insertId);

        // 發送訂單確認郵件
        try {
            Mail::to($order->email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            \Log::error('郵件發送失敗: ' . $e->getMessage());
        }

        return view('order.confirm', compact('order'));
    }

    // 價格計算邏輯
    private function calculatePrice($product, $size, $material, $printingSide, $binding, $quantity)
    {
        // Base price lookup by product name
        $productModel = Product::where('pro_name', $product)->first();
        $baseUnitPrice = $productModel ? (float) $productModel->pro_price : 100;

        // Size multiplier
        $sizeMultiplier = 1.0;
        switch ($size) {
            case 'A6': $sizeMultiplier = 0.6; break;
            case 'A5': $sizeMultiplier = 0.8; break;
            case 'A4': $sizeMultiplier = 1.0; break;
            case 'A3': $sizeMultiplier = 1.5; break;
            case 'A2': $sizeMultiplier = 2.0; break;
            case 'A1': $sizeMultiplier = 3.0; break;
            case 'DL':
            case '100x200mm': $sizeMultiplier = 0.7; break;
            case '150x210mm': $sizeMultiplier = 0.85; break;
            case '210x297mm': $sizeMultiplier = 1.0; break;
            case '自訂': $sizeMultiplier = 1.2; break;
        }

        // Material multiplier
        $materialMultiplier = 1.0;
        switch ($material) {
            case '128g銅版': $materialMultiplier = 1.0; break;
            case '157g銅版': $materialMultiplier = 1.2; break;
            case '200g啞粉': $materialMultiplier = 1.3; break;
            case '250g白卡': $materialMultiplier = 1.5; break;
            case '300g銅版': $materialMultiplier = 1.6; break;
            case 'PVC防水': $materialMultiplier = 1.8; break;
            case 'PP防水紙': $materialMultiplier = 1.4; break;
            case '防水帆布': $materialMultiplier = 2.0; break;
            case '牛皮紙': $materialMultiplier = 1.1; break;
            case '80g書紙': $materialMultiplier = 0.9; break;
        }

        // Printing side multiplier
        $sideMultiplier = $printingSide === '雙面' ? 1.8 : 1.0;

        // Binding surcharge
        $bindingSurcharge = 0;
        switch ($binding) {
            case '騎馬釘': $bindingSurcharge = 50; break;
            case '膠裝': $bindingSurcharge = 120; break;
            case '精裝': $bindingSurcharge = 300; break;
            case '線圈裝': $bindingSurcharge = 80; break;
            default: $bindingSurcharge = 0; break;
        }

        // Calculate unit price
        $unitPrice = $baseUnitPrice * $sizeMultiplier * $materialMultiplier * $sideMultiplier;

        // Quantity-based pricing
        if ($quantity >= 1000) {
            $total = $unitPrice * ($quantity / 100) * 0.75 + $bindingSurcharge; // 75折
        } else if ($quantity >= 500) {
            $total = $unitPrice * ($quantity / 100) * 0.85 + $bindingSurcharge; // 85折
        } else if ($quantity >= 200) {
            $total = $unitPrice * ($quantity / 100) * 0.95 + $bindingSurcharge; // 95折
        } else {
            $total = $unitPrice * ($quantity / 100) + $bindingSurcharge;
        }

        return round($total, 2);
    }
}
