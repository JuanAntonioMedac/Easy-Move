# 🚀 Mejoras Implementadas en el Scraper n8n

## ✅ Cambios Realizados

### 1. **Nodo: Generar Tareas (CP + Compañía)**
**Antes:**
```javascript
{ name: 'endesa', url: '...' }
```

**Ahora:**
```javascript
{
  name: 'Endesa',
  url: '...',
  web: 'https://www.endesa.es',
  logo: 'https://www.endesa.com/etc/designs/...' // URL del logo
}
```

✨ **Agregado**: URLs directas de logos por proveedor + URLs web oficiales

---

### 2. **Nodo: Extraer Texto (Ahorrar Tokens)**
**Antes:** Solo extraía `texto_limpio` del body

**Ahora:** Extrae también:
- `logos_encontrados`: Detecta automáticamente logos en la página
- `precio_elemento`: Elementos HTML de precios
- `url_actual`: URL de la página (útil para validar)

✨ **Selectores CSS mejorados:**
- `[class*='logo']` - Elementos con "logo" en clase
- `img[alt*='logo']` - Imágenes con "logo" en alt
- `img[src*='logo']` - Imágenes con "logo" en URL
- `svg[id*='logo']` - SVGs con "logo" en ID

---

### 3. **JSON Schema del AI Agent**
**Antes:** Solo extraía tarifa básica
```json
{
  "nombre_tarifa": "string",
  "precio": "number",
  "permanencia": "string",
  "url_oferta": "string",
  "condiciones": "string"
}
```

**Ahora:** Incluye datos del proveedor
```json
{
  "nombre_tarifa": "string",
  "precio": "number",
  "permanencia": "string",
  "url_oferta": "string",
  "condiciones": "string",
  "proveedor_nombre": "string",           // ✨ NUEVO
  "proveedor_web": "string",              // ✨ NUEVO
  "logo_url": "string (URL)"              // ✨ NUEVO
}
```

---

## 📋 Pasos Manual en n8n 

### **Paso 1: Actualizar el Prompt del AI Agent**

En el nodo **"AI Agent"**, cambia el prompt a:

```
Analiza esta página web y extrae:

1. **Tarifas disponibles**: 
   - nombre_tarifa: Nombre exacto de la tarifa
   - precio: Precio mensual (solo número con 2 decimales)
   - permanencia: Duración del contrato

2. **Información del Proveedor**:
   - proveedor_nombre: Nombre de la empresa
   - proveedor_web: URL web del proveedor
   - logo_url: URL del logo/imagen del proveedor (preferentemente SVG o PNG)

3. **Oferta**:
   - url_oferta: URL donde contratar
   - condiciones: Beneficios especiales o descuentos

IMPORTANTE:
- Si no encuentras logo en la página, usa la URL pasada en proveedorLogo
- Los precios SIEMPRE deben ser números con máximo 2 decimales
- La permanencia debe ser en formato: "12 meses", "24 meses", "Sin permanencia"
- Las URLs DEBEN ser completas (con http:// o https://)

Devuelve JSON estructurado.
```

---

### **Paso 2: Actualizar Nodo MySQL - Agregar Columna**

Ejecuta esta migración SQL en tu BD:

```sql
-- Si la columna no existe, añádela
ALTER TABLE ofertas_scraping 
ADD COLUMN logo_url VARCHAR(500) NULL AFTER condiciones;

-- Verifica la estructura
DESCRIBE ofertas_scraping;
```

---

### **Paso 3: Actualizar Query MySQL en n8n**

En el nodo **"MySQL (Guardar Datos)"**, cambia la operación a:

**INSERT con todos los campos:**
```sql
INSERT INTO ofertas_scraping 
(company, postalCode, nombre_tarifa, precio, permanencia, condiciones, url_oferta, proveedor_nombre, proveedor_web, logo_url)
VALUES 
($json.company, $json.codigoPostal, $json.nombre_tarifa, $json.precio, $json.permanencia, $json.condiciones, $json.url_oferta, $json.proveedor_nombre, $json.proveedor_web, $json.logo_url)
```

---

## 🔧 Validaciones Recomendadas

