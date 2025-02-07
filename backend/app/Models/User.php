<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // Importálni kell a JWTSubject interfészt

class User extends Authenticatable implements JWTSubject  // Itt implementálni kell a JWTSubject interfészt
{
    use HasFactory, Notifiable;

    // A modell kitöltése
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // szerepkör, amely lehet admin, librarian vagy teacher
    ];

    // A jelszó hashelése
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // A role változó a jogosultság kezelésére
    const ROLE_ADMIN = 'admin';
    const ROLE_LIBRARIAN = 'librarian';
    const ROLE_TEACHER = 'teacher';

    // Meghatározzuk, hogy mely mezők lehetnek tömegesen kitöltve
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Ez a felhasználó egyedi azonosítója (pl. ID)
    }

    /**
     * Get the custom claims for the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // További egyedi adatokat adhatsz hozzá, ha szükséges
    }
}
