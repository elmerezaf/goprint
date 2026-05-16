@extends('layouts.app')
@section('title', __('messages.contact'))
@section('content')

<div class="container py-5">
    <!-- Page Header -->
    <div class="bg-primary text-white rounded-3 p-5 mb-5 shadow">
        <h1 class="display-5 fw-bold mb-3">{{ __('messages.contact_us') }}</h1>
        <p class="lead mb-0 opacity-90">{{ __('messages.get_quote_description') }}</p>
    </div>

    <div class="row g-4">
        <!-- Contact Info Cards -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-4">
                        <i class="fas fa-info-circle me-2"></i>{{ __('messages.contact_info') }}
                    </h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-4 text-center h-100">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-phone fa-lg"></i>
                                </div>
                                <h5 class="fw-bold">{{ __('messages.phone') }}</h5>
                                <p class="mb-0 text-muted">(852) 2565 7997</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-4 text-center h-100">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-fax fa-lg"></i>
                                </div>
                                <h5 class="fw-bold">Fax</h5>
                                <p class="mb-0 text-muted">(852) 2565 7838</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-4 text-center h-100">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-envelope fa-lg"></i>
                                </div>
                                <h5 class="fw-bold">{{ __('messages.email') }}</h5>
                                <p class="mb-0 text-muted">sales@giftandpremium.com.hk</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-4 text-center h-100">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-subway fa-lg"></i>
                                </div>
                                <h5 class="fw-bold">Transport</h5>
                                <p class="mb-0 text-muted">炮台山站A出口（步行5分鐘）</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address & Map -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-primary mb-4">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ __('messages.address') }}
                    </h3>
                    <div class="bg-light rounded-3 p-4 mb-4">
                        <p class="mb-2 fs-6">{{ __('messages.office_address') }}:</p>
                        <p class="fw-bold">香港北角屈臣道4-6號<br>海景大廈B座605室</p>
                        <hr>
                        <p class="mb-1"><i class="fas fa-subway text-primary me-2"></i>炮台山站A出口（步行5分鐘）</p>
                        <p class="mb-1 mt-2"><i class="fas fa-clock text-primary me-2"></i>{{ __('messages.office_hours_label') }}</p>
                        <p class="small text-muted ms-4">{{ __('messages.office_hours') }}</p>
                    </div>
                    <div class="bg-light rounded-3 p-4 text-center">
                        <i class="fas fa-map-marked-alt fa-3x text-primary mb-3"></i>
                        <p class="text-muted mb-0"><i class="fas fa-info-circle me-1"></i>{{ __('messages.visit_by_appointment') }}</p>
                        <a href="https://maps.google.com/?q=香港北角屈臣道4-6號海景大廈B座605室" target="_blank" class="btn btn-primary mt-3">
                            <i class="fab fa-google me-2"></i>{{ __('messages.open_in_map') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
