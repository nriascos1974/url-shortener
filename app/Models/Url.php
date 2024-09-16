<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    // Agrega las columnas que deseas que sean accesibles
    protected $fillable = ['original_url', 'short_url'];
}
