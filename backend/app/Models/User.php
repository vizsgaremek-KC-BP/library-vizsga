<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function isDeputy()
    {
        return $this->role === 'deputy';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isAdministrator()
    {
        return $this->role === 'administrator';
    }
}
