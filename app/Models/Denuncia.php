<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;

    protected $table= "denuncias";
    protected $fillable = [
        'nombre','ciudad','estado','pais','email','msj'
    ];

}
