<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <div class="mb-4 text-lg text-gray-700 dark:text-gray-300 font-medium">
            Quên mật khẩu? Không sao. Hãy nhập địa chỉ email của bạn, chúng tôi sẽ gửi một liên kết để đặt lại mật khẩu.
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-medium text-base text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="block text-base font-semibold text-gray-800 dark:text-gray-200">Email</label>
                <input id="email" class="block mt-2 w-full text-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300" type="email" name="email" value="{{ old('email') }}" required autofocus>
                
                @error('email')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="underline text-base text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    Quay lại đăng nhập
                </a>

                <button type="submit" class="ml-3 px-5 py-2 bg-indigo-600 text-white text-base font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    Gửi liên kết đặt lại
                </button>
            </div>
        </form>
    </div>
</body>
</html>

