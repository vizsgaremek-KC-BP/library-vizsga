<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author', 'quantity', 'is_return_required',
    ];

    public function assignments()
    {
        return $this->hasMany(BookAssignment::class);
    }

    public function returns()
    {
        return $this->hasMany(BookReturn::class);
    }
}
