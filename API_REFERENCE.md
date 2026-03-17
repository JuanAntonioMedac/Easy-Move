# API Endpoints - EASYMOVE
## Referencia Rápida JSON

---

## 📌 1. GET `/` - Página Home

### Request
```
GET http://localhost:8000/
```

### Response
**Inertia Response** (React Page)
```javascript
// Recibe props en React:
{
  "tiposServicios": [
    {
      "id_tipo_servicio": 1,
      "nombre": "Luz"
    },
    {
      "id_tipo_servicio": 2,
      "nombre": "Gas"
    },
    {
      "id_tipo_servicio": 3,
      "nombre": "Telefonía"
    }
  ],
  "user": null  // null si no está autenticado
}
```

---

## 📌 2. POST `/search` - Búsqueda de Tarifas

### Request

**Headers:**
```http
POST http://localhost:8000/search
Content-Type: application/json
X-CSRF-TOKEN: {token}
```

**Body:**
```json
{
  "codigo_postal": "28001",
  "id_tipo_servicio": 1,
  "ciudad": "Madrid",        // Opcional
  "provincia": "Madrid"      // Opcional
}
```

### Response - Sin Autenticación (Invitado)

**Status 200 OK**
```json
{
  "success": true,
  "data": {
    "tarifas": [
      {
        "id_tarifa": 101,
        "nombre_tarifa": "Tarifa Luz Plus",
        "precio": 45.5,
        "unidad_precio": "mes",
        "permanencia": "Sin permanencia",
        "condiciones": "Contrato flexible con 24 horas de cancelación",
        "url_oferta_externa": "https://example.com/oferta",
        "servicio": {
          "id_servicio": 50,
          "nombre_servicio": "Luz Básica",
          "descripcion": "Tarifa de energía estándar"
        },
        "proveedor": {
          "id_proveedor": 5,
          "nombre": "Endesa",
          "web": "https://www.endesa.es",
          "logo": "https://logo-url.com/endesa.png"
        }
      },
      {
        "id_tarifa": 102,
        "nombre_tarifa": "Tarifa Luz Eco",
        "precio": 52.3,
        "unidad_precio": "mes",
        "permanencia": "12 meses",
        "condiciones": "Incluye descuento 10% en acceso",
        "url_oferta_externa": "https://example.com/oferta2",
        "servicio": {
          "id_servicio": 51,
          "nombre_servicio": "Luz Eco",
          "descripcion": "Tarifa sostenible"
        },
        "proveedor": {
          "id_proveedor": 6,
          "nombre": "EDF",
          "web": "https://www.edf.es",
          "logo": "https://logo-url.com/edf.png"
        }
      }
    ],
    "comparacion_id": 1,
    "ubicacion": {
      "id_ubicacion": 1,
      "codigo_postal": "28001",
      "ciudad": "Madrid",
      "provincia": "Madrid"
    },
    "tipo_servicio": {
      "id_tipo_servicio": 1
    },
    "meta": {
      "is_limited": true,              // 🔴 LIMITADO A 2
      "total_resultados": 15,          // Hay 15 en la BD
      "resultados_mostrados": 2,       // Pero solo mostramos 2
      "is_authenticated": false
    }
  }
}
```

### Response - Con Autenticación (Usuario Logueado)

**Status 200 OK**
```json
{
  "success": true,
  "data": {
    "tarifas": [
      // ... 15 tarifas completas (TODAS)
    ],
    "comparacion_id": 2,
    "ubicacion": { ... },
    "tipo_servicio": { ... },
    "meta": {
      "is_limited": false,             // ✅ SIN LÍMITE
      "total_resultados": 15,
      "resultados_mostrados": 15,      // Mostramos todas
      "is_authenticated": true
    }
  }
}
```

### Response - Error

**Status 500 Internal Server Error**
```json
{
  "success": false,
  "message": "Error en la búsqueda: undefined method..."
}
```

---

## 📌 3. POST `/export-pdf` - Descargar PDF

### Request

**Headers:**
```http
POST http://localhost:8000/export-pdf
Content-Type: application/json
X-CSRF-TOKEN: {token}
Authorization: Bearer {token}  // Required Auth
```

**Body:**
```json
{
  "comparacion_id": 1
}
```

### Response - Éxito

**Status 200 OK**
**Content-Type: application/pdf**
```
[Binary PDF data]
Content-Disposition: attachment; filename="comparativa-tarifas-2026-02-13.pdf"
```

### Response - Error (No Autenticado)

**Status 401 Unauthorized**
```json
{
  "message": "Unauthenticated"
}
```

### Response - Error (No Autorizado)

**Status 403 Forbidden**
```json
{
  "error": "No autorizado"
}
```

---

## 📌 4. POST `/send-email` - Enviar Email

### Request

