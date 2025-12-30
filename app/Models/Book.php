<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\Models\User;

class Book extends Model
{
    use HasFactory;

    // $fillable: Список полей, которые разрешено заполнять массово
    protected $fillable = [
        'user_id',
        'title',
        'image',
        'status',
        'rating',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
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
