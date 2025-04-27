<!-- resources/views/backend/styles/edit.blade.php -->
@extends('backend.admin.layout')


@section('header', 'Sửa phong cách')

@section('content')
    <br>

    <form action="{{ route('styles.update', $style->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')
        <div>
            <label for="style_name" class="block">Tên phong cách:</label>
            <input type="text" name="style_name" id="style_name" class="border rounded p-2 w-full" value="{{ $style->style_name }}" required>
        </div>
        <div class="mt-4">
            <label for="description" class="block">Mô tả:</label>
            <textarea name="description" id="description" class="border rounded p-2 w-full">{{ $style->description }}</textarea>
        </div>
        <button type="submit" class="mt-4 bg-blue-500 text-white p-2 rounded">Cập nhật phong cách</button>
    </form>
@endsection