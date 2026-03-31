<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - Melekler Fashion</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 450px;
            width: 100%;
            padding: 50px 40px;
            animation: popIn 0.6s cubic-bezier(.4,0,.2,1);
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(30px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-header h1 {
            font-size: 30px;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
            margin-top: 6px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Cairo', sans-serif;
            transition: 0.25s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102,126,234,.15);
        }

        .error {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
        }

        /* زر تسجيل الدخول */
        .login-btn {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 55px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
        }

        .btn-text {
            transition: 0.4s;
        }

        .btn-scene {
            position: absolute;
            opacity: 0;
            transition: 0.4s;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            width: 40px;
            height: 35px;
        }

        .btn-door {
            width: 18px;
            height: 26px;
            background: #fff;
            border-radius: 3px 3px 0 0;
            transform-origin: right;
            transition: 0.5s;
        }

        .btn-person {
            position: absolute;
            bottom: 0;
            right: 50px;
            width: 8px;
            height: 20px;
            opacity: 0;
            transition: 0.6s cubic-bezier(0.4,0,0.2,1);
        }

        .btn-person::before {
            content: '';
            position: absolute;
            top: 0;
            width: 6px;
            height: 6px;
            background: #667eea;
            border-radius: 50%;
            left: 1px;
        }

        .btn-person::after {
            content: '';
            position: absolute;
            top: 6px;
            width: 4px;
            height: 12px;
            background: #764ba2;
            border-radius: 2px;
            left: 2px;
        }

        .login-btn.active .btn-text {
            transform: translateY(-40px);
            opacity: 0;
        }

        .login-btn.active .btn-scene {
            opacity: 1;
        }

        .login-btn.active .btn-door {
            transform: rotateY(-100deg);
            background: #eee;
        }

        .login-btn.active .btn-person {
            right: 24px;
            opacity: 1;
            transform: scale(0.85);
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <h1>🎀 Melekler Fashion</h1>
        <p>تسجيل الدخول</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>كلمة المرور</label>
            <input type="password" name="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="login-btn" id="authBtn">
            <span class="btn-text">تسجيل الدخول</span>
            <div class="btn-scene">
                <div class="btn-person"></div>
                <div class="btn-door"></div>
            </div>
        </button>
    </form>

    <div class="links">
        ما عندك حساب؟
        <a href="{{ route('register') }}">إنشاء حساب</a>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function () {
    document.getElementById('authBtn').classList.add('active');
});
</script>

</body>
</html>
