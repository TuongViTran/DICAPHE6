@extends('backend.admin.layout')

@section('title', 'Thêm phong cách')

@section('content')
    <h1 class="text-2xl font-bold">Thêm phong cách mới</h1>

    <form action="{{ route('styles.store') }}" method="POST"> <!-- Thay đổi từ styles.store thành style.store -->
        @csrf
        <div class="mb-4">
            <label for="style_name" class="block text-gray-700">Tên phong cách</label>
            <input type="text" name="style_name" id="style_name" class="border rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Mô tả</label>
            <textarea name="description" id="description" class="border rounded p-2 w-full"></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Thêm phong cách</button>
    </form>
@endsection