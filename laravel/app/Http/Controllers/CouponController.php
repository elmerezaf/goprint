<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.coupons', compact('coupons'));
    }

    public function create()
    {
        return view('admin.create-coupon');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code|max:50',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'description' => 'nullable|string|max:500',
        ]);

        Coupon::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.coupons')->with('success', '優惠券創建成功！');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.edit-coupon', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after:valid_from',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.coupons')->with('success', '優惠券更新成功！');
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return redirect()->back()->with('success', '優惠券狀態已更新！');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons')->with('success', '優惠券已刪除！');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->coupon_code))->first();

        if (!$coupon) {
            return redirect()->back()->with('coupon_error', '優惠券不存在！');
        }

        $cart = session('cart', []);
        $orderAmount = 0;
        
        foreach ($cart as $item) {
            $orderAmount += $item['price'] * $item['quantity'];
        }

        if (!$coupon->isValid($orderAmount)) {
            return redirect()->back()->with('coupon_error', '優惠券無效或已過期！');
        }

        $discount = $coupon->calculateDiscount($orderAmount);

        session(['coupon' => $coupon, 'discount' => $discount]);

        return redirect()->back()->with('success', '優惠券應用成功！');
    }

    public function remove()
    {
        session()->forget(['coupon', 'discount']);
        return redirect()->back()->with('success', '優惠券已移除！');
    }
}