# 🚀 Script de Deploy para cPanel - Easy-Move

## ⚡ Uso Rápido

### **Paso 1: Ejecutar el Script**

En tu PC, en la carpeta del proyecto:

```bash
# Doble clic en:
build-cpanel.bat

# O desde CMD:
cd C:\xampp\htdocs\Easy-Move
build-cpanel.bat
```

### **Paso 2: Esperar a que termine**

- El script compila todo automáticamente
- Genera el archivo `Easy-Move-Production.zip` (~80-120 MB)
- Crea un archivo `INSTRUCCIONES_CPANEL.txt` dentro del ZIP

### **Paso 3: Subir a cPanel**

1. Abre el **File Manager** en tu cPanel
2. Navega a `/public_html/`
3. Sube el archivo `Easy-Move-Production.zip`
4. Click derecho → **Extract**
5. Lee `INSTRUCCIONES_CPANEL.txt`

---

## 📦 ¿Qué Incluye el ZIP?

```
Easy-Move-Production.zip
├── app/                    ✅ Código PHP
├── bootstrap/              ✅ Bootstrap Laravel
├── config/                 ✅ Configuración
├── database/               ✅ Schema SQL
├── public/                 ✅ CSS/JS compilados
├── resources/              ✅ Vistas Blade
├── routes/                 ✅ Rutas
├── storage/                ✅ Logs y archivos
├── vendor/                 ✅ Dependencias PHP (compiladas)
├── .env.example            ✅ Plantilla de configuración
├── artisan                 ✅ CLI de Laravel
├── composer.json           ✅ Dependencias PHP
├── package.json            ✅ Dependencias JS
├── vite.config.js          ✅ Build tool config
├── tailwind.config.js      ✅ CSS config
├── INSTRUCCIONES_CPANEL.txt ✅ Guía de instalación
└── README.md               ✅ Documentación
```

### **Excluido (por razones)**

```
❌ node_modules/      → Se descarga con npm (innecesario en ZIP)
❌ .env               → Archivo sensible (creas en cPanel)
❌ .git/              → Control de versiones (no necesario)
❌ tests/             → Tests de desarrollo
❌ .vscode/           → Configuración de editor
```

---

## 🛠️ Características del Script

| Característica | Descripción |
|---|---|
| **Robusto** | Valida que el proyecto exista antes de empezar |
| **Seguro** | Excluye `.env` y archivos sensibles |
| **Rápido** | Usa 7-Zip si está disponible, sino PowerShell |
| **Informativo** | Muestra colores y barras de progreso |
| **Completo** | Incluye guía de instalación en el ZIP |
| **Inteligente** | Genera timestamp de backup |

---

## 📋 Requisitos Previos

Antes de ejecutar el script, asegúrate de:

```bash
# 1. Compilar dependencias de Node
npm install
npm run build

# 2. Instalar dependencias de PHP
composer install

# 3. Estar en la raíz del proyecto
cd C:\xampp\htdocs\Easy-Move
```

---

## ⚙️ Cómo Funciona Internamente

### **Fase 1: Validación**
- Verifica que `composer.json` existe
- Detecta Node.js instalado
- Valida la estructura del proyecto

### **Fase 2: Preparación**
- Crea carpeta temporal `Easy-Move-Production`
- Copia todas las carpetas necesarias
- Copia archivos de configuración

### **Fase 3: Seguridad**
- Elimina `.env` (por seguridad)
- Elimina `.git/` (no es necesario)
- Elimina `node_modules/` (se puede recompilar)
- Elimina `tests/` (solo para desarrollo)

### **Fase 4: Documentación**
- Genera `INSTRUCCIONES_CPANEL.txt`
- Incluye credenciales y pasos de instalación
- Proporciona solución de problemas

### **Fase 5: Compresión**
- Intenta con 7-Zip (mejor compresión)
- Si no funciona, usa PowerShell
- Elimina carpeta temporal

### **Fase 6: Resultado**
- Genera `Easy-Move-Production.zip`
- Muestra información de tamaño
- Da instrucciones siguientes

---

## 🔍 Solucionar Problemas

### **El script no encuentra 7-Zip**
**Solución:** Se usa PowerShell automáticamente (más lento pero funciona)

```bash
# Opcional: Instala 7-Zip para mejor compresión
https://www.7-zip.org/download.html
```

### **El ZIP pesa mucho (>150 MB)**
**Solución:** Es normal. Incluye vendor/ compilado.
- `vendor/` = ~80-100 MB
- `public/build/` = ~5-10 MB
- Resto = ~20-30 MB

### **"Este script debe ejecutarse desde la raíz del proyecto"**
**Solución:** Asegúrate de estar en la carpeta correcta

```bash
cd C:\xampp\htdocs\Easy-Move
build-cpanel.bat
```

---

## 🚀 Flujo Completo

```
1. En tu PC
   └─ build-cpanel.bat (doble clic)
       └─ Genera Easy-Move-Production.zip
       
2. Subes a cPanel
   └─ File Manager > Upload > Easy-Move-Production.zip
   
3. Extraes en cPanel
   └─ Click derecho > Extract
   
4. Configuras en cPanel
   ├─ Crear BD MySQL
   ├─ Importar schema.sql
   ├─ Editar .env
   └─ Dar permisos (chmod 755)
   
5. ¡Listo!
   └─ Accede a https://tudominio.com
```

---

## 📞 Soporte

Si hay problemas:

1. **Revisa `INSTRUCCIONES_CPANEL.txt`** (está en el ZIP)
2. **Lee `DOCUMENTACION_TECNICA.md`** (en el proyecto)
3. **Verifica credenciales de BD** en `.env`
4. **Comprueba permisos** de `storage/` y `bootstrap/cache`

---

## ✅ Checklist Después de Deploy

- [ ] ZIP extraído en cPanel
- [ ] `.env` creado (copy de `.env.example`)
- [ ] Base de datos creada en cPanel
- [ ] `schema.sql` importado en phpMyAdmin
- [ ] Credenciales en `.env` (DB, SMTP, APP_URL)
- [ ] Permisos: `chmod 755 storage bootstrap/cache`
- [ ] Acceso a `https://tudominio.com` funciona
- [ ] Landing page carga correctamente
- [ ] Email SMTP configurado (opcional)

---

**Versión:** 1.0  
**Compatibilidad:** Windows 7+, PHP 8.2+, Laravel 11  
**Última actualización:** Abril 2026
