@extends('layouts.app')

@section('title', $product->pro_name)

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row align-items-center">
        <div class="col-md-6 mb-4">
            <div class="border p-4 rounded bg-light">
                <img src="{{ $product->pro_image ? asset('storage/products/' . $product->pro_image) : 'https://via.placeholder.com/600x400?text=Product+Image' }}" class="img-fluid rounded" alt="{{ $product->pro_name }}">
            </div>
        </div>
        <div class="col-md-6">
            <h1 class="fw-bold">{{ $product->pro_name }}</h1>
            <p class="lead mt-3">{{ $product->pro_desc }}</p>
            <h2 class="text-danger fw-bold mt-2">HK$ {{ $product->pro_price }}</h2>
            <p class="mt-3"><strong>{{ __('messages.category') }}：</strong>{{ $product->cat_id }}</p>
            <p><strong>{{ __('messages.created_at') }}：</strong>{{ $product->create_time }}</p>
            <div class="mt-4">
                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->pro_id }}">
                    <button type="submit" class="btn btn-primary fw-bold me-2">{{ __('messages.add_to_cart') }}</button>
                </form>
                <a href="{{ route('designer.product', $product->pro_id) }}" class="btn btn-info fw-bold me-2 text-white">
                    <i class="fas fa-palette me-1"></i>{{ __('messages.start_design') }}
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary me-2">{{ __('messages.back') }} {{ __('messages.products') }}</a>
                <a href="{{ route('order.create') }}" class="btn btn-success fw-bold">{{ __('messages.order') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection