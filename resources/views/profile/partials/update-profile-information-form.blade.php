<style>
    /* Thiết lập chung cho container */
/* Thiết lập chung cho container */
.thong-tin-ca-nhan {
    background: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: auto;
    font-family: Arial, sans-serif;
}

/* Tiêu đề section */
.tieu-de {
    font-size: 24px;
    color: #2c3e50;
    font-weight: bold;
    margin-bottom: 10px;
}

/* Mô tả section */
.mo-ta {
    font-size: 14px;
    color: #7f8c8d;
    margin-bottom: 20px;
}

/* Các nhóm form */
.form-group {
    margin-bottom: 20px;
}

/* Nhãn của các input */
label {
    font-weight: 600;
    font-size: 14px;
    color: #34495e;
    display: block;
    margin-bottom: 8px;
}

/* Style cho input */
.input-truong {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #f9f9f9;
    box-sizing: border-box;
}

.input-truong:focus {
    border-color: #3498db;
    outline: none;
}

/* Thông báo lỗi */
.thong-bao-loi {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
}

/* Các nút bấm */
button[type="submit"], .x-primary-button {
    background-color: #2ecc71;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover, .x-primary-button:hover {
    background-color: #27ae60;
}

/* Thông báo thành công */
.text-sm {
    font-size: 14px;
}

.text-green-600 {
    color: #2ecc71;
}

.text-gray-600 {
    color: #34495e;
}

.text-gray-400 {
    color: #b0bec5;
}

/* Thông báo đã lưu */
.font-medium {
    font-weight: 500;
}

.mt-2 {
    margin-top: 8px;
}

/* Responsive cho màn hình nhỏ */
@media (max-width: 768px) {
    .thong-tin-ca-nhan {
        padding: 20px;
    }

    .tieu-de {
        font-size: 20px;
    }

    .mo-ta {
        font-size: 12px;
    }

    .input-truong {
        font-size: 12px;
    }
}
/* Định dạng cho trường email */
.email-container {
    margin-bottom: 20px;
}

/* Label cho trường email */
.email-label {
    font-weight: 600;
    font-size: 14px;
    color: #34495e;
    margin-bottom: 8px;
    display: block;
}

/* Định dạng input email */
.input-email {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #f9f9f9;
    box-sizing: border-box;
}

.input-email:focus {
    border-color: #3498db;
    outline: none;
}

/* Thông báo lỗi email */
.error-message {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
}

/* Thông báo xác minh email */
.verification-container {
    margin-top: 10px;
    font-size: 14px;
}

.verification-text {
    color: #7f8c8d;
}

.verification-button {
    color: #3498db;
    text-decoration: underline;
    cursor: pointer;
    transition: color 0.3s;
}

.verification-button:hover {
    color: #2980b9;
}

/* Thông báo đã gửi liên kết xác minh */
.verification-sent-message {
    margin-top: 10px;
    font-size: 14px;
    color: #2ecc71;
    font-weight: 500;
}

/* Responsive cho màn hình nhỏ */
@media (max-width: 768px) {
    .email-container {
        padding: 10px;
    }
}

</style>

<section class="thong-tin-ca-nhan">
    <header>
        <h2 class="tieu-de text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Thông tin cá nhân') }}
        </h2>

        <p class="mo-ta mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Cập nhật thông tin tài khoản và địa chỉ email của bạn.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="form-cap-nhat mt-6 space-y-6">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="full_name">{{ __('Tên tài khoản') }}</label>
            <input id="full_name" name="full_name" type="text" class="input-truong" value="{{ old('full_name', $user->full_name) }}" required>
            <p class="thong-bao-loi">{{ $errors->first('full_name') }}</p>
        </div>

        <div class="email-container">
            <x-input-label for="email" :value="__('Email')" class="email-label" />
            <x-text-input id="email" name="email" type="email" class="input-email mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="error-message mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="verification-container">
                    <p class="verification-text text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Địa chỉ email của bạn chưa được xác minh.') }}

                        <button form="send-verification" class="verification-button text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Nhấn vào đây để gửi lại email xác minh.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="verification-sent-message mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Một liên kết xác minh mới đã được gửi đến email của bạn.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>



        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Lưu') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Đã lưu.') }}</p>
            @endif
        </div>
    </form>
</section>
