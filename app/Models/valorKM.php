<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class valorKM extends Model
{
    use HasFactory;
    protected $table = 'valor_km';

    protected $fillable = [
        'user_id',
        'ruim',
        'bom',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
