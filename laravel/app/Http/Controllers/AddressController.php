<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        return view('addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{8}$/',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'is_default' => 'boolean',
        ], [
            'phone.regex' => '請輸入正確的香港電話號碼格式（8位數字）',
        ]);

        if ($request->is_default) {
            Address::where('user_id', auth()->user()->id)->update(['is_default' => false]);
        }

        Address::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('addresses.index')->with('success', '地址已添加');
    }

    public function edit($id)
    {
        $address = Address::find($id);

        if (!$address || $address->user_id !== auth()->user()->id) {
            return redirect()->route('addresses.index')->with('error', '地址不存在');
        }

        return view('addresses.edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = Address::find($id);

        if (!$address || $address->user_id !== auth()->user()->id) {
            return redirect()->route('addresses.index')->with('error', '地址不存在');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^[0-9]{8}$/',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'is_default' => 'boolean',
        ], [
            'phone.regex' => '請輸入正確的香港電話號碼格式（8位數字）',
        ]);

        if ($request->is_default) {
            Address::where('user_id', auth()->user()->id)->update(['is_default' => false]);
        }

        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'is_default' => $request->is_default ?? $address->is_default,
        ]);

        return redirect()->route('addresses.index')->with('success', '地址已更新');
    }

    public function destroy($id)
    {
        $address = Address::find($id);

        if (!$address || $address->user_id !== auth()->user()->id) {
            return redirect()->route('addresses.index')->with('error', '地址不存在');
        }

        $address->delete();

        return redirect()->route('addresses.index')->with('success', '地址已刪除');
    }

    public function setDefault($id)
    {
        $address = Address::find($id);

        if (!$address || $address->user_id !== auth()->user()->id) {
            return redirect()->route('addresses.index')->with('error', '地址不存在');
        }

        Address::where('user_id', auth()->user()->id)->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('addresses.index')->with('success', '默認地址已更新');
    }
}
