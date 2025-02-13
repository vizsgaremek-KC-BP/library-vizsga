<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id', 'class', 'quantity_assigned',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}