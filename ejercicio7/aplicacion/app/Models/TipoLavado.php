<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class TipoLavado extends Model
{
    use HasUuids;

    protected $table = "tipo_lavado";
    protected $primaryKey = 'id';

    protected $fillable = [
        'descripcion', 'precio', 'tiempo'
    ];
    
    public $incrementing = false; 
    protected $keyType = 'string';
    
    public $timestamps = false; 
   
     public function citas(): HasMany
    {
        return $this->hasMany(Citas::class, 'tipo_lavado', 'id');
    }
}
