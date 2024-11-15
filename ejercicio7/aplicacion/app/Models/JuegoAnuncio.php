<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class JuegoAnuncio extends Model
{
    use HasUuids;

    protected $table = "juego_anuncio";
    protected $primaryKey = 'id';

 /*   protected $fillable = [
        'descripcion', 'precio', 'tiempo'
    ];
 */   
    public $incrementing = false; 
    protected $keyType = 'string';
    
    public $timestamps = false; 
   
     public function anuncio(): HasMany
    {
        return $this->hasMany(Anuncio::class, 'juego_anuncio', 'id');
    }
}
