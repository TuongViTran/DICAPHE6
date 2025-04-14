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


// Fontend --------------------------------------------
Route::get('/test-session', function () {
    Session::put('test_key', 'Hello Session');
    return 'Session đã được ghi!';
});
<<<<<<< HEAD
=======
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
>>>>>>> 3d75ae53fdadd370c08c1ad73d8d9c740002a634

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
<<<<<<< HEAD
Route::get('/dashboard', function () {
    return view('backend.admin.dashboard'); // Chỉ định đường dẫn đầy đủ đến view
})->name('dashboard')->middleware('auth'); // Chỉ kiểm tra xem người dùng đã đăng nhập hay chưa
=======

use App\Http\Controllers\AdminController;

Route::get('/dashboard', [AdminController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware('auth');
// Route::get('/dashboard', function () {
//     return view('backend.admin.dashboard'); // Chỉ định đường dẫn đầy đủ đến view
// })->name('dashboard')->middleware('auth'); // Chỉ kiểm tra xem người dùng đã đăng nhập hay chưa
>>>>>>> 3d75ae53fdadd370c08c1ad73d8d9c740002a634

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

<<<<<<< HEAD
Route::get('/coffeeshops', [CoffeeShopController::class, 'index'])->name('coffeeshops_management');// Định nghĩa route cho trang quản lý quán cà phê
Route::resource('cafes', CafeManagementController::class);// Định nghĩa resource cho quản lý quán cà phê
=======
// quản lý feedback
Route::prefix('feed-management')->name('feed.')->group(function () {
    Route::get('/', [FeedController::class, 'index'])->name('index');
    Route::delete('/{id}', [FeedController::class, 'destroy'])->name('destroy');
});



// Định nghĩa route cho trang quản lý quán cà phê
Route::get('/coffeeshops', [CoffeeShopController::class, 'index'])->name('coffeeshops_management');
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions_management');
// Định nghĩa resource cho quản lý quán cà phê
Route::resource('cafes', CafeManagementController::class);
>>>>>>> 3d75ae53fdadd370c08c1ad73d8d9c740002a634
Route::get('/cafes_management', [CafeManagementController::class, 'index'])->name('cafes_management');
Route::get('/coffeeshops/create', [CoffeeShopController::class, 'create'])->name('coffeeshop.create');// Route cho form thêm mới quán cà phê
Route::post('/coffeeshops', [CoffeeShopController::class, 'store'])->name('coffeeshop.store');// Route cho lưu quán cà phê mới
Route::get('/coffeeshops/{coffeeshop}/edit', [CoffeeShopController::class, 'edit'])->name('coffeeshop.edit');// Route cho form chỉnh sửa quán cà phê
Route::put('/coffeeshops/{coffeeshop}', [CoffeeShopController::class, 'update'])->name('coffeeshop.update');// Route cho cập nhật quán cà phê
Route::delete('/coffeeshops/{coffeeshop}', [CoffeeShopController::class, 'destroy'])->name('coffeeshop.destroy');// Route cho xóa quán cà phê

// Route cho trang quản lý khuyến mãi
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions_management');

// Route cho profile (nếu cần)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

<<<<<<< HEAD
// require __DIR__.'/auth.php'; // Nếu bạn có file auth.php, hãy giữ lại dòng này
=======
Route::post('/review/{id}/like', [ReviewController::class, 'likeReview']);
use App\Http\Controllers\ShopController;

Route::get('/shop/{id}', [ShopController::class, 'show']);


Route::middleware(['auth'])->group(function () {
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});






// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
>>>>>>> 3d75ae53fdadd370c08c1ad73d8d9c740002a634
