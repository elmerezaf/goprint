@extends('layouts.app')
@section('title', __('messages.home'))
@section('content')

<!-- ====== 1. Hero Carousel ====== -->
<section class="hero-carousel">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active slide-1">
                <img src="{{ asset('storage/products/banner1.jpg') }}" alt="Banner 1" class="d-block w-100">
            </div>
            <div class="carousel-item slide-2">
                <img src="{{ asset('storage/products/banner2.jpg') }}" alt="Banner 2" class="d-block w-100">
            </div>
            <div class="carousel-item slide-3">
                <img src="{{ asset('storage/products/banner3.jpg') }}" alt="Banner 3" class="d-block w-100">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- ====== 2. Online Design Tools ====== -->
<section class="design-tools-section" id="design-tools">
    <div class="container">
        <div class="design-tools-header">
            <h2>{{ __('messages.online_design_tools') }}</h2>
            <p>{{ __('messages.online_design_subtitle') }}</p>
        </div>
        <div class="design-tools-grid">
            <a href="{{ route('products.index') }}?category=1" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-id-card"></i></div>
                <span>名片</span>
            </a>
            <a href="{{ route('products.index') }}?category=2" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-file-alt"></i></div>
                <span>宣傳單</span>
            </a>
            <a href="{{ route('products.index') }}?category=4" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-image"></i></div>
                <span>海報</span>
            </a>
            <a href="{{ route('products.index') }}?category=7" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-envelope-open-text"></i></div>
                <span>邀請函</span>
            </a>
            <a href="{{ route('products.index') }}?category=2" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-ticket-alt"></i></div>
                <span>優惠券</span>
            </a>
            <a href="{{ route('products.index') }}?category=7" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-utensils"></i></div>
                <span>餐牌</span>
            </a>
            <a href="{{ route('products.index') }}?category=11" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-mobile-alt"></i></div>
                <span>社交媒體</span>
            </a>
            <a href="{{ route('products.index') }}?category=7" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-envelope"></i></div>
                <span>賀卡</span>
            </a>
            <a href="{{ route('products.index') }}?category=5" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-tag"></i></div>
                <span>標籤</span>
            </a>
        </div>
        <div class="design-tools-cta">
            <a href="{{ route('products.index') }}" class="btn btn-primary">瀏覽所有產品</a>
        </div>
    </div>
</section>

