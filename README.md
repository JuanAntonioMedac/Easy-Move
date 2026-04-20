# EASYMOVE - Documentación General

---

# ✨ ACTUALIZACIÓN ABRIL 2026 - REDISEÑO UI/UX COMPLETO

## 🎨 5 Pasos de Mejora Visual Implementados

Se ha realizado una **transformación completa de la interfaz** manteniendo toda la funcionalidad backend intacta.

### **Paso 1: 🏠 Landing Page (welcome.blade.php)**
- ✅ Hero section con gradiente azul→morado
- ✅ 6 feature cards con iconos
- ✅ Grid de proveedores destacados
- ✅ Sección testimonios
- ✅ Call-to-action footer
- 📱 100% responsive + dark mode

### **Paso 2: 📊 Admin Dashboard (dashboard.blade.php)**
- ✅ KPI cards con trend indicators
- ✅ Gradientes personalizados por sección
- ✅ Charts y gráficos integrados
- ✅ Quick action buttons
- 🎯 Información resumida para admins

### **Paso 3: 📋 Admin Tables (5 CRUD Tables)**
Rediseño completo de todas las tablas de administración con gradientes únicos:

| Tabla | Gradiente | Emoji | URL |
|-------|-----------|-------|-----|
| Providers | Azul (blue-600→700) | 🏢 | `/admin/providers` |
| Services | Morado (purple-600→700) | ⚡ | `/admin/services` |
| Tariffs | Rosa (rose-600→700) | 💰 | `/admin/tariffs` |
| Locations | Esmeralda (emerald-600→700) | 📍 | `/admin/locations` |
| Users | Naranja (orange-600→700) | 👥 | `/admin/users` |

**Features:**
- Búsqueda + filtros avanzados
- Badges con colores contextuales
- Hover effects suaves
- Paginación centrada
- Dark mode completo

### **Paso 4: 🧭 Navbar + Footer Global (layouts/app.blade.php)**
**Navbar:**
- ✅ Logo truck (bi-truck) + gradiente "EasyMove"
- ✅ Search bar (visible en desktop)
- ✅ Theme toggle (moon/sun icon)
- ✅ **Admin Panel button** visible (morado→rosa gradient)
- ✅ User info (nombre + rol)
- ✅ **Power logout button** (rojo) en lugar de dropdown
- ✅ Mobile menu responsive

**Footer:**
- 4-column grid layout
- Brand + truck icon
- Product/Company/Legal sections
- Social media links
- Copyright

### **Paso 5: 💾 Comparison Page (`/comparison/{id}`)**
**Card-based layout (vs tabla antigua):**
- ✅ Grid responsive: 1 col (móvil) → 3 cols (desktop)
- ✅ **Tarifa más barata**: Borde verde + badge ⭐ + botón verde
- ✅ Otras tarifas: Muestran "+€ más caro" en rojo
- ✅ Info de precios: Box azul con mejor precio + ahorro total
- ✅ Dark mode optimizado
- ✅ Modal guardado con gradiente header
- ✅ Section guest con lock icon + auth buttons

---

## 🛠️ Requisitos de Instalación (Cambios)

**BUENA NOTICIA:** No se necesitan nuevas dependencias. Todo usa:
- ✅ **Tailwind CSS** (ya instalado: 60.10 kB compilado)
- ✅ **Bootstrap Icons** (ya incluido: bi-truck, bi-power, bi-bookmark, etc.)
- ✅ **Blade templating** (Laravel nativo)

**Cambios en .env:**
```dotenv
# No se agregó ninguna variable nueva
# El proyecto sigue usando:
# - DB (como antes)
# - MAIL (como antes)
# - APP_KEY (como antes)
```

**Compilación CSS requerida:**
```bash
npm run build
```
Esta se ejecutó automáticamente durante los cambios. Resultado:
- **CSS final:** 60.10 kB (gzip: 9.18 kB)
- **Memoria:** Sin crecimiento significativo
- **Build time:** ~3.6 segundos

---

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

## 🧪 Testing Rápido - Nuevas Páginas Rediseñadas

### **1. Landing Page (Pública - Sin Auth)**
**URL:** `http://localhost:8000/`  
**Qué ver:**
- ✅ Hero gradient azul→morado
- ✅ Feature cards con iconos
- ✅ Provider grid
- ✅ Testimonials section
- ✅ Footer 4-columnas
- ✅ Dark mode toggle (moon icon en navbar)

### **2. Admin Dashboard (Requiere Auth + Admin)**
**URL:** `http://localhost:8000/admin/dashboard`  
**Pasos:**
1. Login con usuario admin
2. Ir a Dashboard
3. Ver:
   - ✅ KPI cards con estadísticas
   - ✅ Charts y gráficos
   - ✅ Quick actions buttons

### **3. Admin Tables (Requiere Auth + Admin)**
**Tablas rediseñadas con gradientes únicos:**

```
🏢 Providers  → http://localhost:8000/admin/providers      (Azul)
⚡ Services   → http://localhost:8000/admin/services       (Morado)
💰 Tariffs    → http://localhost:8000/admin/tariffs        (Rosa)
📍 Locations  → http://localhost:8000/admin/locations      (Esmeralda)
👥 Users      → http://localhost:8000/admin/users          (Naranja)
```

**Qué probar:**
- ✅ Búsqueda por texto
- ✅ Filtros avanzados
- ✅ Badges con colores
- ✅ Hover effects en rows
- ✅ Paginación
- ✅ Dark mode en cada tabla

### **4. Navbar Global (Toda la App)**
**Elementos nuevos:**
- ✅ **Truck logo** (bi-truck) en navbar
- ✅ **Admin Panel button** visible (morado→rosa, solo para admins)
- ✅ **Power logout button** (rojo, reemplaza dropdown)
- ✅ Theme toggle (moon/sun)
- ✅ User info (nombre + rol)
- ✅ Mobile menu responsive
- ✅ Footer 4-columnas con social links

### **5. Comparison Page (Requiere Auth)**
**URL:** Accede vía búsqueda en `/search`

**Pasos para ver:**
1. Login (cualquier usuario)
2. Ve a `/search`
3. Selecciona tipo servicio + código postal
4. Haz clic "Buscar Tarifas"
5. Click botón **"Ver Detalles"** en alguna tarifa
6. Se abre modal con detalles
7. Click **botón "Comparar"** (si existe en flow)
8. O accede directamente a `/comparison/{id}` si tienes un ID

**Qué ver:**
- ✅ Cards en lugar de tabla (grid responsive)
- ✅ **Mejor oferta:** Borde verde + badge ⭐
- ✅ Precio destacado grande
- ✅ Diferencia de precio: "+€ más caro" en rojo
- ✅ Info box azul con mejor precio
- ✅ Dark mode optimizado
- ✅ Botón "Guardar comparación" (azul)
- ✅ Section guest con lock icon

---

## 🧪 Testing Rápido - Funcionalidad Original

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
# 📋 EASYMOVE - Comparador de Servicios
## Documentación Técnica Completa del Proyecto

---

## 🏗️ Arquitectura del Stack

### **Backend: Laravel 11 + PHP 8.2+**
- **ORM**: Eloquent (modelos relacionales)
- **Rutas**: RESTful API para AJAX + Inertia.js
- **Autenticación**: Laravel Auth (middleware)
- **Email**: Laravel Mail Facade con SMTP Gmail
- **PDF**: `barryvdh/laravel-dompdf`
- **Base de Datos**: MySQL 8.0+

### **Frontend: React.js + Inertia.js**
- **SSR**: Deshabilitado (SPA puro)
- **Styling**: Tailwind CSS con `darkMode: 'class'`
- **Build Tool**: Vite
- **Componentes**: React Functional Components con Hooks
- **Icons**: Lucide React

### **Base de Datos: MySQL**
- **Entorno Local**: XAMPP (127.0.0.1:3306)
- **Usuario**: root (sin password en desarrollo)
- **Nombre BD**: `easymove`

---

## 📂 Estructura de Carpetas

```
htdocs/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── SearchController.php    # Lógica principal de búsqueda
│   └── Models/
│       ├── User.php                    # Modelo de usuario (Laravel)
│       ├── Tarifa.php                  # Tarifas de servicios
│       ├── Servicio.php                # Servicios (Telefónica, Luz, Gas)
│       ├── TipoServicio.php            # Tipos de servicios
│       ├── Proveedor.php               # Proveedores
│       ├── Ubicacion.php               # Ubicaciones (CP, ciudad, provincia)
│       ├── Disponibilidad.php          # Disponibilidad tarifa-ubicación
│       ├── Comparacion.php             # Registro de comparaciones
│       └── ComparacionTarifa.php       # Tabla pivote (comparación-tarifa)
├── resources/
│   ├── views/
│   │   ├── pdf/
│   │   │   └── comparacion.blade.php   # Vista PDF para descargas
│   │   └── emails/
│   │       └── comparacion.blade.php   # Email con comparativa
│   └── js/
│       ├── components/
│       │   └── Navbar.jsx              # Navbarbarra principal
│       └── pages/
│           └── Home.jsx                # Página de inicio/búsqueda
├── routes/
│   └── web.php                         # Rutas principales
└── database/
    ├── schema.sql                      # Schema SQL completo
    └── migrations/                     # Migraciones de Laravel (opcional)
```

