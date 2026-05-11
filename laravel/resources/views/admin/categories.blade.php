@extends('layouts.app')

@section('title', '產品分類管理')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">產品分類管理</h2>
        <p class="text-muted">管理產品分類，包括添加、編輯和刪除分類</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>分類列表</h3>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                添加新分類
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>分類名稱</th>
                        <th>分類描述</th>
                        <th>產品數量</th>
                        <th>創建時間</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->cat_id }}</td>
                        <td>{{ $category->cat_name }}</td>
                        <td>{{ $category->cat_desc ?: '無描述' }}</td>
                        <td>{{ $category->products()->count() }}</td>
                        <td>{{ $category->create_time }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->cat_id) }}" 
                               class="btn btn-sm btn-primary">
                                編輯
                            </a>
                            <form action="{{ route('admin.categories.delete', $category->cat_id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('確定要刪除此分類嗎？')">
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