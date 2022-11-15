<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoAsistencia extends Model
{
    use HasFactory;

    protected $table= "eventos_asistencia";
    //niño = 1, niña = 2
    protected $fillable = [
        'user_id','evento_id'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id')->with('roles');
    }

    public function evento(){
        return $this->hasOne(Evento::class,'id','evento_id');
    }
}
