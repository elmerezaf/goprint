@extends('layouts.app')

@section('title', __('messages.shopping_cart'))

@section('content')
<div id="cart-root" class="container py-4" data-cart-items='@json($products)'>
    <h1 class="fw-bold mb-4">{{ __('messages.shopping_cart') }}</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($products) > 0)
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('messages.product') }}</th>
                                <th>{{ __('messages.name') }}</th>
                                <th>{{ __('messages.price') }}</th>
                                <th>{{ __('messages.quantity') }}</th>
                                <th>{{ __('messages.subtotal') }}</th>
                                <th>{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $item)
                                <tr>
                                    <td style="width: 80px;">
                                        @if($item['product']->pro_image)
                                            <img src="{{ asset('storage/products/' . $item['product']->pro_image) }}"
                                                 alt="{{ $item['product']->pro_name }}"
                                                 class="img-fluid rounded"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary bg-opacity-10 text-primary rounded d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 60px; font-size: 24px;">
                                                <i class="fas fa-print"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ $item['product']->pro_name }}</td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td style="width: 180px;">
                                        <div class="d-flex align-items-center gap-2">
                                            <button class="btn btn-sm btn-outline-secondary" data-action="minus" data-id="{{ $item['product']->pro_id }}">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" value="{{ $item['quantity'] }}" 
                                                   class="form-control text-center" 
                                                   data-id="{{ $item['product']->pro_id }}"
                                                   style="width: 70px;" min="1" max="999">
                                            <button class="btn btn-sm btn-outline-secondary" data-action="plus" data-id="{{ $item['product']->pro_id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-primary">${{ number_format($item['total'], 2) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger" data-action="remove" data-id="{{ $item['product']->pro_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top">
                    <div>
                        <h4 class="fw-bold">{{ __('messages.total') }}: <span class="text-primary">${{ number_format($total, 2) }}</span></h4>
                    </div>
                    <div class="d-flex gap-2 mt-2 mt-sm-0">
                        <button class="btn btn-outline-secondary" id="clear-cart">{{ __('messages.clear_cart') }}</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">{{ __('messages.continue_shopping') }}</a>
                        <a href="{{ route('order.create') }}" class="btn btn-warning text-white">{{ __('messages.checkout') }}</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart text-muted" style="font-size: 64px; opacity: 0.3;"></i>
                <h3 class="fw-bold mt-3">{{ __('messages.cart_empty') }}</h3>
                <p class="text-muted mb-4">{{ __('messages.go_shopping_prompt') }}</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">{{ __('messages.go_shopping') }}</a>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script type="module">
    import { Cart } from '/resources/js/cart/Cart.jsx';
    import { createRoot } from 'react-dom/client';
    
    const container = document.getElementById('cart-root');
    const initialItems = JSON.parse(container.dataset.cartItems);
    
    createRoot(container).render(<Cart initialItems={initialItems} />);
</script>
@endsection