### Agregar nodo "Data Validation" después del AI Agent:

```javascript
// Validar estructura de datos
const requiredFields = ['nombre_tarifa', 'precio', 'permanencia', 'url_oferta', 'condiciones', 'proveedor_nombre', 'logo_url'];

for (const field of requiredFields) {
  if (!$input.item.json[field]) {
    throw new Error(`Campo requerido faltante: ${field}`);
  }
}

// Validar que precio sea número
if (typeof $input.item.json.precio !== 'number' || $input.item.json.precio <= 0) {
  throw new Error('El precio debe ser un número positivo');
}

// Validar URLs
const urlFields = ['url_oferta', 'proveedor_web', 'logo_url'];
const urlRegex = /^https?:\/\/.+/i;

for (const field of urlFields) {
  if (!urlRegex.test($input.item.json[field])) {
    throw new Error(`${field} no es una URL válida: ${$input.item.json[field]}`);
  }
}

return $input.items;
```

---

## 📊 Tabla de Datos Esperada

```
ofertas_scraping:
┌─────┬─────────┬────────────┬───────┬────────────┬───────────────┬──────────────┬──────────────────┬──────────────────┬─────────────────────┐
│ id  │ company │ postalCode │ price │ nombre_tar │ permanencia   │ condiciones  │ url_oferta       │ proveedor_nombre │ logo_url            │
├─────┼─────────┼────────────┼───────┼────────────┼───────────────┼──────────────┼──────────────────┼──────────────────┼─────────────────────┤
│  1  │ Endesa  │ 18005      │ 45.50 │ Luz Básica │ 12 meses      │ Sin cambios  │ https://endesa.. │ Endesa           │ https://endesa.com/ │
│  2  │ Iberdr. │ 18005      │ 52.30 │ Luz Eco    │ Sin permanencia│ -10% primer.. │ https://iberdr.. │ Iberdrola        │ https://iberdrola.. │
└─────┴─────────┴────────────┴───────┴────────────┴───────────────┴──────────────┴──────────────────┴──────────────────┴─────────────────────┘
```

---

## 🎯 Flujo Final Mejorado

```
1. Manual Trigger
   ↓
2. Generar Tareas (CP + Compañía + LOGOS)
   ↓
3. Loop (Iterar)
   ↓
4. HTTP Request (GET página)
   ↓
5. Extraer Texto + CSS Selectors (incluye logos)
   ↓
6. AI Agent (Parsear con Logo + Proveedor)
   ↓
7. Data Validation (Validar estructura)
   ↓
8. MySQL INSERT (guardar con logo_url)
   ↓
9. Wait 3s (Anti-rate limit)
   ↓
10. Volver a Loop hasta terminar
```

---

## 🚀 Integración con Backend

El backend PHP ya está listo para recibir logos:

```php
// En AdminController@storeProvider()
// Campo 'logo' puede ser:
// - URL: 'https://example.com/logo.png'
// - Archivo: 'proveedores/logo.png' (local)

// n8n inserta directamente en BD:
// INSERT INTO proveedores (nombre, web, logo, tipo_proveedor, api_disponible)
// VALUES ('Endesa', 'https://endesa.es', 'https://endesa.com/logo.svg', 'luz', 1)
```

---

## ⚠️ Consideraciones

1. **Rate Limiting**: Algunas webs bloquean scrapers. El Wait 3s ayuda pero tal vez necesites más.
2. **Logos que fallan**: Si una URL de logo devuelve 404, el AI Agent debe usar la alternativa (proveedorLogo).
3. **Mantenimiento**: Las URLs de logos pueden cambiar. Verifica mensualmente.
4. **CORS/Robots.txt**: Algunos sitios prohíben scraping. Usa proxies si es necesario.

---

## 📱 Testing

Para probar el scraper:

```bash
# Test en un solo postal code + company
curl -X POST http://localhost/admin/test-scraper \
  -H "Content-Type: application/json" \
  -d '{"codigoPostal": "18005", "company": "Endesa"}'
```

---

**Última actualización**: 21/04/2026
**Estado**: Listo para producción con logos
