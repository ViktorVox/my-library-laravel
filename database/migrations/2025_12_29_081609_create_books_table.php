<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();                         // ID книги
            $table->foreignId('user_id');         // foreignId('user_id') создает колонку для ID пользователя
            $table->string('title');              // Название книги
            $table->string('author')->nullable(); // Автор
            $table->string('image')->nullable();  // Путь к файлу обложки
            $table->enum('status', ['planned', 'reading', 'completed'])->default('planned');  // Статус книги
            $table->tinyInteger('rating')->unsigned()->nullable();                            // Рейтинг (целое число от 1 до 5, может быть пустым)
            $table->text('notes')->nullable();                                                // Описание/заметки
            $table->timestamps();                                                             // Дата создания и обновления
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books'); // Удаляет таблицу books
    }
};
