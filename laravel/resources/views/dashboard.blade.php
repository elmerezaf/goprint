@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h3>{{ __('messages.dashboard') }}</h3>
        </div>
        <div class="card-body">
            <div class="welcome">
                <h4>{{ __('messages.welcome_back') }}, {{ Auth::user()->name }}!</h4>
                <p class="text-muted mt-2">{{ __('messages.welcome_message') }}</p>
            </div>

            <div class="mt-4">
                <h5>{{ __('messages.quick_actions') }}</h5>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-4xl mb-2">📋</div>
                                <h6>{{ __('messages.my_orders') }}</h6>
                                <p class="text-sm text-muted">{{ __('messages.view_manage_orders') }}</p>
                                <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm mt-2">{{ __('messages.view_orders') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-4xl mb-2">🛒</div>
                                <h6>{{ __('messages.shopping_cart') }}</h6>
                                <p class="text-sm text-muted">{{ __('messages.manage_cart_items') }}</p>
                                <a href="{{ route('cart.index') }}" class="btn btn-primary btn-sm mt-2">{{ __('messages.view_cart') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="text-4xl mb-2">👤</div>
                                <h6>{{ __('messages.profile') }}</h6>
                                <p class="text-sm text-muted">{{ __('messages.update_profile_info') }}</p>
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm mt-2">{{ __('messages.edit_profile') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection