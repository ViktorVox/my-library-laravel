<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Главная страница</h1>

        @auth
            <p class="text-xl text-green-600 mb-4">Привет, {{ Auth::user()->name }}!</p>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
                    Выйти
                </button>
            </form>
        @endauth

        @guest
            <p class="text-xl text-gray-600 mb-4">Ты не авторизован.</p>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Войти</a>
                <a href="{{ route('register.form') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Регистрация</a>
            </div>
        @endguest
    </div>
</body>
</html>