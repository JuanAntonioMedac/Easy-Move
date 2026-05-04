# 🚀 Scripts de Deploy para cPanel - Easy-Move

## ⚡ Uso Rápido

### **Script 1: `build-cpanel-complete.bat` ⭐ RECOMENDADO**

```bash
Doble clic en: build-cpanel-complete.bat
```

**✨ Características**:
- ✅ Compila automáticamente (`npm run build`)
- ✅ Empaqueta automáticamente
- ✅ **Respeta `.gitignore`** - Excluye TODAS las variables de entorno
- ✅ NO incluye `node_modules` (compilado en `public/build`)
- ✅ Archivo muy pequeño (~45-60 MB)
- ✅ 100% seguro - sin secretos incluidos
- ✅ 9 pasos visuales con colores

**Cuándo usar**: **SIEMPRE** (es la forma correcta)

---

### **Script 2: `build-cpanel-simple.bat` (OPCIONAL - MANUAL)**

```bash
# Primero compilar:
npm run build

# Luego ejecutar:
Doble clic en: build-cpanel-simple.bat
```

**⚙️ Características**:
- ✅ Requiere compilación manual previa
- ✅ También respeta `.gitignore`
- ✅ Exluye variables de entorno
- ✅ Más rápido (no compila)
- ✅ 8 pasos visuales

**Cuándo usar**: Solo si ya compilaste y quieres empaquetar rápido

---

## 🔒 Seguridad - ¿Qué NO se incluye?

### **Automáticamente Excluido por `.gitignore`**:

| Archivo/Carpeta | Por qué |
|---|---|
| `.env` | ⚠️ **Contraseñas y claves API** |
| `.env.backup` | ⚠️ **Backup con credenciales** |
| `.env.production` | ⚠️ **Env de producción** |
| `.env.local` | ⚠️ **Env local** |
| `node_modules/` | ✅ Se compilan en `public/build` |
| `.git/` | ✅ No necesario en producción |
| `tests/` | ✅ Solo para desarrollo |
| `storage/pail/` | ✅ Logs de dev |
| `storage/*.key` | ⚠️ **Claves de encriptación** |
| `public/hot/` | ✅ Vite dev server |
| `.gitignore` | ✅ No necesario |
| `.vscode/`, `.idea/` | ✅ Configuración de editor |

### **Automáticamente Incluido**:

```
✅ app/                     ← Código PHP
✅ config/                  ← Configuración
✅ database/                ← Schema SQL
✅ vendor/                  ← Dependencias PHP (compiladas)
✅ public/build/            ← CSS/JS compilados (Vite)
✅ storage/app/             ← Almacenamiento de usuarios
✅ storage/logs/            ← Archivos de log
✅ routes/                  ← Rutas de la app
✅ resources/               ← Vistas Blade
✅ .env.example             ← PLANTILLA para crear .env
✅ artisan, composer.json   ← Archivos necesarios
```

---

## 📦 Tamaño y Seguridad

| Métrica | Valor |
|---------|-------|
| **ZIP respetando `.gitignore`** | ~45-60 MB |
| **ZIP sin respetar .gitignore** | ~120-150 MB |
| **Reducción de tamaño** | **60% más pequeño** |
| **Archivos sensibles incluidos** | **0** ❌ Exluidos |
| **Secretos en el ZIP** | **NINGUNO** ✅ |

### ¿Por qué es más pequeño?

```
ANTES (Sin .gitignore):
  node_modules/    ~300 MB  ← ¡ENORME! (innecesario)
  .env files       ~5 KB    ← Sensible
  .git/            ~50 MB   ← No necesario
  tests/           ~10 MB   ← Solo dev
  ────────────────────────────
  Total            ~120 MB

AHORA (Respeta .gitignore):
  vendor/          ~80 MB   ← Compilado, necesario
  public/build/    ~5 MB    ← Assets compilados
  app, config...   ~20 MB   ← Código
  database/        ~2 MB    ← Schema SQL
  ────────────────────────────
  Total            ~45 MB   (60% menor)
```

---

## 🎯 Paso a Paso - Deploy Completo

### **PASO 1: Ejecutar Script en tu PC**

```bash
# Opción A - Automático (recomendado):
build-cpanel-complete.bat
# Espera 5-10 minutos

# Opción B - Manual (si ya compilaste):
npm run build
build-cpanel-simple.bat
# Espera 2-3 minutos
```

**Resultado**: `Easy-Move-Production.zip`

---

### **PASO 2: Subir a cPanel**

1. Abre: `cPanel` → **File Manager**
2. Navega a: `/public_html/`
3. Haz clic en: **Upload**
4. Selecciona: `Easy-Move-Production.zip`
5. Espera a que termine

---

### **PASO 3: Extraer ZIP**

1. Click derecho en: `Easy-Move-Production.zip`
2. Selecciona: **Extract**
3. Destino: `/public_html/` (dejar por defecto)
4. Click: **Extract File(s)**

---

### **PASO 4: Crear Base de Datos**

En cPanel:

1. **MySQL Databases**
2. Crea nueva BD:
   - **Database Name**: `usuario_bd` (ej: miproyecto_bd)
   - Click: **Create Database**

3. Crea usuario:
   - **MySQL Users** → **Add New User**
   - **Username**: `usuario_bd` (ej: miproyecto_u)
   - **Password**: (fuerte, 20+ caracteres)
   - Click: **Create User**

4. Asigna privilegios:
   - **Add User to Database**
   - Usuario: `usuario_bd`
   - BD: `usuario_bd`
   - **Privilegios**: ☑️ ALL PRIVILEGES
   - Click: **Make Changes**

---

### **PASO 5: Importar Schema SQL**

En cPanel → **phpMyAdmin**:

1. Selecciona BD: `usuario_bd`
2. Click en tab: **Import**
3. Click: **Choose File**
4. Selecciona: `database/schema.sql`
5. Click: **Go**

(Espera a que muestre "X queries executed successfully")

---

### **PASO 6: Crear y Editar `.env`**

En cPanel → **File Manager** → `/public_html/Easy-Move-Production/`:

1. Click derecho en: `.env.example`
2. **Copy**
3. Click derecho en espacio vacío
4. **Paste as**
5. Renombra a: `.env`

---

**Editar `.env`** (click derecho → **Edit** o abrir con editor):

```env
APP_NAME=Easy-Move
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

DB_HOST=localhost
DB_DATABASE=usuario_bd
DB_USERNAME=usuario_bd
DB_PASSWORD=tu_password_fuerte

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_FROM_ADDRESS=noreply@tudominio.com
```

---

### **PASO 7: Configurar Permisos** (Si tienes SSH)

```bash
chmod 775 storage bootstrap/cache
chmod 644 public/index.php
```

---

### **PASO 8: Verificar**

Abre en navegador: `https://tudominio.com`

✅ Debe cargar correctamente  
✅ CSS y JS deben verse  
✅ La página no debe estar "sin estilo"

---

## 🚨 Troubleshooting

### **Problema: "Sin estilo" (todo en texto)**

**Síntomas**: Página carga pero sin colores, sin formato, texto enorme

**Soluciones** (en orden):

```
1. Verificar que existe:
   public/build/manifest.json
   public/build/assets/app-*.js
   public/build/assets/app-*.css

2. Editar .env:
   APP_URL=https://tudominio.com
   (Debe ser EXACTO, con https://)

3. Si tienes SSH, ejecutar:
   php artisan config:clear
   
4. Refresca navegador (Ctrl+F5)
```

---

### **Problema: Error de conexión a Base de Datos**

**Síntomas**: "SQLSTATE[HY000]: General error"

**Soluciones**:

```
1. Verificar credenciales en .env:
   - DB_DATABASE correcto
   - DB_USERNAME correcto
   - DB_PASSWORD correcto

2. En phpMyAdmin:
   - Verifica que BD existe
   - Verifica que usuario tiene privilegios
   
3. Ejecutar en SSH (si tienes):
   php artisan migrate --force
```

---

### **Problema: "El archivo ZIP pesa mucho"**

**Normal**: El ZIP pesa 45-60 MB, es correcto

**Incluye**: vendor/ (~80 MB descomprimido, ~40 comprimido)

---

### **Problema: El script no compila**

**Solución**:

```bash
# 1. Instalar dependencias
npm install

# 2. Compilar manualmente
npm run build

# 3. Ejecutar script simple
build-cpanel-simple.bat
```

---

## 📋 Checklist Final

```
ANTES de ejecutar script:
☐ npm install (si es primera vez)
☐ npm run build (para complete) o manual (para simple)
☐ Estoy en C:\xampp\htdocs\Easy-Move

DURANTE:
☐ Script muestra progreso colorido
☐ Script termina con "✓ BUILD COMPLETADO"

DESPUÉS de script:
☐ Existe Easy-Move-Production.zip (~45-60 MB)
☐ Subo a cPanel
☐ Extraigo en /public_html

EN CPANEL:
☐ Creo BD MySQL
☐ Creo usuario de BD
☐ Importo database/schema.sql
☐ Copio .env.example a .env
☐ Edito .env con valores reales
☐ Doy permisos: chmod 775 storage
☐ Accedo a https://tudominio.com

VERIFICACIÓN:
☐ Página carga con estilos
☐ CSS y JS se ven bien
☐ No dice "sin estilo"
☐ La BD conecta sin errores
```

---

## 🔐 Notas de Seguridad

✅ **El script respeta `.gitignore` automáticamente**

✅ **Nunca incluye** `.env` real en el ZIP

✅ **Debes crear** `.env` nuevo en cPanel (basado en `.env.example`)

✅ **La contraseña debe ser fuerte** (20+ caracteres, símbolos)

✅ **No subas** `.env` a GitHub **NUNCA**

✅ **Usa Gmail App Password**, no contraseña normal

---

## 📚 Más Información

- [`N8N_EXPORT_GUIDE.md`](N8N_EXPORT_GUIDE.md) - Cómo exportar datos del scraper
- [`SCRAPER_SYNC_GUIDE.md`](SCRAPER_SYNC_GUIDE.md) - Documentación del scraper
- [`README.md`](README.md) - General del proyecto

---

**¡Listo para deploy! 🚀**

Ejecuta `build-cpanel-complete.bat` y en 10 minutos tendrás tu ZIP listo para cPanel.
