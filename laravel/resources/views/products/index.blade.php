@extends('layouts.app')
@section('title', __('messages.products'))
@section('content')

<div class="container mt-4 mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('messages.products') }}</li>
        </ol>
    </nav>
</div>

<section class="product-center-section pt-0">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.products') }}</h2>
            <p class="text-muted mt-3">{{ __('messages.product_center_desc') }}</p>
        </div>
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="category-sidebar">
                    <h4><i class="fas fa-list me-2"></i>{{ __('messages.printing_categories') }}</h4>
                    <ul>
                        <li><a href="{{ route('products.index') }}" class="{{ !request('category') ? 'active' : '' }}"><i class="fas fa-th-large"></i>{{ __('messages.all_categories') }}</a></li>
                        @foreach($categories as $cat)
                        <li><a href="{{ route('products.index') }}?category={{ $cat->cat_id }}" class="{{ request('category') == $cat->cat_id ? 'active' : '' }}"><i class="fas fa-angle-right"></i>{{ $cat->cat_name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                @if($products->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-box-open" style="font-size: 64px; color: var(--gray-300);"></i>
                        <p class="mt-3 text-muted">{{ __('messages.no_records') }}</p>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($products as $product)
                        <div class="col-md-4 col-sm-6">
                            <div class="product-center-card">
                                <div class="card-img-wrap">
                                    @if($product->pro_image)
                                        <img src="{{ asset('storage/products/' . $product->pro_image) }}" alt="{{ $product->pro_name }}" class="product-card-image">
                                    @else
                                        <i class="fas fa-print"></i>
                                    @endif
                                    @if($loop->first)
                                        <span class="card-badge hot">{{ __('messages.hot') }}</span>
                                    @elseif($loop->last)
                                        <span class="card-badge new-badge">{{ __('messages.new') }}</span>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5>{{ $product->pro_name }}</h5>
                                    <p class="card-desc">{{ Str::limit($product->pro_desc, 50) }}</p>
                                    <div class="card-price">${{ number_format($product->pro_price, 2) }}</div>
                                    <div class="card-actions">
                                        <a href="{{ route('products.show', $product->pro_id) }}" class="btn btn-outline-primary">{{ __('messages.view_details') }}</a>
                                        <a href="{{ route('designer.product', $product->pro_id) }}" class="btn btn-info text-white">
                                            <i class="fas fa-palette me-1"></i>{{ __('messages.start_design') }}
                                        </a>
                                        <form action="{{ route('cart.add') }}" method="POST" style="flex:1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->pro_id }}">
                                            <button type="submit" class="btn btn-primary w-100">{{ __('messages.add_to_cart') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