**Headers:**
```http
POST http://localhost:8000/send-email
Content-Type: application/json
X-CSRF-TOKEN: {token}
Authorization: Bearer {token}  // Required Auth
```

**Body:**
```json
{
  "comparacion_id": 1,
  "email": "usuario@example.com"
}
```

### Response - Éxito

**Status 200 OK**
```json
{
  "success": true,
  "message": "Email enviado correctamente a usuario@example.com"
}
```

### Response - Error (Validación)

**Status 422 Unprocessable Entity**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "comparacion_id": [
      "The comparacion id field is required."
    ],
    "email": [
      "The email field must be a valid email address."
    ]
  }
}
```

### Response - Error (No Autorizado)

**Status 403 Forbidden**
```json
{
  "error": "No autorizado"
}
```

### Response - Error (Email SMTP)

**Status 500 Internal Server Error**
```json
{
  "success": false,
  "message": "Error al enviar email: SMTP Connection refused"
}
```

---

## 🔐 Headers Requeridos (Todo request POST)

```http
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}
```

**Para obtener CSRF Token en React:**
```javascript
const token = document.querySelector('meta[name="csrf-token"]')?.content;

// O como header en fetch:
fetch('/search', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': token
  },
  body: JSON.stringify({ ... })
})
```

---

## 🧪 Ejemplos CURL para Testing

### Búsqueda (GET sin auth)
```bash
curl -X POST http://localhost:8000/search \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: {csrf_token}" \
  -d '{
    "codigo_postal": "28001",
    "id_tipo_servicio": 1,
    "ciudad": "Madrid",
    "provincia": "Madrid"
  }'
```

### Descargar PDF (POST con auth)
```bash
curl -X POST http://localhost:8000/export-pdf \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: {csrf_token}" \
  -H "Authorization: Bearer {auth_token}" \
  -d '{ "comparacion_id": 1 }' \
  -o comparativa.pdf
```

### Enviar Email (POST con auth)
```bash
curl -X POST http://localhost:8000/send-email \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: {csrf_token}" \
  -H "Authorization: Bearer {auth_token}" \
  -d '{
    "comparacion_id": 1,
    "email": "test@example.com"
  }'
```

---

## 📊 Estructura de Comparacion Guardada

Cuando se ejecuta POST `/search`, se guarda en la BD:

```sql
-- Tabla: comparaciones
INSERT INTO comparaciones VALUES (
  id_comparacion: 1,
  fecha: 2026-02-13 10:30:00,
  id_usuario: NULL (si invitado) | 5 (si autenticado),
  id_ubicacion: 1,
  id_tipo_servicio: 1
);

-- Tabla: comparacion_tarifas (pivote)
INSERT INTO comparacion_tarifas VALUES
(id_comparacion_tarifa: 1, id_comparacion: 1, id_tarifa: 101, posicion_resultado: 1),
(id_comparacion_tarifa: 2, id_comparacion: 1, id_tarifa: 102, posicion_resultado: 2);
```

---

## 🔄 Flujo Completo en la UI

```
1. Usuario accede GET /
   ↓ Inertia carga Home.jsx
   ↓

2. Usuario rellena formulario y hace clic COMPARAR
   ↓ Fetch POST /search con CSRF token
   ↓

3. SearchController@search()
   ↓ Valida inputs
   ↓ Si !Auth: take(2) | Si Auth: todos
   ↓ Crea Comparacion + ComparacionTarifa en BD
   ↓ Responde JSON
   ↓

4. Home.jsx recibe respuesta
   ↓ Si is_limited=true y !user: Muestra Blur/Lock
   ↓ Si is_limited=false o user: Muestra todo normal
   ↓ Habilita/Deshabilita botones PDF/Email
   ↓

5. Usuario clica "Descargar PDF"
   ↓ Fetch POST /export-pdf (requiere auth)
   ↓ SearchController@exportPdf()
   ↓ Genera PDF con DomPDF
   ↓ Descarga archivo
   ↓

6. Usuario clica "Enviar Email"
   ↓ Modal abre con campo email
   ↓ Fetch POST /send-email (requiere auth)
   ↓ SearchController@sendEmail()
   ↓ Usa Mail::send() con DomPDF adjunto
   ↓ Email a no-reply@easymove.net
   ↓

FIN ✅
```

---

## 🎯 Validaciones Implementadas

### SearchController@search()
- ✓ codigo_postal: required, string, max:10
- ✓ id_tipo_servicio: required, integer, exists en DB

### SearchController@exportPdf()
- ✓ comparacion_id: required, integer, exists en DB
- ✓ Comparación pertenece al usuario

### SearchController@sendEmail()
- ✓ comparacion_id: required, integer, exists en DB
- ✓ email: required, email
- ✓ Comparación pertenece al usuario

---

**Última actualización**: 13/02/2026
