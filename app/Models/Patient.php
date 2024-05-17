<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    const FEMALE = 'female';
    const MALE = 'male';

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
        'updated_at',
        'deleted_at',
    ];
}
