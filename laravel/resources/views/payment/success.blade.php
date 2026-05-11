@extends('layouts.app')

@section('title', '付款成功')

@section('content')
<div class="max-w-5xl mx-auto text-center py-12">
    <div class="text-6xl mb-4">✅</div>
    <h1 class="text-3xl font-bold text-success mb-4">付款成功！</h1>
    <p class="text-lg mb-6">感謝您的訂購！您的付款已成功完成。</p>
    
    @if($order)
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="card-title">📋 訂單詳情</h3>
            <p><strong>訂單編號：</strong>{{ $order->id }}</p>
            <p><strong>訂單狀態：</strong><span class="text-success">已付款</span></p>
            <p><strong>總金額：</strong>HK${{ number_format($order->price, 2) }}</p>
            <p><strong>聯絡人：</strong>{{ $order->name }}</p>
        </div>
    </div>
    @endif
    
    <div class="d-flex justify-center gap-3">
        <a href="{{ route('products.index') }}" class="btn btn-primary">繼續購物</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">返回控制台</a>
    </div>
</div>
@endsection