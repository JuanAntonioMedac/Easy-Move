<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de Tipo de Servicio
 * 
 * @property int $id_tipo_servicio
 * @property string $nombre
 * @property string|null $descripcion
 */
class TipoServicio extends Model
{
    protected $table = 'tipos_servicios';
    protected $primaryKey = 'id_tipo_servicio';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Relación con Servicios
     */
    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class, 'id_tipo_servicio', 'id_tipo_servicio');
    }

    /**
     * Relación con Comparaciones
     */
    public function comparaciones(): HasMany
    {
        return $this->hasMany(Comparacion::class, 'id_tipo_servicio', 'id_tipo_servicio');
    }
}
