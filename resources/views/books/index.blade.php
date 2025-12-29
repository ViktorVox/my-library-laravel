<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои книги</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">📚 Моя Библиотека</h1>
            
            <div class="flex gap-4">
                <a href="{{ route('books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    + Добавить книгу
                </a>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-500 hover:text-red-700 font-semibold px-4 py-2">Выйти</button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($books as $book)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                    
                    @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-56 object-cover">
                    @else
                        <div class="w-full h-56 bg-gray-200 flex items-center justify-center text-gray-400 text-4xl">
                            📚
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-1" title="{{ $book->title }}">
                            <a href="{{ route('books.show', $book->id) }}" class="hover:text-blue-600 transition">
                                {{ $book->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4">{{ $book->author ?? 'Автор неизвестен' }}</p>
                        
                        <div class="flex justify-between items-center text-sm">
                           <span class="px-2 py-1 rounded 
                            {{ $book->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $book->status == 'reading' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $book->status == 'planned' ? 'bg-gray-100 text-gray-800' : '' }}
                           ">
                                {{ $book->status_label }}
                           </span>
                           <span class="text-yellow-500 font-bold">
                                {{ $book->rating ? $book->rating . '/5 ⭐' : 'Нет оценки' }}
                           </span>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t">
                        <a href="{{ route('books.edit', $book->id) }}" class="text-blue-600 hover:text-blue-900 font-medium text-sm">
                            ✏️ Редактировать
                        </a>

                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">
                                🗑️ Удалить
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                @endforelse
            
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