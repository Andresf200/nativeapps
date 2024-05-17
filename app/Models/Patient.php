<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'document',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'genre'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
