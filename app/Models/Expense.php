<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gastos',
        'amount',
    ];

    protected $casts = [
        'gastos' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}