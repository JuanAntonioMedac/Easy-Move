# Configuración de Railway

## 🔐 Estructura de Archivos de Entorno

```
.env              → NO se sube a GitHub (en .gitignore) - Para desarrollo local
.env.example      → Se sube a GitHub - Plantilla para nuevos desarrolladores
.env.prod         → NO se sube a GitHub - Referencia de variables para Railway
```

## 📋 En Tu Máquina (Desarrollo Local)

Copia `.env.example` a `.env` y configura:
```bash
cp .env.example .env
```

Edita `.env` con tus credenciales locales:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=easymove
DB_USERNAME=root
DB_PASSWORD=
```

## 🚀 En Railway (Producción)

**Las variables de entorno NO se ponen en archivos `.env`**, se configuran en el dashboard de Railway:

1. Ve a tu proyecto en Railway
2. Click en **"Variables"**
3. Agrega estas variables:

### Variables Básicas
```
APP_NAME=Easy-Move
APP_ENV=production
APP_KEY=base64:NWd4bmR6ODBqaHF2cWI5d210anR6dmxmZHhwdjc1bGY=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://tu-dominio-en-railway.up.railway.app
```

### Variables de MySQL

Railway proporciona automáticamente estas variables cuando agregas MySQL:

```
MYSQL_DATABASE=railway
MYSQLUSER=root
MYSQLHOST=${RAILWAY_PRIVATE_DOMAIN}
MYSQLPORT=3306
MYSQLPASSWORD=${MYSQL_ROOT_PASSWORD}
MYSQL_ROOT_PASSWORD=tOpKPcpUdwxnGkokTQzxvrgCnhghxzIj
```

Ahora agrega estas variables a tu proyecto (mapea Railway → Easy-Move):

```
DB_CONNECTION=mysql
DB_HOST=${RAILWAY_PRIVATE_DOMAIN}
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=${MYSQL_ROOT_PASSWORD}
```

### Variables de Aplicación
```
LOG_CHANNEL=stack
LOG_LEVEL=debug
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
CACHE_STORE=file
FILESYSTEM_DISK=local
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@easymove.app
MAIL_FROM_NAME=Easy-Move
BROADCAST_CONNECTION=log
```

## 🔄 Despliegue en Railway

### Procesos Automáticos

El `Procfile` define:
- **release**: Ejecuta migraciones antes de iniciar
- **web**: Inicia el servidor PHP

```
web: php -S 0.0.0.0:${PORT:-8000} -t public/
release: php artisan migrate --force
```

### Verificación Post-Deploy

En los logs de Railway deberías ver:
```
✓ Running migrations...
✓ Migrating: 2026_04_20_000001_...
✓ Migrated successfully
✓ [info] Server listening on 0.0.0.0:8000
```

## ⚠️ Problemas Comunes

### Error: "SQLiteDatabaseDoesNotExistException"
**Causa**: Las variables de MySQL no se están cargando
**Solución**: Verifica que `DB_HOST` y `DB_PASSWORD` sean correctas en Railway variables

### Error: "SQLSTATE[HY000] [2002] Connection refused"
**Causa**: MySQL no está agregado a tu proyecto
**Solución**: En Railway → "Add Service" → "MySQL" (Marketplace)

### Migraciones no ejecutan
**Causa**: El Procfile podría estar mal
**Solución**: Verifica que el Procfile tenga el comando `release: php artisan migrate --force`

## 📝 Referencias
- [.env.example](.env.example) - Plantilla para desarrollo
- [.env.prod](.env.prod) - Referencia de variables para Railway
- [Procfile](Procfile) - Configuración de procesos
