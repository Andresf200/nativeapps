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

    public function diagnostics(){
        return $this->belongsToMany(Diagnostic::class)
            ->withPivot('observation', 'creation')
            ->withTimestamps();
    }

    public function scopeName($query, $name){
        if($name){
            return $query->where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%");
        }
    }

    public function scopeDocument($query, $document){
        if($document){
            return $query->where('document', 'like', "%$document%");
        }
    }
}
