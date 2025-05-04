@extends('backend.admin.layout')

@section('title', 'Quản lý tìm kiếm gần đây')

@section('header', 'Quản lý tìm kiếm gần đây')

@section('content')
<style> 
    table th {
        background-color: #f5f7fa !important;
        border: none !important;
    }

    table td {
        border: none !important;
    }

    .card {
        border-radius: 12px;
    }

</style> 
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
          <h1 class="text-2xl font-bold text-gray-800 mb-4">Tìm kiếm </h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle text-center mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead class="bg-gray-100 p-4 rounded-lg mb-4" style="border-radius: 12px;">
                        <tr>
                            <th class="py-3">STT</th>
                            <th class="text-lg text-gray-700">👤 Người dùng </th>
                            <th class="text-lg text-gray-700">🔍 Từ khoá</th>
                            <th class="text-lg text-gray-700">🎨 Phong cách</th>
                            <th class="text-lg text-gray-700">💰 Khoảng giá</th>
                            <th class="text-lg text-gray-700">📍 Vị trí</th>
                            <th class="text-lg text-gray-700">📏 Khoảng cách</th>
                            <th class="text-lg text-gray-700">📋 Kết quả</th>
                            <th class="text-lg text-gray-700">⏰ Thời gian hihhihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($searches as $index => $search)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $search->user?->full_name ?? 'Không rõ' }}</td>
                            <td>{{ $search->keyword ?? '---' }}</td>
                            <td>{{ $search->style?->style_name ?? '---' }}</td>
                            <td>
                                @if($search->min_price && $search->max_price)
                                    {{ $search->min_price }} - {{ $search->max_price }}k
                                @else
                                    ---
                                @endif
                            </td>
                            <td>{{ $search->latitude ?? '?' }}, {{ $search->longitude ?? '?' }}</td>
                            <td>{{ $search->distance ? $search->distance . ' km' : '---' }}</td>
                            <td>
                                @if($search->result_count > 0)
                                    <span class="badge bg-success">{{ $search->result_count }}</span>
                                @else
                                    <span class="badge bg-danger">0</span>
                                @endif
                            </td>
                            <td>{{ $search->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">Không có dữ liệu tìm kiếm gần đây.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $searches->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
