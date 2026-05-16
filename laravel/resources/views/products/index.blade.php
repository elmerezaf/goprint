@extends('layouts.app')

@section('title', __('messages.products'))

@section('content')
<section class="py-5">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.product_center') }}</h2>
            <p class="text-muted mt-3">{{ __('messages.product_center_desc') }}</p>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="category-sidebar">
                    <h4><i class="fas fa-th-list me-2"></i>{{ __('messages.shop_by_category') }}</h4>
                    <ul>
                        @php
                            $categories = \App\Models\Category::orderBy('cat_id')->get();
                            $selectedCategory = request('category');
                        @endphp
                        <li>
                            <a href="{{ route('products.index') }}" class="{{ !$selectedCategory ? 'active' : '' }}">
                                <i class="fas fa-print"></i>{{ __('messages.all_categories') }}
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.index') }}?category={{ $cat->cat_id }}"
                                   class="{{ $selectedCategory == $cat->cat_id ? 'active' : '' }}">
                                    @switch($cat->cat_id)
                                        @case(1) <i class="fas fa-address-card"></i> @break
                                        @case(2) <i class="fas fa-file-alt"></i> @break
                                        @case(3) <i class="fas fa-book"></i> @break
                                        @case(4) <i class="fas fa-image"></i> @break
                                        @case(5) <i class="fas fa-sticky-note"></i> @break
                                        @case(6) <i class="fas fa-envelope"></i> @break
                                        @case(7) <i class="fas fa-gift"></i> @break
                                        @case(8) <i class="fas fa-red-envelope"></i> @break
                                        @case(9) <i class="fas fa-box"></i> @break
                                        @case(10) <i class="fas fa-box-open"></i> @break
                                        @case(11) <i class="fas fa-bolt"></i> @break
                                        @default <i class="fas fa-print"></i>
                                    @endswitch
                                    {{ $cat->cat_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                @if($selectedCategory)
                    @php $currentCat = \App\Models\Category::find($selectedCategory); @endphp
                    @if($currentCat)
                        <div class="alert alert-light border mb-4">
                            <strong>{{ $currentCat->cat_name }}</strong> — {{ $currentCat->cat_desc }}
                        </div>
                    @endif
                @endif

                <div class="row g-4">
                    @forelse($products as $product)
                        <div class="col-md-4 col-sm-6">
                            <div class="product-center-card">
                                <div class="card-img-wrap">
                                    @if($product->pro_image)
                                        <img src="{{ asset('storage/' . $product->pro_image) }}" alt="{{ $product->pro_name }}" class="product-card-image">
                                    @else
                                        <i class="fas fa-print"></i>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <h5>{{ $product->pro_name }}</h5>
                                    <p class="card-desc">{{ \Illuminate\Support\Str::limit($product->pro_desc, 60) }}</p>
                                    @if($product->category)
                                        <p class="text-muted small mb-2"><i class="fas fa-folder me-1"></i>{{ $product->category->cat_name }}</p>
                                    @endif
                                    <div class="card-price">{{ __('messages.price_from') }} HK${{ number_format($product->pro_price, 0) }}</div>
                                    <div class="card-actions">
                                        <a href="{{ route('products.show', $product->pro_id) }}" class="btn btn-outline-primary btn-sm">{{ __('messages.view_details') }}</a>
                                        <form action="{{ route('cart.add', $product->pro_id) }}" method="POST" style="flex:1;">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">{{ __('messages.add_to_cart') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted">{{ __('messages.no_records') }}</h4>
                                <p class="text-muted">此分類暫無產品，請瀏覽其他分類</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection