# 🚀 ARTESANAL RÁPIDO - PRIMEROS PASOS

## Instalación Rápida en XAMPP (5 minutos)

### **Paso 1: Configurar Base de Datos**

```sql
-- 1. Abrir phpMyAdmin: http://localhost/phpmyadmin
-- 2. Crear base de datos:
CREATE DATABASE easymove;

-- 3. Seleccionar la BD y copiar todo el contenido de database/schema.sql
-- En phpMyAdmin: Pestaña "SQL" → Pegar contenido → Ejecutar
```

**Alternativamente, usando CLI:**
```bash
cd htdocs
mysql -u root < database/schema.sql
```

---

### **Paso 2: Configurar .env**

El archivo ya está configurado para desarrollo local, pero verifica:

```dotenv
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=easymove
DB_USERNAME=root
DB_PASSWORD=

MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_email@gmail.com
MAIL_PASSWORD=tu_app_password    # Genera en: https://myaccount.google.com/apppasswords
```

---

### **Paso 3: Generar APP_KEY**

```bash
php artisan key:generate
```

---

### **Paso 4: Instalar Dependencias**

```bash
# Backend
composer install

# Frontend
npm install

# React DomPDF
composer require barryvdh/laravel-dompdf
```

---

### **Paso 5: Compilar Assets**

```bash
# Desarrollo (watch mode - se actualiza automáticamente)
npm run dev

# Producción (una sola vez)
npm run build
```

---

### **Paso 6: Iniciar el Servidor**

```bash
# Terminal 1: Servidor Laravel (puerto 8000)
php artisan serve

# Terminal 2: Vite dev server (asegura hot reload)
npm run dev
```

**Accede a:** http://localhost:8000

---

## 🧪 Testing Rápido

### **1. Búsqueda sin autenticación:**
- Accede a http://localhost:8000
- Ingresa código postal (ej: 28001)
- Selecciona tipo de servicio
- Haz clic en "Comparar Tarifas"
- **Esperado**: Solo 2 resultados + banner "Regístrate"

### **2. Descarga PDF (requiere datos):**
- Antes, necesitas agregar datos a la BD:

```php
// En tinker:
php artisan tinker

// Crear datos de prueba:
$tipo = \App\Models\TipoServicio::create(['nombre' => 'Luz', 'descripcion' => 'Servicio de luz']);
$proveedor = \App\Models\Proveedor::create(['nombre' => 'Endesa', 'tipo_proveedor' => 'luz']);
$servicio = \App\Models\Servicio::create(['nombre_servicio' => 'Luz Básica', 'id_tipo_servicio' => 1, 'id_proveedor' => 1]);
$tarifa = \App\Models\Tarifa::create(['nombre_tarifa' => 'Tarifa X', 'precio' => 45.50, 'unidad_precio' => 'mes', 'id_servicio' => 1]);
$ubicacion = \App\Models\Ubicacion::create(['codigo_postal' => '28001', 'ciudad' => 'Madrid', 'provincia' => 'Madrid']);
\App\Models\Disponibilidad::create(['id_tarifa' => 1, 'id_ubicacion' => 1]);

exit
```

---

## 📁 Archivos Clave Creados

| Archivo | Descripción |
|---------|-------------|
| `database/schema.sql` | Schema SQL completo |
| `.env` | Configuración de entorno |
| `app/Http/Controllers/SearchController.php` | Controller principal |
| `app/Models/*.php` | 7 modelos Eloquent |
| `routes/web.php` | Rutas definidas |
| `resources/js/components/Navbar.jsx` | Navbar + Modal Login |
| `resources/js/pages/Home.jsx` | Home + Búsqueda |
| `resources/views/pdf/comparacion.blade.php` | Vista PDF |
| `resources/views/emails/comparacion.blade.php` | Vista Email |
| `tailwind.config.js` | Tailwind con darkMode: class |
| `DOCUMENTACION_TECNICA.md` | Documentación completa |
| `RESUMEN_IMPLEMENTACION.md` | Resumen ejecutivo |

---

## ⚡ Comandos Útiles

```bash
# Clear Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Tinker (Shell de PHP)
php artisan tinker

# Ver rutas
php artisan route:list

# Ejecutar migraciones alternativas
php artisan migrate
php artisan migrate:rollback

# Reset completo
php artisan migrate:refresh --seed
```

---

## 🔗 Endpoints Disponibles

```
GET  /                  → Home (SPA)
POST /search            → Búsqueda tarifas
POST /export-pdf        → Descargar PDF (auth)
POST /send-email        → Enviar email (auth)
```

---

## 📧 Testing de Email

**Opción 1: Usar Mailtrap (Gratis)**

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=api
MAIL_PASSWORD=tu_mailtrap_key
MAIL_FROM_ADDRESS=noreply@easymove.net
```

Ir a: https://mailtrap.io (crear cuenta gratuita)

**Opción 2: Gmail (Requiere App Password)**

Instrucciones en DOCUMENTACION_TECNICA.md

---

## 🆘 Troubleshooting

### **Error: "Route not defined"**
```bash
php artisan cache:clear
```

### **Error: "CSRF token mismatch"**
Asegúrate que React incluye el token:
```javascript
'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
```

### **Dark mode no funciona**
Verifica `tailwind.config.js` tenga `darkMode: 'class'`

### **Email no se envía**
1. Verifica credenciales SMTP en `.env`
2. Si usas Gmail, necesitas App Password (no contraseña normal)
3. Prueba con Mailtrap primero

### **PDF no se descarga**
```bash
composer require barryvdh/laravel-dompdf
```

---

## ✅ Checklist Pre-Launch

- [ ] Base de datos importada
- [ ] `.env` configurado con DB real
- [ ] `php artisan key:generate` ejecutado
- [ ] `composer install` completado
- [ ] `npm install` completado
- [ ] `npm run dev` ejecutándose
- [ ] `php artisan serve` ejecutándose
- [ ] Puedo acceder a http://localhost:8000
- [ ] Búsqueda funciona (sin auth)
- [ ] Botones PDF/Email aparecen (requiere login)
- [ ] Email SMTP configurado y testeado

---

**Próximo**: Lee DOCUMENTACION_TECNICA.md para detalles completos

**Soporte**: Ver sección issues en RESUMEN_IMPLEMENTACION.md
