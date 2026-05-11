@extends('layouts.app')
@section('title', __('messages.about'))
@section('content')

<div class="container py-5">
    <!-- Page Header -->
    <div class="bg-primary text-white rounded-3 p-5 mb-5 shadow">
        <h1 class="display-5 fw-bold mb-3">{{ __('messages.about_us') }}</h1>
        <p class="lead mb-0 opacity-90">{{ __('messages.quality_printing') }} — {{ __('messages.excellent_service') }}</p>
    </div>

    <div class="row g-4">
        <!-- Company Info -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-4">
                        <i class="fas fa-building me-2"></i>{{ __('messages.company_info') }}
                    </h3>
                    <p class="fs-5 text-muted mb-4">{{ __('messages.company_info') }}</p>
                    <hr>
                    <h4 class="fw-bold mb-3">{{ __('messages.our_services') }}</h4>
                    <p>{{ __('messages.our_services') }}</p>
                    <div class="row g-3 mt-3">
                        <div class="col-sm-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <i class="fas fa-print fa-2x text-primary mb-2"></i>
                                <p class="fw-bold mb-1">{{ __('messages.digital_printing') }}</p>
                                <small class="text-muted">{{ __('messages.digital_printing_desc') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                <p class="fw-bold mb-1">{{ __('messages.offset_printing') }}</p>
                                <small class="text-muted">{{ __('messages.offset_printing_desc') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <i class="fas fa-gem fa-2x text-primary mb-2"></i>
                                <p class="fw-bold mb-1">{{ __('messages.special_finishing') }}</p>
                                <small class="text-muted">{{ __('messages.special_finishing_desc') }}</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <i class="fas fa-pencil-ruler fa-2x text-primary mb-2"></i>
                                <p class="fw-bold mb-1">{{ __('messages.free_design_consultation') }}</p>
                                <small class="text-muted">{{ __('messages.online_design_subtitle') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-4">
                        <i class="fas fa-star me-2"></i>{{ __('messages.why_choose_us') }}
                    </h3>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-start mb-4">
                            <i class="fas fa-check-circle text-success me-3 mt-1 fa-lg"></i>
                            <div>
                                <strong>{{ __('messages.high_quality') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('messages.quality_printing') }}</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-4">
                            <i class="fas fa-truck text-success me-3 mt-1 fa-lg"></i>
                            <div>
                                <strong>{{ __('messages.fast_delivery') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('messages.on_time_delivery') }}</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-4">
                            <i class="fas fa-tag text-success me-3 mt-1 fa-lg"></i>
                            <div>
                                <strong>{{ __('messages.competitive_pricing') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('messages.best_price_guarantee') }}</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-headset text-success me-3 mt-1 fa-lg"></i>
                            <div>
                                <strong>{{ __('messages.excellent_service') }}</strong>
                                <p class="text-muted mb-0 small">{{ __('messages.free_design_consultation') }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
