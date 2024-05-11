<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'publisher', 'author', 'genre', 'publication_date', 'word_count', 'price'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'word_count' => 'integer',
        'price' => 'decimal:2',
    ];
}
