@extends('layouts.app')

@section('title', '產品管理')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">產品管理</h2>
        <p class="text-muted">管理所有產品，包括添加、編輯、刪除和上傳圖片</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>產品列表</h3>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                添加新產品
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>產品名稱</th>
                        <th>價格</th>
                        <th>庫存</th>
                        <th>分類</th>
                        <th>當前圖片</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->pro_id }}</td>
                        <td>{{ $product->pro_name }}</td>
                        <td>¥{{ $product->pro_price }}</td>
                        <td>{{ $product->pro_stock }}</td>
                        <td>{{ $product->category->cat_name ?? '未分類' }}</td>
                        <td>
                            @if($product->pro_image)
                                <img src="{{ asset('storage/products/' . $product->pro_image) }}" 
                                     alt="{{ $product->pro_name }}" 
                                     width="50" 
                                     class="rounded">
                            @else
                                <span class="text-muted">無圖片</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->pro_id) }}" 
                               class="btn btn-sm btn-primary">
                                編輯
                            </a>
                            <form action="{{ route('admin.products.delete', $product->pro_id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('確定要刪除此產品嗎？')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    刪除
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection