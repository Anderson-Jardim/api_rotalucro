<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'contact',
        'image',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            // Verificar se o contato é um email válido ou um número de celular
            if (!filter_var($user->contact, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10,15}$/', $user->contact)) {
                throw new \Exception('Contact must be a valid email or phone number.');
            }

            // Verificar unicidade
            $existingUser = User::where('contact', $user->contact)->first();
            if ($existingUser && $existingUser->id !== $user->id) {
                throw new \Exception('Contact must be unique.');
            }
        });
    }
}
