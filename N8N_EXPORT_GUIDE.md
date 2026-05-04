# Guía: Exportar Datos de n8n para Sincronización

## El Problema
El archivo `n8n scraper/n8n_scraper.json` es la **configuración del workflow**, NO los datos scrapeados.

## Cómo Exportar Datos de n8n

### Opción 1: Usar el Nodo de Escritura de Archivo en n8n (Recomendado)

1. **En tu workflow n8n**, agrega un nodo **"Write Binary File"** o **"Set"** después del último nodo de scraping
2. **Configura para guardar JSON**:
   ```json
   {
     "operation": "set",
     "properties": {
       "output": "{{ $json }}"
     }
   }
   ```
3. **O usa "Write Binary File"**:
   - Set filename to: `output.json`
   - Set path to: la ruta donde quieras los datos
4. **Ejecuta el workflow**
5. **Descarga el archivo JSON** generado

### Opción 2: Copiar Salida de la Ejecución

1. **En n8n**, haz clic en el último nodo ejecutado
2. **Ve a la pestaña "Output"**
3. **Haz clic en el botón "Copy to Clipboard"** (si aparece)
4. **Crea un archivo `scraper-results.json`** en la carpeta del proyecto
5. **Pega el contenido** (asegúrate que sea un array JSON válido)

### Opción 3: Usar Webhook en n8n para Capturar Datos

1. **Agrega un nodo "Webhook"** al final del workflow
2. **Configura para recibirlo en tu Laravel app**
3. **Crea un endpoint** que guarde el JSON

---

## Estructura Esperada del JSON

El comando `scraper:sync-json` espera un **array de objetos** con esta estructura:

```json
[
  {
    "proveedor_nombre": "Nombre Empresa",
    "proveedor_web": "https://www.empresa.es",
    "logo_url": "https://www.empresa.es/logo.svg",
    "tipo_servicio": "Luz | Gas | Telefonía",
    "nombre_servicio": "Nombre del Servicio",
    "descripcion_servicio": "Descripción",
    "nombre_tarifa": "Nombre Tarifa",
    "precio": 45.50,
    "unidad_precio": "mes",
    "permanencia": "Sin permanencia | 12 meses",
    "condiciones": "Texto de condiciones",
    "url_oferta_externa": "https://...",
    "codigo_postal": "28001",
    "ciudad": "Madrid",
    "provincia": "Madrid"
  }
]
```

### Campos Obligatorios:
- `proveedor_nombre`
- `tipo_servicio`
- `nombre_servicio`
- `nombre_tarifa`
- `precio` (número)
- `codigo_postal`

### Campos Opcionales:
- `logo_url` (URL de imagen)
- `proveedor_web` (URL completa)
- `descripcion_servicio`
- `unidad_precio`
- `permanencia`
- `condiciones`
- `url_oferta_externa`
- `ciudad`
- `provincia`

---

## Uso del Comando

Una vez tengas el JSON:

```bash
# Vista previa sin cambios en BD
php artisan scraper:sync-json --file=ruta/al/archivo.json --dry-run

# Sincronizar datos reales
php artisan scraper:sync-json --file=ruta/al/archivo.json

# Sincronizar Y eliminar registros no incluidos en el JSON
php artisan scraper:sync-json --file=ruta/al/archivo.json --delete

# Buscar automáticamente en carpetas conocidas
php artisan scraper:sync-json --dry-run
```

---

## Ubicaciones de Búsqueda Automática

Si **NO especificas `--file`**, el comando busca en:

1. `n8n scraper/n8n_scraper.json` (actual - **es el workflow, no datos**)
2. `n8n scraper/scraper-results.json`
3. `n8n scraper/results.json`
4. `storage/scraper.json`
5. `scraper-data.json` (raíz del proyecto)

**Recomendación**: Crea un archivo `n8n scraper/scraper-results.json` con los datos.

---

## Archivos de Ejemplo

- **`n8n_scraper_example.json`** - Estructura correcta con 5 registros de ejemplo
- **`n8n_scraper.json`** - Tu workflow actual (configuración, no datos)

---

## Troubleshooting

| Error | Solución |
|-------|----------|
| "No se encontró archivo JSON" | Coloca el JSON en una de las carpetas buscadas |
| "Estructura JSON no reconocida" | Asegúrate que sea un array `[{...}, {...}]` |
| "TypeError: string + int" | Actualiza a la última versión del comando |
| "Precio debe ser numérico" | El campo `precio` debe ser número, no string |

---

## Próximos Pasos

1. **Ejecuta tu workflow n8n**
2. **Exporta los resultados** a `n8n scraper/scraper-results.json`
3. **Ejecuta**: `php artisan scraper:sync-json --dry-run`
4. **Verifica**: Los registros se muestran sin errores
5. **Sincroniza**: `php artisan scraper:sync-json` (sin `--dry-run`)
