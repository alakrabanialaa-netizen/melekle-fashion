<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة المستخدم</title>
</head>
<body>
    <h1>أهلاً بك 👋</h1>
    <p>هذه صفحة المستخدم العادي بعد تسجيل الدخول</p>

    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">
        تسجيل الخروج
    </button>
</form>

</body>
</html>