---

## 🔌 Rutas Principales (web.php)

### **Rutas Públicas (sin autenticación)**

#### `GET /`
- **Método**: `SearchController@index()`
- **Descripción**: Renderiza la página Home (SPA)
- **Parámetros**: Ninguno
- **Respuesta**: Inertia Response (React)

#### `POST /search`
- **Método**: `SearchController@search()`
- **Descripción**: Ejecuta búsqueda de tarifas
- **Parámetros (JSON)**:
  ```json
  {
    "codigo_postal": "28001",
    "id_tipo_servicio": 1,
    "ciudad": "Madrid",          // Opcional
    "provincia": "Madrid"        // Opcional
  }
  ```
- **Lógica Crítica**:
  - Si `!Auth::check()` (usuario NO autenticado): devuelve **SOLO 2 mejores resultados** por precio
  - Si `Auth::check()` (usuario autenticado): devuelve **TODOS los resultados**
- **Respuesta (JSON)**:
  ```json
  {
    "success": true,
    "data": {
      "tarifas": [...],
      "comparacion_id": 123,
      "ubicacion": {...},
      "meta": {
        "is_limited": true,
        "total_resultados": 15,
        "resultados_mostrados": 2,
        "is_authenticated": false
      }
    }
  }
  ```

---

### **Rutas Protegidas (`middleware: auth`)**

#### `POST /export-pdf`
- **Método**: `SearchController@exportPdf()`
- **Descripción**: Descarga PDF con comparativa
- **Parámetros (JSON)**:
  ```json
  {
    "comparacion_id": 123
  }
  ```
- **Respuesta**: Archivo PDF descargable
- **Validaciones**: 
  - Usuario debe estar autenticado
  - La comparación debe pertenecerle o ser pública

#### `POST /send-email`
- **Método**: `SearchController@sendEmail()`
- **Descripción**: Envía comparativa por email con PDF adjunto
- **Parámetros (JSON)**:
  ```json
  {
    "comparacion_id": 123,
    "email": "usuario@example.com"
  }
  ```
- **Remitente**: `no-reply@easymove.net`
- **Respuesta (JSON)**:
  ```json
  {
    "success": true,
    "message": "Email enviado correctamente a usuario@example.com"
  }
  ```
- **Validaciones**: 
  - Usuario debe estar autenticado
  - La comparación debe pertenecerle

---

## 🗄️ Modelos Eloquent Relaciones

### **Comparacion** (Modelo Principal)
```php
- belongsTo(User)              // Usuario que realizó la búsqueda (nullable)
- belongsTo(Ubicacion)         // Ubicación de la búsqueda
- belongsTo(TipoServicio)      // Tipo de servicio buscado
- belongsToMany(Tarifa)        // Tarifas resultantes (tabla pivote)
```

### **Tarifa**
```php
- belongsTo(Servicio)          // Servicio que representa
- hasMany(Disponibilidad)      // Ubicaciones donde está disponible
- belongsToMany(Comparacion)   // Comparaciones donde aparece
```

### **Servicio**
```php
- belongsTo(TipoServicio)      // Tipo de servicio
- belongsTo(Proveedor)         // Proveedor del servicio
- hasMany(Tarifa)              // Tarifas disponibles
```

---

## 🎨 Componentes React

### **Navbar.jsx**
**Props:**
- `user` (Object|null): Usuario autenticado
- `onLogout` (Function): Callback para logout

**Features:**
- Logo "EasyMove" con gradiente púrpura
- Switch de modo claro/oscuro (LocalStorage)
- Modal de Login (formulario simple)
- Dropdown de usuario si está autenticado
- Responsive (desktop y mobile)

**Estados:**
- `isDarkMode`: Controla tema oscuro/claro
- `showLoginModal`: Muestra/oculta modal de login
- `isDropdownOpen`: Muestra/oculta dropdown de usuario

### **Home.jsx**
**Props:**
- `user` (Object|null): Usuario autenticado
- `tiposServicios` (Array): Tipos de servicios disponibles

**Features:**
- Formulario de búsqueda (CP + Tipo de Servicio)
- Cards de tarifas con información detallada
- Componente Blur/Lock para usuarios invitados si hay más de 2 resultados
- Botones de descarga PDF y envío email (solo si autenticado)
- Modal de email

**Estados:**
- `codigoPostal`: CP ingresado
- `tipoServicio`: Tipo de servicio seleccionado
- `results`: Resultados de la búsqueda
- `loading`: Indica búsqueda en progreso
- `showEmailModal`: Muestra/oculta modal de email

---

## 🔐 Lógica de Autenticación

### **Usuario NO Autenticado (Guest)**
```
GET / → Navbar sin botón "Iniciar Sesión"
↓
POST /search (CP: 28001, Tipo: Luz)
↓
Response: {
  tarifas: [tarifa1, tarifa2],     // SOLO 2 MEJORES
  meta: {
    is_limited: true,
    total_resultados: 15,
    resultados_mostrados: 2
  }
}
↓
UI: Muestra 2 tarifas + Banner con "Regístrate para ver 15 más"
↓
Botones PDF/Email: DESHABILITADOS
```

### **Usuario Autenticado (Logged In)**
```
GET / → Navbar con dropdown de usuario
↓
POST /search (CP: 28001, Tipo: Luz)
↓
Response: {
  tarifas: [tarifa1, tarifa2, ..., tarifa15],  // TODOS
  meta: {
    is_limited: false,
    total_resultados: 15,
    resultados_mostrados: 15
  }
}
↓
UI: Muestra 15 tarifas sin blur
↓
Botones PDF/Email: HABILITADOS
```

---

## 📧 Configuración de Email

### **.env (SMTP Gmail)**
```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password_here    # NO contraseña de Gmail, sino App Password
MAIL_FROM_ADDRESS=no-reply@easymove.net
MAIL_FROM_NAME="EasyMove"
```

### **Obtener App Password Gmail:**
1. Acceder a https://myaccount.google.com/security
2. Activar "Autenticación en dos pasos"
3. Ir a "Contraseñas de aplicación"
4. Seleccionar "Correo" y "Windows"
5. Copiar el password generado

### **TODO: GOOGLE_APP_KEY**
Placeholder en `.env`:
```
# TODO: GOOGLE_APP_KEY=your_google_app_password_here
```
Este debe reemplazarse con contraseña real.

---

## 📊 Diagrama de Flujo: Búsqueda

```
┌─────────────────────────┐
│   Usuario accede a /    │
│      (Home.jsx)         │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│  Completa formulario    │
│  CP + Tipo Servicio     │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│   POST /search          │
│   (SearchController)    │
└───────────┬─────────────┘
            │
            ▼
     ¿Autenticado?
       /        \
      SI        NO
     /            \
    ▼              ▼
  TODOS         take(2)
  resultados    mejores

    │              │
     \            /
      ▼          ▼
  Crear Comparacion + ComparacionTarifa
           │
           ▼
    Response JSON
           │
           ▼
  Renderizar Cards
           │
           ▼
     ¿NO autenticado?
             │
    YES      │      NO
     │       │       │
     ▼       │       ▼
  Blur    Normal  Habilitar
  Lock    View    PDF/Email
```

---

## 🚀 Instalación y Configuración

### **1. Clonar e Instalar**
```bash
# Instalar dependencias PHP
composer install

# Instalar dependencias Node
npm install
```

### **2. Configurar Base de Datos**

#### **Opción A: Importar schema.sql directamente**
```bash
# En XAMPP MySQL (phpMyAdmin)
1. Crear base de datos: CREATE DATABASE easymove;
2. Importar archivo: database/schema.sql
```

#### **Opción B: Usar migraciones Laravel**
```bash
php artisan migrate
```

### **3. Generar APP_KEY**
```bash
php artisan key:generate
```

### **4. Instalar paquete DomPDF**
```bash
composer require barryvdh/laravel-dompdf
```

### **5. Configurar .env**
```dotenv
DB_HOST=127.0.0.1
DB_USERNAME=root
DB_PASSWORD=
DB_DATABASE=easymove

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

### **6. Compilar assets Frontend**
```bash
npm run dev      # Desarrollo (watch mode)
npm run build    # Producción
```

### **7. Iniciar servidor Laravel**
```bash
php artisan serve
# Accede a http://localhost:8000
```

---

## 🎯 Endpoints Resumen

| Método | Ruta | Autenticación | Descripción |
|--------|------|---------------|-------------|
| GET | `/` | No | Home (SPA) |
| POST | `/search` | No | Buscar tarifas |
| POST | `/export-pdf` | Sí | Descargar PDF |
| POST | `/send-email` | Sí | Enviar email |

---

## 🧪 Testing Manual

### **Caso 1: Usuario No Autenticado**
```bash
# Terminal 1: Iniciar servidor
php artisan serve

