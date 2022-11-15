<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bebe extends Model
{
    use HasFactory;

    protected $table= "bebes";
    //niño = 1, niña = 2
    protected $fillable = [
        'user_id','nombre','fecha_nacimiento','sexo','peso','talla','perimetro'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
