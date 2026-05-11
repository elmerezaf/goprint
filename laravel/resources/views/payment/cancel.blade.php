@extends('layouts.app')

@section('title', '付款取消')

@section('content')
<div class="max-w-5xl mx-auto text-center py-12">
    <div class="text-6xl mb-4">❌</div>
    <h1 class="text-3xl font-bold text-danger mb-4">付款已取消</h1>
    <p class="text-lg mb-6">您的付款已取消，如有需要可以重新嘗試付款。</p>
    
    @if($order)
    <div class="card mb-6">
        <div class="card-body">
            <h3 class="card-title">📋 訂單詳情</h3>
            <p><strong>訂單編號：</strong>{{ $order->id }}</p>
            <p><strong>訂單狀態：</strong><span class="text-warning">待付款</span></p>
            <p><strong>總金額：</strong>HK${{ number_format($order->price, 2) }}</p>
        </div>
    </div>
    @endif
    
    <div class="d-flex justify-center gap-3">
        <a href="{{ route('products.index') }}" class="btn btn-primary">繼續購物</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">返回控制台</a>
    </div>
</div>
@endsection