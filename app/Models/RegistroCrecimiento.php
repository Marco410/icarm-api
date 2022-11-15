<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCrecimiento extends Model
{
    use HasFactory;

    protected $table= "registro_crecimiento";
    //niño = 1, niña = 2
    protected $fillable = [
       'user_id', 'bb_id','fecha_registro','peso','talla','notas'
    ];

    public function bebe(){
        return $this->hasOne(User::class,'id','bb_id');
    }
}
