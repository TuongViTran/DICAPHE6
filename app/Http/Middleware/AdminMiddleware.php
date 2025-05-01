<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Kiểm tra nếu người dùng đã đăng nhập và có role hợp lệ
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);  // Tiếp tục xử lý request nếu role hợp lệ
        }
        // Nếu không phải admin, quay về trang chủ hoặc 403
        abort(403, 'Bạn không có quyền truy cập trang này.');
    }
}
