<!-- resources/views/backend/styles/show.blade.php -->
@extends('backend.admin.layout')


@section('header', 'Chi tiết phong cách')

@section('content')
<br>
<br>
    <h1 class="text-2xl font-bold">{{ $style->style_name }}</h1>
    <p class="mt-2">{{ $style->description }}</p>

    <a href="{{ route('styles.index') }}" class="mt-4 inline-block bg-blue-500 text-white p-2 rounded">Quay lại danh sách phong cách</a>
@endsection