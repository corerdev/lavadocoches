<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuarios extends Authenticatable
{
    use HasUuids;

    protected $table = "usuarios";
    protected $primaryKey = 'id';
    
    public $incrementing = false; 
    protected $keyType = 'string';

    //Aquí tenemos que añadir el fillable para poder crear los usuarios con google

    protected $fillable = ['username', 'password','google_id'];

    public $timestamps = false; 

    protected $hidden = ['password'];    

}
