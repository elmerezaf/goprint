@extends('layouts.app')

@section('title', $product->pro_name)

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ __('messages.products') }}</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}?category={{ $product->category->cat_id }}">{{ $product->category->cat_name }}</a></li>
                @endif
                <li class="breadcrumb-item active">{{ $product->pro_name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-5">
                <div class="bg-light rounded-3 overflow-hidden position-relative" style="aspect-ratio: 1;">
                    @if($product->pro_image)
                        <img src="{{ asset('storage/' . $product->pro_image) }}" alt="{{ $product->pro_name }}" class="product-detail-image">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                            <i class="fas fa-print fa-5x text-white" style="opacity: 0.6;"></i>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <h1 class="fw-bold mb-2">{{ $product->pro_name }}</h1>
                @if($product->category)
                    <p class="text-muted mb-3"><i class="fas fa-folder me-1"></i>{{ $product->category->cat_name }}</p>
                @endif
                <div class="mb-4">
                    <span class="fs-3 fw-bold text-warning">HK${{ number_format($product->pro_price, 0) }}</span>
                    <span class="text-muted ms-2">{{ __('messages.price_from') }}</span>
                </div>
                <p class="mb-4" style="line-height: 1.8; font-size: 1.05rem;">{{ $product->pro_desc }}</p>

                @if($product->pro_stock > 0)
                    <div class="mb-2 text-success">
                        <i class="fas fa-check-circle me-1"></i>可訂購（庫存 {{ $product->pro_stock }}）
                    </div>
                @else
                    <div class="mb-2 text-danger">
                        <i class="fas fa-times-circle me-1"></i>暫時缺貨，請聯絡我們查詢
                    </div>
                @endif

                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <form action="{{ route('cart.add', $product->pro_id) }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <div class="input-group" style="width: 120px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.nextElementSibling.stepDown()">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->pro_stock }}" class="form-control text-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.previousElementSibling.stepUp()">+</button>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-cart-plus me-2"></i>{{ __('messages.add_to_cart') }}
                        </button>
                    </form>
                    <a href="{{ route('order.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-print me-2"></i>{{ __('messages.inquiry_product') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection