<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPanales extends Model
{
    use HasFactory;

    protected $table= "registro_panales";
    //niño = 1, niña = 2
    protected $fillable = [
       'user_id', 'bb_id','fecha_registro','textura','cantidad','foto','notas'
    ];

    public function bebe(){
        return $this->hasOne(User::class,'id','bb_id');
    }
}
