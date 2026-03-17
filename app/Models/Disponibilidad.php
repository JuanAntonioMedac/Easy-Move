<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo de Disponibilidad
 * 
 * @property int $id_disponibilidad
 * @property int $id_tarifa
 * @property int $id_ubicacion
 */
class Disponibilidad extends Model
{
    protected $table = 'disponibilidad';
    protected $primaryKey = 'id_disponibilidad';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Relación con Tarifa
     */
    public function tarifa(): BelongsTo
    {
        return $this->belongsTo(Tarifa::class, 'id_tarifa', 'id_tarifa');
    }

    /**
     * Relación con Ubicación
     */
    public function ubicacion(): BelongsTo
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion', 'id_ubicacion');
    }
}
