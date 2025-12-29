<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Взять книги только текущего пользователя
        $books = Auth::user()->books;

        // Отдаем вид 'books.index' и передаем туда переменную $books
        return view('books.index', compact('books')); // compact() - то же самое что и ['books' => $books]
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'status' => 'required|in:planned,reading,completed',
            'rating' => 'required|integer|min:1|max:5',
            'notes' => 'required|nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Проверка, что это картинка не больше 2Мб
        ]);

        // Обработка загрузки картинки
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Сохраняем файл в папку public/books на диске
            $imagePath = $request->file('image')->store('books', 'public');
        }

        // Создание книги через связь с пользователем
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->books()->create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'status' => $validated['status'],
            'rating' => $validated['rating'],
            'notes' => $validated['notes'],
            'image' => $imagePath, // Записываем путь к файлу (или null)
        ]);

        // Редирект обратно к списку
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // Проверка доступа (чужие книги смотреть нельзя)
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        // Возвращаем вид просмотра
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        // Проверка, является ли текущий пользоваетль владельцем
        if ($book->user_id !== Auth::id()) {
            abort(403, 'Это не ваша книга!');
        }

        return view('books.edit', compact('book'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // Проверка владельца
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        // Валидация
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'nullable|max:255',
            'status' => 'required|in:planned,reading,completed',
            'rating' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable',
            'image' => 'nullable|image|max:2048',
        ]);

        // Обработка картинки
        if ($request->hasFile('image')) {
            // Если была старая картинка - удаляем её
            if($book->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->image);
            }

            // Загружаем новую
            $path = $request->file('image')->store('books', 'public');
            $validated['image'] = $path; // Обновляем путь в массив данных
        }

        // Обновляем записи в БД
        $book->update($validated);

        // Редирект на страницу с книгами
        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Проверка владельца
        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        // Удаляем файл обложки с диска
        if ($book->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($book->image);
        }

        // Удаляем запись из БД
        $book->delete();

        // Возвращаемся к списку
        return redirect()->route('books.index');
    }
}
