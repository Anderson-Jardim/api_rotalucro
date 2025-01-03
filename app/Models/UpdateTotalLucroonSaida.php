<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpdateTotalLucroonSaida extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'nome_saida',
        'saida_lucro',
        'tipo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
