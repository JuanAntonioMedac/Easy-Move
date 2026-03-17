<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de Servicio
 * 
 * @property int $id_servicio
 * @property string $nombre_servicio
 * @property string|null $descripcion
 * @property int $id_tipo_servicio
 * @property int $id_proveedor
 */
class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Relación con Tipo de Servicio
     */
    public function tipoServicio(): BelongsTo
    {
        return $this->belongsTo(TipoServicio::class, 'id_tipo_servicio', 'id_tipo_servicio');
    }

    /**
     * Relación con Proveedor
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    /**
     * Relación con Tarifas
     */
    public function tarifas(): HasMany
    {
        return $this->hasMany(Tarifa::class, 'id_servicio', 'id_servicio');
    }
}
