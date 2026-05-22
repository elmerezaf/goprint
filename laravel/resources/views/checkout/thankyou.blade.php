@extends('layouts.app')

@section('title', '訂單確認')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <div class="mb-3">
                    <span class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px;">
                        <i class="fas fa-check fs-2"></i>
                    </span>
                </div>
                <h2 class="fw-bold mb-2">訂單已成功提交！</h2>
                <p class="text-muted fs-5">感謝您的訂購，我們會盡快處理。</p>
            </div>

            @if(session('error'))
                <div class="alert alert-warning text-center mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">訂單詳情</h5>
                    <span class="badge
                        @if($order->status == 'pending') bg-warning text-dark
                        @elseif($order->status == 'processing') bg-info
                        @elseif($order->status == 'awaiting_transfer') bg-secondary
                        @else bg-success
                        @endif
                        fs-6 px-3 py-2">
                        @if($order->status == 'pending') 待付款
                        @elseif($order->status == 'processing') 處理中
                        @elseif($order->status == 'awaiting_transfer') 待核實轉帳
                        @elseif($order->status == 'completed') 已完成
                        @else {{ $order->status }}
                        @endif
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <small class="text-muted">訂單編號</small>
                            <div class="fw-bold">#{{ $order->id }}</div>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted">付款方式</small>
                            <div class="fw-bold">
                                @if($order->payment_method == 'stripe') 信用卡 (Stripe)
                                @elseif($order->payment_method == 'bank_transfer') 銀行轉帳
                                @else {{ $order->payment_method }}
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted">送貨方式</small>
                            <div class="fw-bold">
                                @if($order->shipping_method == 'pickup') 自取
                                @elseif($order->shipping_method == 'sf_cod') 順豐速遞（到付）
                                @else {{ $order->shipping_method }}
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted">總金額</small>
                            <div class="fw-bold text-primary fs-5">HK${{ number_format($order->price, 0) }}</div>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted">收貨人</small>
                            <div class="fw-bold">{{ $order->name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted">電話</small>
                            <div class="fw-bold">{{ $order->phone }}</div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">送貨地址</small>
                            <div class="fw-bold">{{ $order->address }}{{ $order->city ? ', ' . $order->city : '' }}{{ $order->postal_code ? ', ' . $order->postal_code : '' }}</div>
                        </div>
                        @if($order->notes)
                        <div class="col-12">
                            <small class="text-muted">備註</small>
                            <div>{{ $order->notes }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($order->payment_method == 'bank_transfer')
            <div class="card shadow-sm mb-4 border-warning">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-warning mb-3"><i class="fas fa-info-circle me-2"></i>銀行轉帳資料</h5>
                    <p class="mb-2">請將 <strong>HK${{ number_format($order->price, 0) }}</strong> 轉入以下帳戶：</p>
                    <div class="bg-light p-3 rounded-3 mb-3">
                        <div class="mb-2"><strong>收款人：</strong>Offset Printing Limited</div>
                        <div class="mb-2"><strong>FPS ID：</strong>1157 028 96</div>
                        <div class="mb-2"><strong>收款銀行：</strong>交通銀行</div>
                    </div>
                    <p class="mt-3 text-muted small">
                        <i class="fas fa-comment-dots me-1"></i>轉帳後請截圖 WHATSAPP 俾我哋確認：<br>
                        <a href="https://api.whatsapp.com/send?phone=85260987508&text=我已完成轉帳，訂單編號：{{ $order->id }}，金額：HK${{ number_format($order->price, 0) }}" target="_blank" class="btn btn-outline-success btn-sm mt-2">
                            <i class="fab fa-whatsapp me-1"></i>WHATSAPP 確認
                        </a>
                    </p>
                </div>
            </div>
            @endif

            @if($order->payment_method == 'stripe')
            <div class="text-center mb-4">
                <a href="{{ route('checkout.stripe', ['order_id' => $order->id]) }}" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fas fa-credit-card me-2"></i>立即付款 (Stripe)
                </a>
            </div>
            @endif

            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg px-4">
                    <i class="fas fa-store me-2"></i>繼續選購
                </a>
                @auth
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                    <i class="fas fa-list me-2"></i>查看訂單
                </a>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
