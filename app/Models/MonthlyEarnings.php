<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyEarnings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'total_lucro',
        'total_gasto',
        'valor_corrida',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
