<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infoone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'valor_gasolina',
        'dias_trab',
        'qtd_corridas',
        'km_litro'

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
