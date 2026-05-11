@extends('layouts.app')

@section('title', __('messages.shipping_addresses'))

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="d-flex justify-between items-center mb-6">
        <h1>{{ __('messages.shipping_addresses') }}</h1>
        <a href="{{ route('addresses.create') }}" class="btn btn-primary">{{ __('messages.add_address') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(count($addresses) > 0)
        <div class="row gap-4">
            @foreach($addresses as $address)
                <div class="col-md-6">
                    <div class="card @if($address->is_default) border-primary @endif">
                        <div class="card-body">
                            @if($address->is_default)
                                <span class="badge bg-primary mb-2">{{ __('messages.default_address') }}</span>
                            @endif
                            <h5 class="card-title">{{ $address->name }}</h5>
                            <p class="card-text">📞 {{ $address->phone }}</p>
                            <p class="card-text">📍 {{ $address->address }}</p>
                            @if($address->city || $address->district)
                                <p class="card-text text-muted text-sm">
                                    {{ $address->city }} {{ $address->district }}
                                </p>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-secondary">{{ __('messages.edit') }}</a>
                                @if(!$address->is_default)
                                    <a href="{{ route('addresses.setDefault', $address->id) }}" class="btn btn-sm btn-primary">{{ __('messages.set_as_default') }}</a>
                                @endif
                                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('messages.confirm_delete_address') }}')">{{ __('messages.delete') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-12">
                <div class="text-6xl mb-4">📍</div>
                <h3 class="text-xl mb-2">{{ __('messages.no_shipping_address') }}</h3>
                <p class="text-muted mb-4">{{ __('messages.add_address_prompt') }}</p>
                <a href="{{ route('addresses.create') }}" class="btn btn-primary">{{ __('messages.add_address') }}</a>
            </div>
        </div>
    @endif
</div>
@endsection