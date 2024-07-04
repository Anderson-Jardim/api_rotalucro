<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classcorridas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'corrida_bronze',
        'corrida_ouro',
        'corrida_diamante',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
