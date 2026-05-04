# 🤖 Sincronización Automática del Scraper n8n

Sistema completo para sincronizar datos del JSON del scraper n8n con la base de datos de Easy-Move automáticamente.

---

## 📋 Características

✅ **Lectura automática del JSON** del scraper n8n  
✅ **Creación automática de proveedores** con logos (URL o archivo)  
✅ **Creación automática de servicios** y tarifas  
✅ **Actualización de datos existentes**  
✅ **Eliminación de registros no encontrados en el JSON**  
✅ **Dry-run para previsualizar cambios sin aplicarlos**  
✅ **Logging detallado de todas las operaciones**  
✅ **API REST para sincronización desde web**  

---

## 🚀 Formas de Usar

### **Opción 1: Comando Artisan (Terminal) ⭐ Recomendado**

```bash
# Sincronización básica (crear/actualizar)
php artisan scraper:sync-json

# Previsualizar cambios (sin aplicarlos)
php artisan scraper:sync-json --dry-run

# Sincronizar Y eliminar lo que no esté en el JSON
php artisan scraper:sync-json --delete

# Combinar opciones
php artisan scraper:sync-json --dry-run --delete

# Especificar archivo JSON diferente
php artisan scraper:sync-json --file=mi-scraper.json
```

### **Opción 2: Desde Panel Admin (Web UI)**

```
1. Login como admin
2. Ve a: /admin/
3. Ve a: /admin/scraper (cuando lo agregues)
4. Click "Sincronizar JSON"
5. Ver resultado en tiempo real
```

### **Opción 3: API HTTP**

```bash
# Sincronización básica
curl -X POST http://localhost:8000/admin/scraper/sync-json \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "dry_run": false,
    "delete": false,
    "file": "n8n_scraper.json"
  }'

# Previsualizar cambios
curl -X POST http://localhost:8000/admin/scraper/sync-json \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"dry_run": true}'

# Validar JSON antes de sincronizar
curl -X POST http://localhost:8000/admin/scraper/validate-json \
  -H "Authorization: Bearer TOKEN" \
  -F "json_file=@scraper.json"
```

---

## 📊 Estructura del JSON Esperada

El comando soporta múltiples estructuras de JSON:

### **Estructura 1: Array simple**
```json
[
  {
    "proveedor_nombre": "Endesa",
    "proveedor_web": "https://www.endesa.es",
    "logo_url": "https://logo.com/endesa.png",
    "tipo_servicio": "Luz",
    "nombre_servicio": "Luz Básica",
    "nombre_tarifa": "Tarifa X",
    "precio": 45.50,
    "unidad_precio": "mes",
    "permanencia": "Sin permanencia",
    "condiciones": "24h cancelación",
    "url_oferta_externa": "https://ejemplo.com/oferta",
    "codigo_postal": "28001",
    "ciudad": "Madrid",
    "provincia": "Madrid"
  }
]
```

### **Estructura 2: Con clave 'data'**
```json
{
  "data": [
    { /* registro */ }
  ]
}
```

### **Estructura 3: Con clave 'tarifas'**
```json
{
  "tarifas": [
    { /* registro */ }
  ]
}
```

---

## 🔄 Flujo de Sincronización

```
JSON Input
    ↓
Parsear JSON (busca múltiples formatos)
    ↓
Para cada registro:
    ├─ Crear/Actualizar PROVEEDOR
    │  ├─ nombre
    │  ├─ web
    │  └─ logo (URL o archivo)
    │
    ├─ Crear/Actualizar SERVICIO
    │  ├─ nombre_servicio
    │  └─ tipo_servicio
    │
    ├─ Crear/Actualizar TARIFA
    │  ├─ nombre_tarifa
    │  ├─ precio
    │  ├─ unidad_precio
    │  ├─ permanencia
    │  └─ condiciones
    │
    └─ Crear DISPONIBILIDAD
       ├─ código_postal
       ├─ ciudad
       └─ provincia
        ↓
(Opcional) Eliminar registros no procesados
    ↓
Mostrar resumen
```

---

## 🎯 Ejemplos de Uso

### **Ejemplo 1: Sincronización Inicial**

```bash
# Ver qué se cambiaría (sin aplicar)
php artisan scraper:sync-json --dry-run

# Salida esperada:
# [1/2] Sincronizando Endesa...
# ✓ Proveedor creado: Endesa
# ✓ Servicio creado: Luz Básica
# ✓ Tarifa creada: Tarifa X (€45.50/mes)
#
# === RESUMEN ===
# ✓ Proveedores creados: 1
# ✓ Servicios creados: 1
# ✓ Tarifas creadas: 1
```

### **Ejemplo 2: Sincronizar con Eliminación**

```bash
# Si el JSON tiene menos datos, elimina lo que no esté
php artisan scraper:sync-json --delete

# Salida esperada:
# === RESUMEN ===
# ✓ Proveedores creados: 2
# ✓ Proveedores actualizados: 3
# ✗ Proveedores eliminados: 1
# ✗ Servicios eliminados: 2
```

### **Ejemplo 3: Desde Web API**

```javascript
// En tu frontend (Admin Panel)
async function syncScraper() {
  const response = await fetch('/admin/scraper/sync-json', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
      dry_run: false,
      delete: true
    })
  });

  const data = await response.json();
  console.log(data);
  // {
  //   success: true,
  //   message: "Sincronización completada",
  //   output: "..."
  // }
}
```

