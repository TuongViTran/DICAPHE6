<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id(); // Lấy ID user hiện tại

        // Lấy tất cả thông báo của user, mới nhất trước
        $notifications = Notification::where('user_id', $userId)
                            ->orderByDesc('created_at')
                            ->paginate(10);

        // Lấy thông báo cụ thể nếu có view_id
        $current = null;
        if ($request->has('view_id')) {
            $current = Notification::where('user_id', $userId)->find($request->get('view_id'));

            if ($current && !$current->is_read) {
                $current->update(['is_read' => true]);
            }
        }

        // Đếm số lượng thông báo chưa đọc để hiển thị ở menu
        $unreadCount = Notification::where('user_id', $userId)
                            ->where('is_read', false)
                            ->count();

        return view('frontend.thongbao', compact('notifications', 'current', 'unreadCount'));
    }
}

