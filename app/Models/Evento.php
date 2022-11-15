<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table= "eventos";
    //niño = 1, niña = 2
    protected $fillable = [
        'user_id','nombre','ubicacion','fecha','tipo_evento','sobre_de','des_corta','type','link_form','foto'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id')->with('roles');
    }
}
