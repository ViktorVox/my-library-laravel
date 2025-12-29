<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Показать форму регистрации
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Обработать данные и создать пользователя
    public function register(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users', // unique:users означает "проверь в таблице users, нет ли такого email"
            'password' => 'required|min:6|confirmed', // confirmed ищет поле password_confirmation
        ]);

        // Создание пользователя в БД
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Шифруем пароль
        ]);

        // Автоматический вход
        Auth::login($user);

        // Возвращаем пользователя на главную
        return redirect('/')->with('success', 'Вы успешно зарегестрировались');
    }

    // Показать форму входа
    public function showLoginForm() {
        return view('auth.login');
    }

    // Процесс входа
    public function login(Request $request) {
        // Валидация
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Попытка входа
        if (Auth::attempt($credentials)) {
            // Регенерация сессии
            $request->session()->regenerate();
            // Редирект туда, куда хотел попасть пользователь (или на главную)
            return redirect()->intended('/');
        }

        // Если не вышло - возвращаем назад с ошибкой
        return back()->withErrors([
            'auth_error' => 'Неверный email или пароль',
        ])->onlyInput('email');
    }

    // Выход из системы
    public function logout(Request $request)
    {
        Auth::logout(); // Удаляем аутенфикацию

        $request->session()->invalidate();      // Анулируем сессию
        $request->session()->regenerateToken(); // Обновляем csrf токен
    
        return redirect('/'); // Возвращаем на главную
    }
}
