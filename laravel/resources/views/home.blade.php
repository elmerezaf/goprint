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
                <div class="carousel-caption">
                    <h1>{{ __('messages.carousel_slide_1_title') }}</h1>
                    <p>{{ __('messages.carousel_slide_1_subtitle') }}</p>
                    <a href="{{ route('products.index') }}" class="btn btn-warning text-white">{{ __('messages.carousel_slide_1_btn') }}</a>
                </div>
            </div>
            <div class="carousel-item slide-2">
                <div class="carousel-caption">
                    <h1>{{ __('messages.carousel_slide_2_title') }}</h1>
                    <p>{{ __('messages.carousel_slide_2_subtitle') }}</p>
                    <a href="#design-tools" class="btn btn-warning text-white">{{ __('messages.carousel_slide_2_btn') }}</a>
                </div>
            </div>
            <div class="carousel-item slide-3">
                <div class="carousel-caption">
                    <h1>{{ __('messages.carousel_slide_3_title') }}</h1>
                    <p>{{ __('messages.carousel_slide_3_subtitle') }}</p>
                    <a href="{{ route('order.create') }}" class="btn btn-warning text-white">{{ __('messages.carousel_slide_3_btn') }}</a>
                </div>
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

<!-- ====== 2. Quick Links ====== -->
<section class="quick-links">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-4 col-lg">
                <a href="{{ route('products.index') }}?category=business-cards" class="quick-link">
                    <i class="fas fa-id-card"></i>
                    <span>{{ __('messages.business_cards') }}</span>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <a href="{{ route('products.index') }}?category=flyers" class="quick-link">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ __('messages.flyers') }}</span>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <a href="{{ route('products.index') }}?category=booklets" class="quick-link">
                    <i class="fas fa-book"></i>
                    <span>{{ __('messages.booklets') }}</span>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <a href="{{ route('products.index') }}?category=envelopes" class="quick-link">
                    <i class="fas fa-envelope"></i>
                    <span>{{ __('messages.envelopes') }}</span>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg">
                <a href="{{ route('products.index') }}?category=packaging" class="quick-link">
                    <i class="fas fa-box"></i>
                    <span>{{ __('messages.packaging') }}</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ====== 3. Online Design Tools ====== -->
<section class="design-tools-section" id="design-tools">
    <div class="container">
        <div class="design-tools-header">
            <h2>{{ __('messages.online_design_tools') }}</h2>
            <p>{{ __('messages.online_design_subtitle') }}</p>
        </div>
        <div class="design-tools-grid">
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-id-card"></i></div>
                <span>{{ __('messages.design_business_card') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-file-alt"></i></div>
                <span>{{ __('messages.design_flyer') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-image"></i></div>
                <span>{{ __('messages.design_poster') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-book-open"></i></div>
                <span>{{ __('messages.design_brochure') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-file"></i></div>
                <span>{{ __('messages.design_leaflet') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-tag"></i></div>
                <span>{{ __('messages.design_sticker') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-flag"></i></div>
                <span>{{ __('messages.design_banner') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-envelope"></i></div>
                <span>{{ __('messages.design_envelope') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-book"></i></div>
                <span>{{ __('messages.design_booklet') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-book"></i></div>
                <span>{{ __('messages.design_catalog') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-certificate"></i></div>
                <span>{{ __('messages.design_certificate') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-inbox"></i></div>
                <span>{{ __('messages.design_invitation') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-tag"></i></div>
                <span>{{ __('messages.design_label') }}</span>
            </a>
            <a href="{{ route('designer.index') }}" class="design-tool-card">
                <div class="tool-icon"><i class="fas fa-table"></i></div>
                <span>{{ __('messages.design_form') }}</span>
            </a>
        </div>
        <div class="design-tools-cta">
            <a href="{{ route('designer.index') }}" class="btn btn-primary">{{ __('messages.start_design') }}</a>
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
                    <div class="col-md-4 col-sm-6">
                        <div class="product-center-card">
                            <div class="card-img-wrap" style="background: linear-gradient(135deg, {{ '#' . substr(md5($product->pro_name), 0, 6) }}, {{ '#' . substr(md5($product->pro_id), 0, 6) }});">
                                <i class="fas fa-print"></i>
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
            <div class="col-md-3">
                <div class="product-card">
                    <div class="product-image" style="background: linear-gradient(135deg, {{ '#' . substr(md5($product->pro_name . 'a'), 0, 6) }}, {{ '#' . substr(md5($product->pro_name . 'b'), 0, 6) }});">
                        <i class="fas fa-print"></i>
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
            <li><a href="{{ route('products.index') }}?category=office"><i class="fas fa-building me-2"></i>{{ __('messages.office_supplies') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=wedding"><i class="fas fa-heart me-2"></i>{{ __('messages.wedding') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=food"><i class="fas fa-utensils me-2"></i>{{ __('messages.restaurant') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=school"><i class="fas fa-graduation-cap me-2"></i>{{ __('messages.school') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=kids"><i class="fas fa-child me-2"></i>{{ __('messages.kids') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=exhibition"><i class="fas fa-store me-2"></i>{{ __('messages.exhibition') }}</a></li>
            <li><a href="{{ route('products.index') }}?category=gifts"><i class="fas fa-gift me-2"></i>{{ __('messages.corporate_gifts') }}</a></li>
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
            <a href="{{ route('products.index') }}?category=business-cards" class="popular-item">
                <div class="popular-image" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <i class="fas fa-id-card"></i>
                </div>
                <span class="popular-name">{{ __('messages.business_cards') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=flyers" class="popular-item">
                <div class="popular-image" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                    <i class="fas fa-file-alt"></i>
                </div>
                <span class="popular-name">{{ __('messages.brochures') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=booklets" class="popular-item">
                <div class="popular-image" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                    <i class="fas fa-book"></i>
                </div>
                <span class="popular-name">{{ __('messages.booklets') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=stamps" class="popular-item">
                <div class="popular-image" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                    <i class="fas fa-stamp"></i>
                </div>
                <span class="popular-name">{{ __('messages.stamps') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=envelopes" class="popular-item">
                <div class="popular-image" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                    <i class="fas fa-envelope"></i>
                </div>
                <span class="popular-name">{{ __('messages.envelopes_letterhead') }}</span>
            </a>
            <a href="{{ route('products.index') }}?category=folders" class="popular-item">
                <div class="popular-image" style="background: linear-gradient(135deg, #a18cd1, #fbc2eb);">
                    <i class="fas fa-folder"></i>
                </div>
                <span class="popular-name">{{ __('messages.folders') }}</span>
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
                <a href="mailto:quote@goprint.com">{{ __('messages.email_us') }}</a>
            </div>
        </div>
    </div>
</section>

@endsection
