<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Citas extends Model
{

    //No mucho que comentar aqui, llenamos tanto los modelos con las opcioens necesarias segun la tabla

    use HasUuids;

    protected $table = "citas";
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'entrada', 'salida', 'nombre', 'telefono', 'coche', 'matricula', 'tipo_lavado', 'llantas', 'precio'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;

    public function tipoLavado(): BelongsTo
    {
        return $this->belongsTo(TipoLavado::class, 'tipo_lavado', 'id');
    }
}
