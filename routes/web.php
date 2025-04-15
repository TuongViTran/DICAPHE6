<?php

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

// Frontend --------------------------------------------
Route::get('/test-session', function () {
    Session::put('test_key', 'Hello Session');
    return 'Session đã được ghi!';
});

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // Nếu có, comment hoặc xóa

Route::get('/', [HomeController::class, 'index'])->name('trangchu');
Route::get('/feed', [FeedController::class, 'feed'])->name('feed');
Route::get('/tintuc', [HomeController::class, 'tintuc'])->name('tintuc');
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

// Profile (bảo vệ bằng middleware auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Review like
Route::post('/review/{id}/like', [ReviewController::class, 'likeReview']);

// Shop
Route::get('/shop/{id}', [ShopController::class, 'show']);

// Middleware auth cho update và delete review
Route::middleware(['auth'])->group(function () {
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Nếu bạn có file auth.php, có thể require ở đây
// require __DIR__.'/auth.php';