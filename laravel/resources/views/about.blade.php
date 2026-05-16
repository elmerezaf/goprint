@extends('layouts.app')

@section('title', __('messages.about_us'))

@section('content')
<!-- ====== Hero ====== -->
<section class="position-relative text-white" style="background: linear-gradient(135deg, #1f2937 0%, #374151 100%); padding: 80px 0;">
    <div class="container text-center">
        <h1 class="fw-bold display-5 mb-3">{{ __('messages.about_hero_title') }}</h1>
        <p class="lead mx-auto" style="max-width: 700px; opacity: 0.9;">{{ __('messages.about_hero_subtitle') }}</p>
    </div>
</section>

<!-- ====== Our Story ====== -->
<section style="padding: 70px 0;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">{{ __('messages.our_story') }}</h2>
                <p style="line-height: 2; font-size: 1.05rem;">{{ __('messages.our_story_content') }}</p>
            </div>
            <div class="col-lg-6">
                <div class="rounded-4 p-5 text-white text-center" style="background: linear-gradient(135deg, #f59e0b, #f97316);">
                    <i class="fas fa-quote-left fa-2x mb-3" style="opacity:0.5;"></i>
                    <p class="fs-5 fst-italic mb-4">讓每個人都可以輕鬆印出專業水準的成品</p>
                    <p class="fw-bold mb-0">— GoPrint 團隊</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Our Mission ====== -->
<section style="padding: 70px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2">
                <h2 class="fw-bold mb-4">{{ __('messages.our_mission') }}</h2>
                <p style="line-height: 2; font-size: 1.05rem;">{{ __('messages.our_mission_content') }}</p>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="row g-4">
                    <div class="col-6">
                        <div class="bg-white rounded-3 p-4 text-center shadow-sm">
                            <i class="fas fa-check-circle fa-2x text-warning mb-3"></i>
                            <h5 class="fw-bold">{{ __('messages.trust_quality_title') }}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white rounded-3 p-4 text-center shadow-sm">
                            <i class="fas fa-truck-fast fa-2x text-warning mb-3"></i>
                            <h5 class="fw-bold">{{ __('messages.trust_delivery_title') }}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white rounded-3 p-4 text-center shadow-sm">
                            <i class="fas fa-tags fa-2x text-warning mb-3"></i>
                            <h5 class="fw-bold">{{ __('messages.trust_price_title') }}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-white rounded-3 p-4 text-center shadow-sm">
                            <i class="fas fa-handshake fa-2x text-warning mb-3"></i>
                            <h5 class="fw-bold">{{ __('messages.trust_service_title') }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Service Items ====== -->
<section style="padding: 70px 0;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.service_items') }}</h2>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-address-card fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_1') }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-file-alt fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_2') }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-book fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_3') }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-box-open fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_4') }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-sticky-note fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_5') }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-gift fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_6') }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-calendar-alt fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_7') }}</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <i class="fas fa-bolt fa-2x text-warning mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.service_item_8') }}</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====== Our Team ====== -->
<section style="padding: 70px 0; background: #f8f9fa;">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('messages.our_team') }}</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <p class="text-center" style="line-height: 2; font-size: 1.05rem;">{{ __('messages.our_team_content') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- ====== CTA ====== -->
<section style="padding: 60px 0; background: linear-gradient(135deg, #f59e0b, #f97316);">
    <div class="container text-center text-white">
        <h2 class="fw-bold mb-3">{{ __('messages.ready_to_start') }}</h2>
        <p class="mb-4" style="opacity:0.9;">{{ __('messages.contact_us_today') }}</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('order.create') }}" class="btn btn-dark btn-lg px-4">{{ __('messages.get_quote_now') }}</a>
            <a href="{{ url('/contact') }}" class="btn btn-outline-light btn-lg px-4">{{ __('messages.contact_us') }}</a>
        </div>
    </div>
</section>
@endsection