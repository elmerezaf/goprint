@extends('layouts.app')

@section('title', '编辑收货地址')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="mb-6">编辑收货地址</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('addresses.update', $address->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <label for="name" class="form-label">收件人姓名 <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $address->name) }}">
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label">聯絡電話 <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" name="phone" required placeholder="8位數字" value="{{ old('phone', $address->phone) }}">
                </div>

                <div class="mb-4">
                    <label for="city" class="form-label">城市</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="如：香港" value="{{ old('city', $address->city) }}">
                </div>

                <div class="mb-4">
                    <label for="district" class="form-label">地區</label>
                    <input type="text" class="form-control" id="district" name="district" placeholder="如：九龍" value="{{ old('district', $address->district) }}">
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label">詳細地址 <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address', $address->address) }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" @if($address->is_default) checked @endif>
                        <label class="form-check-label" for="is_default">設為默認地址</label>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary">更新地址</button>
                    <a href="{{ route('addresses.index') }}" class="btn btn-secondary">取消</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection