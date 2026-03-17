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

**Última actualización**: Febrero 2026
**Versión**: 1.0.0
**Estado**: Desarrollo completo listo para implementación
