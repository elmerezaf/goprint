@extends('layouts.app')

@section('title', __('messages.checkout'))

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-1"></i>返回購物車
        </a>
    </div>

    <h1 class="fw-bold mb-4">{{ __('messages.checkout') }}</h1>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-user me-2 text-primary"></i>帳單資料</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">姓名 <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name', auth()->user()->name ?? '') }}" required placeholder="請輸入姓名">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">電話 <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" required placeholder="請輸入電話">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">電郵 <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email', auth()->user()->email ?? '') }}" required placeholder="example@email.com">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">送貨地址 <span class="text-danger">*</span></label>
                                <input type="text" name="address" class="form-control form-control-lg @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}" required placeholder="請輸入完整送貨地址">
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">地區</label>
                                <input type="text" name="city" class="form-control form-control-lg"
                                    value="{{ old('city') }}" placeholder="例如：九龍、香港島、新界">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label fw-semibold">郵編</label>
                                <input type="text" name="postal_code" class="form-control form-control-lg"
                                    value="{{ old('postal_code') }}" placeholder="郵編">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-truck me-2 text-primary"></i>送貨方式</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-check mb-2 p-3 border rounded-3">
                            <input class="form-check-input" type="radio" name="shipping_method" value="pickup" id="shipPickup" checked>
                            <label class="form-check-label w-100 d-flex justify-content-between align-items-center" for="shipPickup">
                                <div>
                                    <strong>自取</strong><br>
                                    <small class="text-muted">到我們辦公室取貨（北角屈臣道4-6號海景大廈B座605室）</small>
                                </div>
                                <span class="badge bg-success-subtle text-success fw-semibold">免費</span>
                            </label>
                        </div>
                        <div class="form-check p-3 border rounded-3">
                            <input class="form-check-input" type="radio" name="shipping_method" value="sf_cod" id="shipSF">
                            <label class="form-check-label w-100 d-flex justify-content-between align-items-center" for="shipSF">
                                <div>
                                    <strong>順豐速遞（到付）</strong><br>
                                    <small class="text-muted">送貨到指定地址，運費由快遞員收現</small>
                                </div>
                                <span class="badge bg-secondary fw-semibold">到付</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-credit-card me-2 text-primary"></i>付款方式</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-check mb-3 p-3 border rounded-3" style="cursor:pointer;">
                            <input class="form-check-input" type="radio" name="payment_method" value="stripe" id="payStripe" checked>
                            <label class="form-check-label w-100" for="payStripe" style="cursor:pointer;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="far fa-credit-card text-primary fs-5"></i>
                                    <span><strong>信用卡付款</strong> (Stripe)</span>
                                    <span class="ms-auto text-muted small">Visa / Mastercard / AE</span>
                                </div>
                                <small class="text-muted d-block mt-1">透過 Stripe 安全支付，支援 Visa、Mastercard、American Express</small>
                            </label>
                        </div>

                        <div class="form-check p-3 border rounded-3" style="cursor:pointer;">
                            <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="payBank">
                            <label class="form-check-label w-100" for="payBank" style="cursor:pointer;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-university text-success fs-5"></i>
                                    <span><strong>銀行轉帳</strong></span>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    轉帳後請截圖 WHATSAPP 俾我哋確認<br>
                                    <strong>收款人：</strong>Offset Printing Limited<br>
                                    <strong>FPS ID：</strong>1157 028 96<br>
                                    <strong>收款銀行：</strong>交通銀行
                                </small>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-sticky-note me-2 text-primary"></i>訂單備註（可選）</h5>
                    </div>
                    <div class="card-body p-4">
                        <textarea name="notes" class="form-control" rows="3" placeholder="如有特殊要求，請在此備註...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-bag me-2"></i>訂單摘要</h5>
                    </div>
                    <div class="card-body p-4">
                        @foreach($cartItems as $item)
                            <div class="d-flex gap-3 pb-3 mb-3 border-bottom">
                                <div class="flex-shrink-0 bg-light rounded-3 d-flex align-items-center justify-content-center"
                                     style="width: 64px; height: 64px;">
                                    @if($item['design_token'])
                                        <i class="fas fa-paint-brush text-primary fs-4"></i>
                                    @elseif($item['image'])
                                        <img src="{{ asset('storage/products/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                             class="rounded-3" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <i class="fas fa-print text-muted fs-4"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1 min-width-0">
                                    <h6 class="mb-1 text-truncate">{{ $item['name'] }}</h6>
                                    <div class="text-muted small">數量: {{ $item['quantity'] }}</div>
                                    <div class="text-end fw-semibold">HK${{ number_format($item['total'], 0) }}</div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">小計</span>
                            <span>HK${{ number_format($subtotal, 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">運費</span>
                            <span>
                                @if($shipping == 0)
                                    <span class="text-success fw-semibold">免費</span>
                                @elseif($shipping == -1)
                                    <span class="text-secondary fw-semibold">到付</span>
                                @else
                                    HK${{ number_format($shipping, 0) }}
                                @endif
                            </span>
                        </div>
                        @if($freeShippingThreshold > 0 && $subtotal < $freeShippingThreshold)
                            <div class="alert alert-warning py-2 px-3 small mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                消費滿 HK${{ $freeShippingThreshold }} 即可豁免自取運費！
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                         style="width: {{ min(100, ($subtotal / $freeShippingThreshold) * 100) }}%">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold fs-5">合計</span>
                            <span class="fw-bold fs-4 text-primary">HK${{ number_format($total, 0) }}</span>
                        </div>

                        <button type="submit" class="btn btn-warning btn-lg w-100 text-white fw-bold py-3" id="placeOrderBtn">
                            <i class="fas fa-lock me-2"></i>確認訂單
                        </button>

                        <p class="text-center text-muted small mt-3 mb-0">
                            <i class="fas fa-shield-alt me-1"></i> 您的個人資料將受到安全保護
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('checkoutForm').addEventListener('submit', function() {
    var btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>處理中...';
});

document.querySelectorAll('input[name="shipping_method"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var shippingRow = document.querySelector('.d-flex.justify-content-between.mb-3');
        if (this.value === 'pickup') {
            updateShippingDisplay({{ $subtotal }}, {{ $freeShippingThreshold }});
        } else {
            shippingRow.querySelector('span:last-child').innerHTML = '<span class="text-secondary fw-semibold">到付</span>';
        }
    });
});

function updateShippingDisplay(subtotal, threshold) {
    var shippingRow = document.querySelector('.d-flex.justify-content-between.mb-3');
    var totalRow = document.querySelector('.d-flex.justify-content-between.align-items-center.mb-4:last-of-type');
    var total = subtotal;
    var shipping = subtotal >= threshold ? 0 : 35;
    if (shipping === 0) {
        shippingRow.querySelector('span:last-child').innerHTML = '<span class="text-success fw-semibold">免費</span>';
    } else {
        shippingRow.querySelector('span:last-child').innerHTML = 'HK$' + shipping;
    }
}
</script>
@endsection