<!-- ====== 4. Product Center ====== -->
<section class="product-center-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.product_center') }}</h2>
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
                <div class="row g-4">
                    @foreach($products as $product)
                    <div class="col-md-4 col-sm-6 col-6">
                        <div class="product-center-card">
                            <div class="card-img-wrap">
                                @if($product->pro_image)
                                    <img src="{{ asset('storage/' . $product->pro_image) }}" alt="{{ $product->pro_name }}" class="product-card-image">
                                @else
                                    <div style="background: linear-gradient(135deg, {{ '#' . substr(md5($product->pro_name), 0, 6) }}, {{ '#' . substr(md5($product->pro_id), 0, 6) }}); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-print"></i>
                                    </div>
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
                <div class="text-center mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-primary px-5">{{ __('messages.view_all_products') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== 5. Latest Products ====== -->
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.latest_products') }}</h2>
        </div>
        <div class="row g-4">
            @foreach($products->take(4) as $product)
            <div class="col-md-3 col-sm-6 col-6">
                <div class="product-card">
                    <div class="product-image">
                        @if($product->pro_image)
                            <img src="{{ asset('storage/' . $product->pro_image) }}" alt="{{ $product->pro_name }}" class="product-card-image">
                        @else
                            <i class="fas fa-print"></i>
                        @endif
                    </div>
                    <div class="product-content">
                        <h3 class="product-title">{{ $product->pro_name }}</h3>
                        <p class="product-desc">{{ Str::limit($product->pro_desc, 60) }}</p>
                        <div class="product-meta">
                            <span class="product-delivery">
                                <i class="fas fa-truck"></i> {{ __('messages.fast_delivery') }}
                            </span>
                            <span class="product-price">${{ $product->pro_price }}</span>
                        </div>
                        <a href="{{ route('products.show', $product->pro_id) }}" class="product-link">{{ __('messages.view_details') }}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary px-5">{{ __('messages.view_all_products') }}</a>
        </div>
    </div>
</section>

<!-- ====== 6. Categories Section ====== -->
<section class="categories-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.printing_categories') }}</h2>
            <p class="text-muted mt-3">{{ __('messages.categories_description') }}</p>
        </div>
        <ul class="category-list">
            <li><a href="{{ route('products.index') }}?category=1"><i class="fas fa-address-card me-2"></i>{{ __('messages.cat_business_cards') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=2"><i class="fas fa-file-alt me-2"></i>{{ __('messages.cat_flyers') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=3"><i class="fas fa-book me-2"></i>{{ __('messages.cat_booklets') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=4"><i class="fas fa-image me-2"></i>{{ __('messages.cat_posters') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=5"><i class="fas fa-sticky-note me-2"></i>{{ __('messages.cat_stickers') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=6"><i class="fas fa-envelope me-2"></i>{{ __('messages.cat_envelopes') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=8"><i class="fas fa-red-envelope me-2"></i>{{ __('messages.cat_red_packet') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=9"><i class="fas fa-gift me-2"></i>{{ __('messages.cat_gifts') }}</a></li>
        </ul>
    </div>
</section>

<!-- ====== 7. Popular Products ====== -->
<section class="popular-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.popular_products') }}</h2>
        </div>
        <div class="popular-grid">
            <a href="{{ route('products.index') }}?category=1" class="popular-item">
                <div class="popular-image">
                    <img src="{{ asset('storage/products/business-card_1.png') }}" alt="Business Cards" class="popular-card-image">
                </div>
                <span class="popular-name">{{ __('messages.business_cards') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=2" class="popular-item">
                <div class="popular-image">
                    <img src="{{ asset('storage/products/flyer_1.png') }}" alt="Flyers" class="popular-card-image">
                </div>
                <span class="popular-name">{{ __('messages.brochures') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=3" class="popular-item">
                <div class="popular-image">
                    <img src="{{ asset('storage/products/brochure_1.png') }}" alt="Booklets" class="popular-card-image">
                </div>
                <span class="popular-name">{{ __('messages.booklets') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=4" class="popular-item">
                <div class="popular-image">
                    <img src="{{ asset('storage/products/poster_1.png') }}" alt="Posters" class="popular-card-image">
                </div>
                <span class="popular-name">{{ __('messages.posters') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=6" class="popular-item">
                <div class="popular-image">
                    <img src="{{ asset('storage/products/service-design.jpg') }}" alt="Envelopes" class="popular-card-image">
                </div>
                <span class="popular-name">{{ __('messages.envelopes_letterhead') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=8" class="popular-item">
                <div class="popular-image">
                    <img src="{{ asset('storage/products/banner_1.png') }}" alt="Red Packets" class="popular-card-image">
                </div>
                <span class="popular-name">{{ __('messages.cat_red_packet') }}</span>
            </a>
        </div>
    </div>
</section>

<!-- ====== 8. Trust Badges ====== -->
<section class="trust-badges">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <i class="fas fa-award"></i>
                    <h5>{{ __('messages.high_quality') }}</h5>
                    <p>{{ __('messages.quality_printing') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <i class="fas fa-truck"></i>
                    <h5>{{ __('messages.fast_delivery') }}</h5>
                    <p>{{ __('messages.on_time_delivery') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <i class="fas fa-hand-holding-usd"></i>
                    <h5>{{ __('messages.competitive_pricing') }}</h5>
                    <p>{{ __('messages.best_price_guarantee') }}</p>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="trust-badge-item">
                    <i class="fas fa-headset"></i>
                    <h5>{{ __('messages.excellent_service') }}</h5>
                    <p>{{ __('messages.free_design_consultation') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== 9. Quick Quote Section ====== -->
<section class="quote-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.quick_quote') }}</h2>
        </div>
        <div class="quote-methods">
            <div class="quote-method">
                <i class="fas fa-calculator"></i>
                <h4>{{ __('messages.online_quote') }}</h4>
                <p>{{ __('messages.instant_quote_description') }}</p>
                <a href="{{ route('order.create') }}">{{ __('messages.get_quote_now') }}</a>
            </div>
            <div class="quote-method">
                <i class="fas fa-phone-alt"></i>
                <h4>{{ __('messages.phone_quote') }}</h4>
                <p>{{ __('messages.phone_quote_description') }}</p>
                <a href="tel:+85225657997">{{ __('messages.call_us') }}</a>
            </div>
            <div class="quote-method">
                <i class="fas fa-envelope"></i>
                <h4>{{ __('messages.email_quote') }}</h4>
                <p>{{ __('messages.email_quote_description') }}</p>
                <a href="mailto:sales@giftandpremium.com.hk">{{ __('messages.email_us') }}</a>
            </div>
        </div>
    </div>
</section>

@endsection