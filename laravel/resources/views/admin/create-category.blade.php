@extends('layouts.app')

@section('title', '添加產品分類')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">添加產品分類</h2>
        <p class="text-muted">創建新的產品分類</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="cat_name">分類名稱 <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="cat_name" 
                           id="cat_name" 
                           class="form-control @error('cat_name') is-invalid @enderror"
                           value="{{ old('cat_name') }}"
                           required>
                    @error('cat_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group mt-3">
                    <label for="cat_desc">分類描述</label>
                    <textarea name="cat_desc" 
                              id="cat_desc" 
                              class="form-control"
                              rows="3">{{ old('cat_desc') }}</textarea>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        創建分類
                    </button>
                    <a href="{{ route('admin.categories') }}" class="btn btn-secondary ml-2">
                        返回列表
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection