<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Obtener URL completa del logo
     * Soporta tanto URLs directas como rutas locales en Storage
     *
     * @return string|null
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (!$this->logo) {
            return null;
        }

        // Si es una URL completa (comienza con http:// o https://), devolverla como está
        if (filter_var($this->logo, FILTER_VALIDATE_URL)) {
            return $this->logo;
        }

        // Si no, es una ruta local en Storage
        return Storage::url($this->logo);
    }

    /**
     * Comprobar si el logo es una URL externa
     *
     * @return bool
     */
    public function isExternalLogoUrl(): bool
    {
        return $this->logo && filter_var($this->logo, FILTER_VALIDATE_URL);
    }

    /**
     * Comprobar si el logo es un archivo local
     *
     * @return bool
     */
    public function isLocalLogo(): bool
    {
        return $this->logo && !filter_var($this->logo, FILTER_VALIDATE_URL);
    }
}
