<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'available',
    ];
    
    // Opsional: Untuk casting 'available' menjadi boolean secara otomatis
    protected $casts = [
        'available' => 'boolean',
    ];
}
