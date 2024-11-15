<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anuncio extends Model
{

    //No mucho que comentar aqui, llenamos tanto los modelos con las opcioens necesarias segun la tabla

    use HasUuids;

    protected $table = "citas";
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'titulo', 'descripcion', 'juego', 'localizacion', 'medio', 'fondo'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;

    public function tipoLavado(): BelongsTo
    {
        return $this->belongsTo(TipoAnuncio::class, 'tipo_lavado', 'id');
    }
}
