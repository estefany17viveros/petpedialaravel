<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'category',
        'image',
        'profile_id' 
        ];

    // Relación con perfil veterinario
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
