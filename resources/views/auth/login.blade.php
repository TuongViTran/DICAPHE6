
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .bounce {
            animation: bounce 1s infinite;
        }
        .bounce:nth-child(1) {
            animation-delay: 0s;
        }
        .bounce:nth-child(2) {
            animation-delay: 0.2s;
        }
        .bounce:nth-child(3) {
            animation-delay: 0.4s;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-white">
    <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Side -->
        <div class="flex flex-col items-center justify-center p-8 bg-[#fefcbf] md:w-1/2">
            <h1 class="text-2xl font-bold mb-4 text-center">
                Xin chào ! Chúng tôi hỗ trợ tìm kiếm quán cà phê
            </h1>
            <img src="{{ asset('frontend/images/img_dn.png') }}"  class="w-64 h-64" height="300" src="" width="300">
        </div>
        <!-- Right Side -->
        <div class="flex flex-col items-center justify-center p-8 md:w-1/2">
            <div class="flex items-center mb-6">
                <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2 bounce"></div>
                <div class="w-4 h-4 bg-blue-500 rounded-full mr-2 bounce"></div>
                <div class="w-4 h-4 bg-red-500 rounded-full mr-2 bounce"></div>
                <h2 class="text-2xl font-bold">Cà Phê Đi Đâu ?</h2>
            </div>
            <h3 class="text-xl font-semibold mb-6">Đăng nhập</h3>
            <form id="loginForm" class="w-full max-w-sm" method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </span>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 pl-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" placeholder="email@gmail.com" type="email" required value="{{ old('email') }}"/>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Password Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mật khẩu</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-lock text-gray-400"></i>
                        </span>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 pl-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" placeholder="Nhập mật khẩu" type="password" required/>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center"></div>

                <div class="mb-6">
                    <button class="bg-[#f9c6a0] hover:bg-[#f9b58a] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit">Đăng nhập</button>
                </div>
                <div class="flex items-center justify-center mb-4 space-x-16">
                    <a href="{{ url('auth/google') }}" class="btn btn-danger">
                        <i class="fab fa-google"></i>
                    </a>

                    <a href="{{ url('auth/facebook') }}" class="btn btn-primary">
                        <i class="fab fa-facebook"></i>
                    </a>

                    <a href="{{ url('auth/apple') }}" class="btn btn-dark">
                        <i class="fab fa-apple"></i>
                    </a>
                </div>
                <div class="text-center">
                    <span class="text-gray-500">Chưa có tài khoản?</span>
                    <a class="font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('register') }}">Đăng ký ngay</a>
                </div>
            </form>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault(); // Ngăn form reload

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    // Nếu đăng nhập thành công
                    window.location.href = response.redirect;
                },
                error: function (xhr) {
                    // Nếu có lỗi
                    let res = xhr.responseJSON;
                    let message = '';

                    if (res.errors) {
                        if (res.errors.email) {
                            message = res.errors.email[0];
                        } else if (res.errors.password) {
                            message = res.errors.password[0];
                        } else {
                            message = 'Đã xảy ra lỗi. Vui lòng thử lại!';
                        }
                    } else {
                        message = res.message || 'Đăng nhập thất bại.';
                    }

                    $('#error-message').removeClass('hidden').text(message);

                    // Ẩn lỗi sau 5s
                    setTimeout(() => {
                        $('#error-message').addClass('hidden').text('');
                    }, 5000);
                }
            });
        });
    });
</script>

</html>
