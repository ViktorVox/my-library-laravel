<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    // Разрешаем заполнение полей
    protected $fillable = ['name', 'bio'];

    // Обратная связь: авторы -> книги
    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
