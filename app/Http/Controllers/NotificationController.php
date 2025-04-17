<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Lấy danh sách thông báo của user
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Nếu có yêu cầu xem chi tiết
        $current = null;
        if ($request->has('view_id')) {
            $current = Notification::where('user_id', $userId)->find($request->view_id);

            // Đánh dấu đã đọc nếu chưa đọc
            if ($current && !$current->is_read) {
                $current->update(['is_read' => true]);
            }
        }

        return view('frontend.thongbao', compact('notifications', 'current'));
    }
}
