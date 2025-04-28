<style>
    .password-container {
    background: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: auto;
    font-family: Arial, sans-serif;
}

.section-title {
    font-size: 24px;
    color: #2c3e50;
    font-weight: bold;
    margin-bottom: 10px;
}

.section-description {
    font-size: 14px;
    color: #7f8c8d;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: 600;
    font-size: 14px;
    color: #34495e;
    display: block;
    margin-bottom: 8px;
}

input[type="password"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    background-color: #f9f9f9;
    box-sizing: border-box;
}

input[type="password"]:focus {
    border-color: #3498db;
    outline: none;
}

button[type="submit"] {
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

button[type="submit"]:hover {
    background-color: #27ae60;
}

.error-message {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 5px;
}

.success-message {
    color: #2ecc71;
    font-size: 14px;
    margin-top: 10px;
    text-align: center;
}

@media (max-width: 768px) {
    .password-container {
        padding: 20px;
    }
}

</style>

<section class="password-container">
    <header>
        <h2 class="section-title">{{ __('Cập nhật mật khẩu') }}</h2>
        <p class="section-description">
            {{ __('Hãy đảm bảo tài khoản của bạn đang sử dụng một mật khẩu dài và ngẫu nhiên để tăng cường bảo mật.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT') <!-- Phương thức PUT để cập nhật -->

        <div class="form-group">
            <label for="current_password">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" id="current_password" required>
            <p class="error-message">{{ $errors->first('current_password') }}</p>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input type="password" name="password" id="password" required>
            <p class="error-message">{{ $errors->first('password') }}</p>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Xác nhận mật khẩu mới</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            <p class="error-message">{{ $errors->first('password_confirmation') }}</p>
        </div>

        <button type="submit">Lưu</button>

        @if (session('status') === 'password-updated')
            <p class="success-message">
                {{ __('Đã lưu.') }}
            </p>
        @endif
    </form>
</section>
