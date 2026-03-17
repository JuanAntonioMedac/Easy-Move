<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de Proveedor
 * 
 * @property int $id_proveedor
 * @property string $nombre
 * @property string|null $web
 * @property string|null $logo
 * @property string $tipo_proveedor
 * @property boolean $api_disponible
 */
class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    protected $guarded = [];
    public $timestamps = true;

    protected $casts = [
        'api_disponible' => 'boolean',
    ];

    /**
     * Relación con Servicios
     */
    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class, 'id_proveedor', 'id_proveedor');
    }
}
