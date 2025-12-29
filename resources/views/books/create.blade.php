<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Добавить новую книгу</h2>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data"> <!-- [enctype="multipart/form-data] - Чтобы картинки загрузились -->
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Название книги *</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border p-2 rounded @error('title') border-red-500 @enderror">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Автор</label>
                <input type="text" name="author" value="{{ old('author') }}"
                    class="w-full border p-2 rounded">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Статус</label>
                    <select name="status" class="w-full border p-2 rounded">
                        <option value="planned">В планах</option>
                        <option value="reading">Читаю</option>
                        <option value="completed">Прочитано</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Рейтинг (1-5)</label>
                    <input type="number" name="rating" min="1" max="5" value="{{ old('rating') }}"
                        class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Обложка книги</label>
                <input type="file" name="image" class="w-full p-2 border rounded bg-gray-50">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Заметки / Описание</label>
                <textarea name="notes" rows="4" class="w-full border p-2 rounded">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('books.index') }}" class="text-gray-500 hover:text-gray-700 py-2 px-4">Отмена</a>
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-800">
                    Сохранить книгу
                </button>
            </div>
        </form>
    </div>

</body>
</html>