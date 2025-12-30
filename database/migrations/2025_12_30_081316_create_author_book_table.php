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
        Schema::create('author_book', function (Blueprint $table) {
            $table->foreignId('author_id')->constrained()->cascadeOnDelete(); // foreignId('author_id') создает UNSIGNED BIGINT колонку для ID автора, constrained() создает внешний ключ, cascadeOnDelete() удаляет автора при удалении книги
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();   // foreignId('book_id') создает UNSIGNED BIGINT колонку для ID книги, cascadeOnDelete() удаляет книгу при удалении автора
            $table->primary(['author_id', 'book_id']);                        // primary(['author_id', 'book_id']) создает primary([...]) делает пару этих колонок "Главным ключом"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_book');
    }
};
