<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo de Comparación Tarifa (tabla pivote)
 *
 * @property int $id_comparacion
 * @property int $id_tarifa
 * @property int $posicion_resultado
 */
class ComparacionTarifa extends Model
{
    protected $table = 'comparacion_tarifas';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Relación con Comparación
     */
    public function comparacion(): BelongsTo
    {
        return $this->belongsTo(Comparacion::class, 'id_comparacion', 'id_comparacion');
    }

    /**
     * Relación con Tarifa
     */
    public function tarifa(): BelongsTo
    {
        return $this->belongsTo(Tarifa::class, 'id_tarifa', 'id_tarifa');
    }
}