# Terminal 2: Hacer petición
curl -X POST http://localhost:8000/search \
  -H "Content-Type: application/json" \
  -d '{"codigo_postal":"28001","id_tipo_servicio":1}'

# Resultado esperado: 2 tarifas (limitadas)
```

### **Caso 2: Usuario Autenticado**
```bash
# Loguéarse primero en la UI
# Luego hacer misma petición
# Resultado esperado: TODAS las tarifas
```

---

## 📝 Notas Importantes

1. **Tailwind Dark Mode**: Configurado en `tailwind.config.js` con `darkMode: 'class'`
2. **CSRF Token**: Incluido en todas las peticiones POST desde React
3. **Inertia.js**: Permite compartir props entre Laravel y React sin API REST
4. **PDF**: Generado dinámicamente usando Blade + DomPDF
5. **Email**: Usa Laravel Mail Facade con vista Blade HTML

---

## 🔗 Referencias

- **Laravel 11 Docs**: https://laravel.com/docs/11.x
- **Inertia.js**: https://inertiajs.com
- **React Docs**: https://react.dev
- **Tailwind CSS**: https://tailwindcss.com
- **DomPDF**: https://github.com/barryvdh/laravel-dompdf

---

**Última actualización**: Abril 2026 (UI/UX Redesign Complete)
**Versión**: 1.1.0
**Estado**: ✅ Producción lista - Rediseño UI/UX completado

---

## 📝 Cambios Técnicos (Abril 2026)

### Archivos Modificados

| Archivo | Cambio | Tipo |
|---------|--------|------|
| `resources/views/welcome.blade.php` | Landing page SaaS | UI |
| `resources/views/admin/dashboard.blade.php` | KPI cards + charts | UI |
| `resources/views/admin/providers/index.blade.php` | Tabla azul gradient | UI |
| `resources/views/admin/services/index.blade.php` | Tabla morado gradient | UI |
| `resources/views/admin/tariffs/index.blade.php` | Tabla rosa gradient | UI |
| `resources/views/admin/locations/index.blade.php` | Tabla esmeralda gradient | UI |
| `resources/views/admin/users/index.blade.php` | Tabla naranja gradient | UI |
| `resources/views/layouts/app.blade.php` | Navbar+footer redesign | UI |
| `resources/views/comparison.blade.php` | Card layout + highlights | UI |

### Dependencias Nuevas: NINGUNA ✅
- Todo usa Tailwind CSS (ya compilado)
- Bootstrap Icons (bi-truck, bi-power, bi-bookmark)
- Sin cambios en composer.json
- Sin cambios en package.json

### CSS Compilado
```
Antes:  57.59 kB (gzip: 8.89 kB)
Ahora:  60.10 kB (gzip: 9.18 kB)
Delta:  +2.51 kB (aceptable para nuevo diseño)
Build:  3.62 segundos ✅
```

### Características de Diseño
- ✅ Gradientes azul→morado (brand consistency)
- ✅ Dark mode 100% (dark:bg-gray-, dark:text-, etc.)
- ✅ Responsive (sm:, md:, lg: breakpoints)
- ✅ Card-based layouts
- ✅ Hover effects (shadow, scale, color)
- ✅ Badges con colores contextuales
- ✅ Icons de Bootstrap (bi-truck, bi-power, etc.)

### Testing Requerido POST-DEPLOY
- [ ] Responsive en móvil (320px-768px)
- [ ] Responsive en tablet (768px-1024px)
- [ ] Responsive en desktop (1024px+)
- [ ] Dark mode toggle funciona
- [ ] Admin panel visible solo para admins
- [ ] Power logout button funciona
- [ ] Comparison cards alinean bien
- [ ] Tablas admin cargan correctamente
- [ ] Landing page loads en <3s
- [ ] CSS compiled y minified (no 404s)

### Performance Notes
- CSS build time sigue siendo <5s
- Tailwind purge funciona correctamente
- No hay clase no-utilizadas en HTML
- File size increase minimal (+2.5KB)
- Zero breaking changes en funcionalidad

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

**Última actualización**: 20/04/2026 - UI/UX Redesign Complete ✨
**Versión**: 1.1.0
**Status**: Producción - Listo para deploy
