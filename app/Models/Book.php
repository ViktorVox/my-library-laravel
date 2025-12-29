<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // $fillable: Список полей, которые разрешено заполнять массово
    protected $fillable = [
        'user_id',
        'title',
        'author',
        'image',
        'status',
        'rating',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'planned' => 'В планах',
            'reading' => 'Читаю',
            'completed' => 'Прочитано',
            default => 'Неизвестно',
        };
    }
}
