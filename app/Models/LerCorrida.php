<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LerCorrida extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'value',
        

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
