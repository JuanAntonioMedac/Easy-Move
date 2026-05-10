# Guía de Despliegue en Railway - Easy-Move

## 📋 Requisitos Previos

- Cuenta en [Railway](https://railway.app)
- Git instalado y repositorio en GitHub conectado
- Variables de entorno configuradas

## 🚀 Pasos de Despliegue

### 1. **Preparación del Repositorio**

Asegúrate de que todos los cambios estén committed:

```bash
git add .
git commit -m "Preparar para despliegue en Railway"
git push origin main
```

### 2. **Crear un Nuevo Proyecto en Railway**

1. Ve a [Railway.app](https://railway.app)
2. Click en "New Project"
3. Selecciona "Deploy from GitHub repo"
4. Autoriza a Railway a acceder a tu GitHub
5. Selecciona el repositorio `Easy-Move`
6. Configura el branch a `main`

### 3. **Configurar Base de Datos MySQL**

1. En el dashboard del proyecto en Railway
2. Click en "Add Service" → "Add from Marketplace"
3. Busca y selecciona **MySQL**
4. Railway creará automáticamente la instancia

**Las variables de conexión se agregarán automáticamente como:**
- `DATABASE_URL`
- `DB_HOST`
- `DB_PORT`
- `DB_USERNAME`
- `DB_PASSWORD`
- `DB_DATABASE`

### 4. **Configurar Variables de Entorno**

En el dashboard de Railway, ve a la sección "Variables" y agrega:

#### Variables Requeridas:
```
APP_NAME=Easy-Move
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:TU_CLAVE_AQUI (generada localmente con php artisan key:generate)
APP_URL=https://tu-dominio-railway.up.railway.app
APP_TIMEZONE=UTC
APP_LOCALE=es
APP_FALLBACK_LOCALE=es

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
CACHE_STORE=file
FILESYSTEM_DISK=local
```

#### Generar APP_KEY (local):
```bash
php artisan key:generate --show
```
Copia el valor (incluyendo `base64:`) y pégalo en `APP_KEY` en Railway.

### 5. **Configurar el Servidor PHP**

Railway usa automáticamente PHP 8.2+ (compatible con Laravel 11).

### 6. **Despliegue Automático**

Una vez que subas cambios a `main`, Railway hará automáticamente:

1. ✅ Construir: `composer install --no-dev && npm install && npm run build`
2. ✅ Migrar: `php artisan migrate --force`
3. ✅ Desplegar a producción

### 7. **Verificar el Despliegue**

1. Ve a la sección "Deployments" en Railway
2. Espera a que el build se complete (suele tomar 3-5 minutos)
3. Una vez completado, verás la URL pública asignada
4. Actualiza `APP_URL` en variables si es necesario

---

## ⚠️ Checklist de Requisitos Faltantes

Tu proyecto necesita verificación en estos puntos:

### Críticos (Debe resolver):
- [ ] **Procfile** - ✅ Ya creado
- [ ] **APP_KEY** - ⚠️ Debe generarse y configurarse en Railway
- [ ] **DATABASE_URL** - ✅ Railway lo proporciona automáticamente
- [ ] **Node build** - ✅ `npm run build` está configurado

### Recomendados:
- [ ] **Storage público** - Si subes archivos, usar `php artisan storage:link`
- [ ] **Colas (Queues)** - Actualmente está en `sync`, cambiar a `redis` si necesitas colas asincrónicas
- [ ] **Redis** - Opcional, solo si necesitas caché o colas avanzadas
- [ ] **Dominio personalizado** - Configurar en Railway después del despliegue
- [ ] **SSL** - Railway lo proporciona automáticamente

---

## 🔧 Problemas Comunes y Soluciones

### Error: "Procfile no encontrado"
**Solución:** Asegúrate de que `Procfile` esté en la raíz del proyecto (sin extensión).

### Error: "DATABASE_URL not set"
**Solución:** Crea una instancia MySQL desde Marketplace en Railway.

### Error: "Compilation failed"
**Solución:** Verifica que `npm run build` funcione localmente:
```bash
npm install
npm run build
```

### Error: "Permission denied on storage/"
**Solución:** En Railway, usa almacenamiento en memoria o cloud storage.

### Error: "Mail not sending"
**Solución:** Configura un servicio de email (SendGrid, Mailgun, etc.) y actualiza:
```
MAIL_MAILER=sendgrid
MAIL_FROM_ADDRESS=noreply@easymove.app
SENDGRID_API_KEY=tu_clave_aqui
```

---

## 📊 Monitoreo y Logs

Para ver los logs de tu aplicación:

1. En Railway Dashboard → Tu Proyecto → "Logs"
2. O usa el CLI de Railway:

```bash
npm install -g @railway/cli
railway login
railway logs
```

---

## 🔐 Consideraciones de Seguridad

1. **Nunca** comits archivos `.env` con valores reales
2. **APP_DEBUG=false** en producción (ya configurado)
3. Usa variables de entorno para credenciales
4. Habilita HTTPS (Railway lo hace automáticamente)
5. Configura CORS si tienes frontend separado

---

## 📝 Próximos Pasos Después del Despliegue

1. **Prueba inicial**: Accede a tu URL y verifica que funciona
2. **Base de datos**: Ejecuta migraciones si es primera vez
3. **Archivos estáticos**: Verifica que CSS, JS y imágenes se carguen
4. **Emails**: Prueba funcionalidad de envío si existe
5. **Colas**: Si usas jobs, configura apropiadamente

---

## 📞 Contacto y Soporte

- [Documentación de Railway](https://docs.railway.app)
- [Documentación de Laravel](https://laravel.com/docs)
- [Railway CLI Docs](https://docs.railway.app/guides/cli)

