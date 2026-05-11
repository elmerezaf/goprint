@extends('layouts.app')

@section('title', __('messages.admin_panel'))

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">{{ __('messages.admin_dashboard') }}</h2>
        <p class="text-muted">{{ __('messages.welcome_back') }}, {{ Auth::user()->name }}!</p>
    </div>

    <div class="row mb-6">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="text-4xl mb-2">📋</div>
                    <h3 class="card-title">{{ __('messages.total_orders') }}</h3>
                    <p class="text-3xl font-bold">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="text-4xl mb-2">⏳</div>
                    <h3 class="card-title">{{ __('messages.pending_orders') }}</h3>
                    <p class="text-3xl font-bold">{{ $pendingOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="text-4xl mb-2">✅</div>
                    <h3 class="card-title">{{ __('messages.completed_orders') }}</h3>
                    <p class="text-3xl font-bold">{{ $completedOrders }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>{{ __('messages.quick_actions') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <a href="{{ route('admin.orders') }}" class="btn btn-primary w-100 py-3">
                        <div class="text-2xl mb-2">📦</div>
                        <span>{{ __('messages.view_all_orders') }}</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('order.create') }}" class="btn btn-success w-100 py-3">
                        <div class="text-2xl mb-2">➕</div>
                        <span>{{ __('messages.new_order') }}</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.products') }}" class="btn btn-info w-100 py-3">
                        <div class="text-2xl mb-2">📷</div>
                        <span>{{ __('messages.product_management') }}</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.categories') }}" class="btn btn-success w-100 py-3">
                        <div class="text-2xl mb-2">📁</div>
                        <span>{{ __('messages.category_management') }}</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.reports') }}" class="btn btn-warning w-100 py-3">
                        <div class="text-2xl mb-2">📊</div>
                        <span>{{ __('messages.reports') }}</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('profile.edit') }}" class="btn btn-info w-100 py-3">
                        <div class="text-2xl mb-2">👤</div>
                        <span>{{ __('messages.profile_settings') }}</span>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/') }}" class="btn btn-secondary w-100 py-3">
                        <div class="text-2xl mb-2">🏠</div>
                        <span>{{ __('messages.back_home') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
