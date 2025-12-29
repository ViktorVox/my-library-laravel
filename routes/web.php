<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('home');
});


// Группа для гостей
Route::middleware('guest')->group(function() {
    // Страница регистрации (показать форму)
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');

    // Обработка регестрации (принять данные)
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    // Страница входа (показать форму)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Обработка входа
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});


// Группа только для авторизированных пользователей
Route::middleware('auth')->group(function() {
    // Выход из системы
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Книги
    Route::resource('books', BookController::class);
});
