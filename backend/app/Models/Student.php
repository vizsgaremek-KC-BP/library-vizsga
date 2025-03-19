<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'edu_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'edu_id', 'edu_id');
    }

}
