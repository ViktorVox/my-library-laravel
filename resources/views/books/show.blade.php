<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ $book->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100 min-h-screen p-10">

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:flex-shrink-0 md:w-1/3 bg-gray-200 flex items-center justify-center">
                @if($book->image)
                    <img class="h-full w-full object-cover" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                @else
                    <span class="text-6xl">📚</span>
                @endif
            </div>
            
            <div class="p-8 w-full">
                <a href="{{ route('books.index') }}" class="text-sm text-gray-500 hover:text-blue-500 mb-4 inline-block">
                    &larr; Вернуться к списку
                </a>

                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $book->title }}</h1>
                        <p class="text-xl text-gray-600 mt-1">{{ $book->author }}</p>
                    </div>
                    <div class="text-yellow-400 text-2xl font-bold">
                        {{ $book->rating ? $book->rating . ' ⭐' : '' }}
                    </div>
                </div>

                <div class="mt-4">
                    <span class="px-3 py-1 rounded text-sm font-semibold
                        {{ $book->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $book->status == 'reading' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $book->status == 'planned' ? 'bg-gray-100 text-gray-800' : '' }}
                    ">
                        {{ $book->status_label }}
                    </span>
                </div>

                <div class="mt-6 border-t pt-6">
                    <h3 class="text-gray-400 uppercase text-xs font-bold tracking-wider mb-2">Мои заметки</h3>
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">
                        {{ $book->notes ?: 'Заметок к этой книге пока нет.' }}
                    </p>
                </div>

                <div class="mt-8 flex gap-4">
                    <a href="{{ route('books.edit', $book->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                        Редактировать
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Находим все формы удаления
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Стоп! Не отправляем форму сразу.

                Swal.fire({
                    title: 'Вы уверены?',
                    text: "Эту книгу уже не вернуть!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Да, удалить!',
                    cancelButtonText: 'Отмена'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Если пользователь нажал "Да", отправляем форму
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>