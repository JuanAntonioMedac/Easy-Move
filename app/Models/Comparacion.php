<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Modelo de Comparación
 * 
 * @property int $id_comparacion
 * @property \Carbon\Carbon $fecha
 * @property int|null $id_usuario
 * @property int $id_ubicacion
 * @property int $id_tipo_servicio
 */
class Comparacion extends Model
{
    protected $table = 'comparaciones';
    protected $primaryKey = 'id_comparacion';
    protected $guarded = [];
    public $timestamps = true;

    protected $casts = [
        'fecha' => 'datetime',
    ];

    /**
     * Relación con Usuario (nullable)
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    /**
     * Relación con Ubicación
     */
    public function ubicacion(): BelongsTo
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion', 'id_ubicacion');
    }

    /**
     * Relación con Tipo de Servicio
     */
    public function tipoServicio(): BelongsTo
    {
        return $this->belongsTo(TipoServicio::class, 'id_tipo_servicio', 'id_tipo_servicio');
    }

    /**
     * Relación con Tarifas (a través de tabla pivote)
     */
    public function tarifas(): BelongsToMany
    {
        return $this->belongsToMany(
            Tarifa::class,
            'comparacion_tarifas',
            'id_comparacion',
            'id_tarifa'
        )->withPivot('posicion_resultado');
    }
}
