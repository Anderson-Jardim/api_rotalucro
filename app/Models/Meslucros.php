<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meslucros extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'qtd_mes_lucros',
        

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
