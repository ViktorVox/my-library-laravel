<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>вход</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Вход в библиотеку</h2>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Пароль</label>
                <input type="password" name="password"
                    class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:border-blue-500">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            @error('auth_error')
                <div class="mb-4 p-2 bg-red-100 text-red-700 rounded text-sm text-center">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="w-full bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700 transition duration-300">
                Войти
            </button>
        </form>
        
        <p class="mt-4 text-center text-sm text-gray-600">
            Нет аккаунта? <a href="{{ route('register.form') }}" class="text-blue-500 hover:underline">Регистрация</a>
        </p>
    </div>
    
</body>
</html>