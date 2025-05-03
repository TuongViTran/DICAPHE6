<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CoffeeShopController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CafeManagementController;
use App\Http\Controllers\OwnerController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\AdminController; // Import AdminController
use App\Http\Controllers\ShopController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StyleController;
use App\Http\Controllers\Auth\PasswordController;
// Frontend --------------------------------------------
Route::get('/test-session', function () {
    Session::put('test_key', 'Hello Session');
    return 'Session đã được ghi!';
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Nếu có, comment hoặc xóa

Route::get('/', [HomeController::class, 'index'])->name('trangchu');
Route::get('/feed', [FeedController::class, 'feed'])->name('feed');
Route::get('/blog', [PostController::class, 'Blog_Post'])->name('tintuc');
Route::get('/thongbao', [HomeController::class, 'thongbao'])->name('thongbao');

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User
Route::get('/user/{id}', [UserController::class, 'showProfile'])->name('user');

// Owner
Route::get('/owner/{id}', [OwnerController::class, 'owner'])->name('owner'); 
Route::get('/owner/{id}/coffeeshops', [OwnerController::class, 'showByOwner'])->name('owner.coffeeshop'); 
Route::put('/menu/update/{id}', [OwnerController::class, 'update'])->name('menu.update'); 
Route::get('/owner/{id}/info', [OwnerController::class, 'infor'])->name('coffeeshop.owner'); 
Route::put('/owner/update/{id}', [OwnerController::class, 'updateinfor'])->name('owner.updateinfor'); 
Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');
Route::get('/owner/reviews/{shopId}', [OwnerController::class, 'showShopReviews'])->name('owner.reviews.byshop');


// Search 
Route::get('/search', [SearchController::class, 'search'])->name('search.result');
Route::get('/autocomplete', [SearchController::class, 'autocomplete']);





// Post Management Routes
Route::post('/ckeditor/upload', function (Request $request) {
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);
        $url = asset('uploads/' . $filename);

        return response()->json(['url' => $url]);
    }

    return response()->json(['error' => ['message' => 'Upload failed']], 400);
})->name('ckeditor.upload');

Route::get('/owner/{id}/posts', [PostController::class, 'index'])->name('posts.index'); // Hiển thị danh sách bài viết
Route::post('/owner/{id}/posts', [PostController::class, 'store'])->name('posts.store'); // Lưu bài viết mới
Route::delete('/posts/{postId}', [PostController::class, 'destroy'])->name('posts.destroy'); // Xóa bài viết
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update'); // Cập nhật bài viết
Route::post('/ckeditor/upload', [PostController::class, 'upload'])->name('ckeditor.upload'); // Upload ảnh cho CKEditor
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show'); // Hiển thị chi tiết bài viết
Route::post('/posts/{id}/comment', [PostController::class, 'storeComment'])->name('posts.comment'); // Lưu bình luận
Route::delete('/comments/{id}', [PostController::class, 'destroyComment'])->middleware('auth')->name('comments.destroy'); // Xóa bình luận
Route::put('/comments/{id}', [PostController::class, 'updateComment'])->middleware('auth')->name('comments.update');// Sửa bình luận


// Backend --------------------------------------------
// Route /dashboard gọi AdminController@dashboard, truyền biến đầy đủ cho view
Route::get('/dashboard', [AdminController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');

Route::post('/like-shop/{id}', [CoffeeShopController::class, 'like'])->name('shop.like');

// User Management Routes
Route::prefix('user-management')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('management'); // Hiển thị danh sách người dùng
    Route::get('/create', [UserController::class, 'create'])->name('create'); // Hiển thị form thêm mới người dùng
    Route::post('/', [UserController::class, 'store'])->name('store'); // Lưu người dùng mới 
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit'); // Hiển thị form chỉnh sửa người dùng
    Route::put('/{user}', [UserController::class, 'update'])->name('update'); // Cập nhật người dùng
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy'); // Xóa người dùng
    Route::get('/{user}', [UserController::class, 'show'])->name('show'); // Hiển thị thông tin người dùng
});