---

## 🛠️ Opciones del Comando

| Opción | Descripción | Defecto |
|--------|-------------|---------|
| `--file` | Archivo JSON a leer | `n8n_scraper.json` |
| `--dry-run` | Previsualizar cambios sin aplicar | `false` |
| `--delete` | Eliminar registros no en JSON | `false` |

---

## 🔍 Búsqueda de Archivo JSON

El comando busca el archivo en estas ubicaciones (en orden):

```
1. Base: n8n_scraper.json
2. Storage: storage/n8n_scraper.json
3. Database: database/n8n_scraper.json
4. Carpeta n8n: n8n scraper/n8n_scraper.json
5. Alternativa: n8n-scraper/n8n_scraper.json
```

Especifica otra ruta:
```bash
php artisan scraper:sync-json --file=ruta/custom/scraper.json
```

---

## 📝 Campos Soportados

### **Proveedor**
- `proveedor_nombre` (obligatorio)
- `proveedor_web`
- `logo_url` / `logo` (URL o ruta archivo)
- `tipo_proveedor` / `tipo_servicio`

### **Servicio**
- `nombre_servicio` (obligatorio)
- `descripcion_servicio`
- `tipo_servicio`

### **Tarifa**
- `nombre_tarifa`
- `precio` (obligatorio, > 0)
- `unidad_precio` (mes, año, etc)
- `permanencia`
- `condiciones`
- `url_oferta_externa`

### **Ubicación**
- `codigo_postal` (obligatorio para disponibilidad)
- `ciudad`
- `provincia`

---

## 🚨 Validaciones

El comando valida automáticamente:

✅ Archivo JSON existe y es válido  
✅ Proveedores tienen nombre  
✅ Servicios tienen nombre  
✅ Tarifas tienen precio > 0  
✅ Códigos postales válidos  

---

## 📊 Resumen de Sincronización

Cada ejecución muestra:

```
===== RESUMEN DE SINCRONIZACIÓN =====

Proveedores:
  ✓ Creados: 3
  ✓ Actualizados: 2
  ✗ Eliminados: 0

Servicios:
  ✓ Creados: 5
  ✓ Actualizados: 1
  ✗ Eliminados: 0

Tarifas:
  ✓ Creadas: 12
  ✓ Actualizadas: 3
  ✗ Eliminadas: 0

  ✓ Disponibilidades creadas: 15

✅ Sincronización completada!
```

---

## 🔐 Permisos

- **Comando Artisan**: Requiere acceso a terminal (local o SSH)
- **API HTTP**: Requiere autenticación (admin)
- **Admin Panel**: Requiere rol admin

---

## 🐛 Troubleshooting

### **Error: "Archivo JSON no encontrado"**
```bash
# Verifica ubicación del archivo
ls -la n8n_scraper.json

# O especifica la ruta completa
php artisan scraper:sync-json --file=/ruta/completa/scraper.json
```

### **Error: "JSON inválido"**
```bash
# Valida el JSON
php artisan scraper:sync-json --file=scraper.json

# O valida antes vía API
curl -X POST http://localhost:8000/admin/scraper/validate-json \
  -F "json_file=@scraper.json"
```

### **Datos no se actualizan**
```bash
# Usa --dry-run para ver qué pasaría
php artisan scraper:sync-json --dry-run

# Verifica que el JSON tiene estructura correcta
```

---

## 📅 Automatizar Sincronización

### **Opción 1: Cron Job (Laravel Scheduler)**

Edita `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Sincronizar cada hora
    $schedule->command('scraper:sync-json')->hourly();
    
    // Sincronizar cada día a las 2 AM
    $schedule->command('scraper:sync-json --delete')->dailyAt('02:00');
    
    // Sincronizar cada 30 minutos
    $schedule->command('scraper:sync-json')->everyThirtyMinutes();
}
```

Activa el scheduler:
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### **Opción 2: n8n Webhook**

Configura en n8n un webhook que dispare:

```bash
POST /admin/scraper/sync-json
```

---

## 📚 API Endpoints

### **POST /admin/scraper/sync-json**
Sincroniza datos del scraper

**Request:**
```json
{
  "dry_run": false,
  "delete": false,
  "file": "n8n_scraper.json"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Sincronización completada exitosamente",
  "output": "...",
  "dry_run": false
}
```

### **POST /admin/scraper/validate-json**
Valida archivo JSON

**Request:**
```
multipart/form-data
json_file: (archivo)
```

**Response:**
```json
{
  "success": true,
  "message": "JSON válido",
  "records_count": 25,
  "sample": { /* primer registro */ }
}
```

---

## 💡 Tips y Mejores Prácticas

1. **Usa `--dry-run` primero**: Siempre previsualiza cambios
2. **No uses `--delete` hasta estar seguro**: Puede eliminar datos importantes
3. **Mantén logs**: Revisa los logs para auditoría
4. **Automatiza**: Usa scheduler para sincronizar regularmente
5. **Respaldos**: Haz backup de BD antes de sincronizar con `--delete`

---

**Versión**: 1.0  
**Creado**: Abril 2026  
**Estado**: ✅ Producción
