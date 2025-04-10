<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function feed()
    {
        // Lấy danh sách review kèm thông tin user và sắp xếp theo thời gian mới nhất
        $reviews = Review::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('frontend.feed', compact('reviews'));
    }
}

