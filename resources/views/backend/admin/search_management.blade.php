@extends('backend.admin.layout')

@section('title', 'Quản lý tìm kiếm gần đây')

@section('header', 'Quản lý tìm kiếm gần đây')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Danh sách tìm kiếm gần đây</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Từ khoá</th>
                            <th>Phong cách</th>
                            <th>Khoảng giá</th>
                            <th>Vị trí</th>
                            <th>Khoảng cách</th>
                            <th>Kết quả tìm được</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSearches as $search)
                        <tr>
                            <td>{{ $search->id }}</td>
                            <td>{{ $search->user ? $search->user->full_name : 'Không rõ' }}</td>
                            <td>{{ $search->keyword ?? '---' }}</td>
                            <td>{{ $search->style ? $search->style->style_name : '---' }}</td>
                            <td>
                                @if($search->min_price && $search->max_price)
                                    {{ $search->min_price }} - {{ $search->max_price }}k
                                @else
                                    ---
                                @endif
                            </td>
                            <td>
                                {{ $search->latitude ?? '?' }}, {{ $search->longitude ?? '?' }}
                            </td>
                            <td>{{ $search->distance ? $search->distance . ' km' : '---' }}</td>
                            <td>{{ $search->result_count ?? '0' }}</td>
                            <td>{{ $search->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $recentSearches->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