// Quản lý feedback
Route::prefix('feed-management')->name('feed.')->group(function () {
    Route::get('/', [FeedController::class, 'index'])->name('index');
    Route::get('/{id}', [FeedController::class, 'show'])->name('show');

    Route::delete('/{id}', [FeedController::class, 'destroy'])->name('destroy');
});

// Quản lý quán cà phê
Route::get('/register-shop', [CoffeeShopController::class, 'createCoffeeshop'])->name('register.shop'); // Hiển thị form đăng ký quán cà phê
Route::post('/register-shop', [CoffeeShopController::class, 'storeCoffeeshop']); // Lưu quán cà phê mới

Route::get('/coffeeshops', [CoffeeShopController::class, 'index'])->name('coffeeshops_management');
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions_management');
Route::resource('cafes', CafeManagementController::class);
Route::get('/cafes_management', [CafeManagementController::class, 'index'])->name('cafes_management');

Route::get('/coffeeshops/create', [CoffeeShopController::class, 'create'])->name('coffeeshop.create');
Route::post('/coffeeshops', [CoffeeShopController::class, 'store'])->name('coffeeshop.store');
Route::get('/coffeeshops/{coffeeshop}/edit', [CoffeeShopController::class, 'edit'])->name('coffeeshop.edit');
Route::put('/coffeeshops/{coffeeshop}', [CoffeeShopController::class, 'update'])->name('coffeeshop.update');
Route::delete('/coffeeshops/{coffeeshop}', [CoffeeShopController::class, 'destroy'])->name('coffeeshop.destroy');

// Quản lý khuyến mãi
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions_management');

// Điều hướng trang cá nhân đến trang chỉnh sửa
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return redirect()->route('profile.edit'); // Điều hướng về trang chỉnh sửa
    })->name('profile');

    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroyProfile'])->name('profile.destroy'); 
});

// Review like
// Route::post('/review/{id}/like', [ReviewController::class, 'likeReview']);
// Route::post('/review/{review}/like', [ReviewController::class, 'toggleLike'])->middleware('auth');
Route::post('/review/{id}/like', [ReviewController::class, 'toggleLike']);



// Shop
Route::get('/shop/{id}', [ShopController::class, 'show'])->name('frontend.shop');

// Middleware auth cho update và delete review
Route::middleware(['auth'])->group(function () {
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
// thong bao
Route::get('/thongbao', [NotificationController::class, 'index'])->name('thongbao');

// lưu quán
Route::post('/coffeeshop/favorite/{shopId}', [HomeController::class, 'saveFavorite'])->name('home.saveFavorite');

// bài viết
Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');

// trang thong tin
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware('auth')->group(function () {
    // Route này để người dùng cập nhật mật khẩu của mình
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});

// Route cho đăng nhập và đăng ký (dành cho người dùng chưa đăng nhập)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// Route cho những người đã đăng nhập
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
// Nếu bạn có file auth.php, có thể require ở đây
// require __DIR__.'/auth.php';
// Định nghĩa các route riêng lẻ
Route::get('/styles', [StyleController::class, 'index'])->name('styles.index'); // Hiển thị danh sách phong cách
Route::get('/styles/create', [StyleController::class, 'create'])->name('styles.create'); // Hiển thị form thêm phong cách
Route::post('/styles', [StyleController::class, 'store'])->name('styles.store'); // Lưu phong cách mới
Route::get('/style/{id}', [StyleController::class, 'show'])->name('style.show'); // Hiển thị chi tiết phong cách
Route::get('/styles/{id}/edit', [StyleController::class, 'edit'])->name('styles.edit'); // Hiển thị form chỉnh sửa phong cách
Route::put('/styles/{id}', [StyleController::class, 'update'])->name('styles.update'); // Cập nhật phong cách
Route::delete('/styles/{id}', [StyleController::class, 'destroy'])->name('styles.destroy'); // Xóa phong cách
