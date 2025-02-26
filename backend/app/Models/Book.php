<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'inventory_number'];

    public function bookType()
    {
        return $this->belongsTo(BookType::class, 'book_id');
    }
}
