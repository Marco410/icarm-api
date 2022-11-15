<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroTomaLeche extends Model
{
    use HasFactory;

    protected $table= "registro_toma_leche";
    //niño = 1, niña = 2
    protected $fillable = [
       'user_id', 'bb_id','fecha_registro','pecho','hora','tiempo','notas'
    ];

    public function bebe(){
        return $this->hasOne(User::class,'id','bb_id');
    }
}
