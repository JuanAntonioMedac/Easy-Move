<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de Ubicación
 * 
 * @property int $id_ubicacion
 * @property string $codigo_postal
 * @property string $ciudad
 * @property string $provincia
 * @property int|null $numero
 */
class Ubicacion extends Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'id_ubicacion';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Relación con Disponibilidades
     */
    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'id_ubicacion', 'id_ubicacion');
    }

    /**
     * Relación con Comparaciones
     */
    public function comparaciones(): HasMany
    {
        return $this->hasMany(Comparacion::class, 'id_ubicacion', 'id_ubicacion');
    }
}
