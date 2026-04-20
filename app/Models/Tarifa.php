<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modelo de Tarifa
 *
 * @property int $id_tarifa
 * @property string $nombre_tarifa
 * @property float $precio
 * @property string|null $unidad_precio
 * @property string|null $permanencia
 * @property string|null $condiciones
 * @property string|null $url_oferta_externa
 * @property int $id_servicio
 * @property \Carbon\Carbon $fecha_actualizacion
 */
class Tarifa extends Model
{
    protected $table = 'tarifas';
    protected $primaryKey = 'id_tarifa';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Relación con Servicios
     */
    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    /**
     * Relación con Disponibilidad
     */
    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'id_tarifa', 'id_tarifa');
    }

    /**
     * Relación con Ubicaciones (a través de disponibilidad)
     */
    public function ubicaciones(): BelongsToMany
    {
        return $this->belongsToMany(
            Ubicacion::class,
            'disponibilidad',
            'id_tarifa',
            'id_ubicacion',
            'id_tarifa',
            'id_ubicacion'
        );
    }

    /**
     * Relación con Comparaciones (a través de tabla pivote)
     */
    public function comparaciones()
    {
        return $this->belongsToMany(
            Comparacion::class,
            'comparacion_tarifas',
            'id_tarifa',
            'id_comparacion'
        )->withPivot('posicion_resultado');
    }
}
