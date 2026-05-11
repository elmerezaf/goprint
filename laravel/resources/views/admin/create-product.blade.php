@extends('layouts.app')

@section('title', '添加新產品')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">添加新產品</h2>
        <p class="text-muted">創建新的產品</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pro_name">產品名稱 <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="pro_name" 
                                   id="pro_name" 
                                   class="form-control @error('pro_name') is-invalid @enderror"
                                   value="{{ old('pro_name') }}"
                                   required>
                            @error('pro_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="pro_price">產品價格 <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="pro_price" 
                                   id="pro_price" 
                                   step="0.01"
                                   min="0"
                                   class="form-control @error('pro_price') is-invalid @enderror"
                                   value="{{ old('pro_price') }}"
                                   required>
                            @error('pro_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="pro_stock">庫存數量 <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="pro_stock" 
                                   id="pro_stock" 
                                   min="0"
                                   class="form-control @error('pro_stock') is-invalid @enderror"
                                   value="{{ old('pro_stock') }}"
                                   required>
                            @error('pro_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="cat_id">產品分類 <span class="text-danger">*</span></label>
                            <select name="cat_id" 
                                    id="cat_id" 
                                    class="form-control @error('cat_id') is-invalid @enderror"
                                    required>
                                <option value="">請選擇分類</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->cat_id }}" 
                                            {{ old('cat_id') == $category->cat_id ? 'selected' : '' }}>
                                        {{ $category->cat_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pro_desc">產品描述</label>
                            <textarea name="pro_desc" 
                                      id="pro_desc" 
                                      class="form-control"
                                      rows="4">{{ old('pro_desc') }}</textarea>
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="image">產品圖片</label>
                            <input type="file" 
                                   name="image" 
                                   id="image" 
                                   class="form-control-file @error('image') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <p class="text-muted mt-1">支持 JPEG、PNG、JPG、GIF 格式，最大 2MB（可選）</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        創建產品
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary ml-2">
                        返回列表
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection