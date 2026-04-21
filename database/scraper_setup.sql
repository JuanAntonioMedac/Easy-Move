-- ================================================================
-- MEJORAS PARA SCRAPER n8n - EXTRACCIÓN DE LOGOS
-- ================================================================
-- Ejecuta este script para preparar la BD para recibir logos del scraper

-- 1. Verificar/Crear tabla ofertas_scraping
CREATE TABLE IF NOT EXISTS ofertas_scraping (
  id INT AUTO_INCREMENT PRIMARY KEY,
  company VARCHAR(100) NOT NULL,
  postalCode VARCHAR(10) NOT NULL,
  nombre_tarifa VARCHAR(255),
  precio DECIMAL(10, 2),
  permanencia VARCHAR(100),
  condiciones TEXT,
  url_oferta VARCHAR(500),
  proveedor_nombre VARCHAR(100),
  proveedor_web VARCHAR(255),
  logo_url VARCHAR(500),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  INDEX idx_company (company),
  INDEX idx_postalCode (postalCode),
  INDEX idx_proveedor (proveedor_nombre),
  UNIQUE KEY unique_oferta (company, postalCode, nombre_tarifa)
);

-- 2. Agregar columnas si no existen (para BDs existentes)
ALTER TABLE ofertas_scraping
ADD COLUMN IF NOT EXISTS proveedor_nombre VARCHAR(100) AFTER url_oferta,
ADD COLUMN IF NOT EXISTS proveedor_web VARCHAR(255) AFTER proveedor_nombre,
ADD COLUMN IF NOT EXISTS logo_url VARCHAR(500) AFTER proveedor_web;

-- 3. Mejorar tabla proveedores para soportar logos por URL
-- (Ya está soportado en el modelo PHP, pero documentamos)
ALTER TABLE proveedores
MODIFY COLUMN logo VARCHAR(500) COMMENT 'URL completa (https://) o ruta local (proveedores/archivo.png)';

-- 4. Crear vista para vincular ofertas_scraping con proveedores existentes
CREATE OR REPLACE VIEW v_ofertas_con_proveedores AS
SELECT
  os.id,
  os.company,
  os.postalCode,
  os.nombre_tarifa,
  os.precio,
  os.permanencia,
  os.condiciones,
  os.url_oferta,
  os.proveedor_nombre,
  os.proveedor_web,
  os.logo_url,
  p.id_proveedor,
  p.nombre AS proveedor_bd_nombre,
  p.logo AS proveedor_bd_logo,
  CASE
    WHEN p.id_proveedor IS NOT NULL THEN 'Vinculado'
    ELSE 'Pendiente'
  END AS estado_vinculacion,
  os.created_at
FROM ofertas_scraping os
LEFT JOIN proveedores p ON LOWER(os.proveedor_nombre) = LOWER(p.nombre);

-- 5. Crear tabla de sincronización (opcional pero recomendado)
CREATE TABLE IF NOT EXISTS scraper_sync_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fecha_ejecucion DATETIME NOT NULL,
  total_tareas INT,
  tareas_exitosas INT,
  tareas_fallidas INT,
  errores TEXT,
  estado ENUM('success', 'partial', 'failed') DEFAULT 'success',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_fecha (fecha_ejecucion)
);

-- 6. Consultas útiles para validación

-- Ver todas las ofertas con su estado de vinculación
-- SELECT * FROM v_ofertas_con_proveedores
-- WHERE estado_vinculacion = 'Pendiente';

-- Ver logos que están por URL
-- SELECT DISTINCT proveedor_nombre, logo_url
-- FROM ofertas_scraping
-- WHERE logo_url LIKE 'https://%'
-- ORDER BY proveedor_nombre;

-- Ver logos que fallaron (URLs inválidas)
-- SELECT * FROM ofertas_scraping
-- WHERE logo_url IS NULL OR logo_url = '';

-- 7. Procedure para importar ofertas_scraping a proveedores automáticamente
DELIMITER $$

CREATE PROCEDURE IF NOT EXISTS sp_sync_proveedores_desde_scraper()
BEGIN
  DECLARE done INT DEFAULT FALSE;
  DECLARE v_nombre VARCHAR(255);
  DECLARE v_web VARCHAR(255);
  DECLARE v_logo VARCHAR(500);

  DECLARE cursor_proveedores CURSOR FOR
  SELECT DISTINCT proveedor_nombre, proveedor_web, logo_url
  FROM ofertas_scraping
  WHERE proveedor_nombre IS NOT NULL
  AND proveedor_nombre NOT IN (SELECT nombre FROM proveedores);

  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  OPEN cursor_proveedores;

  read_loop: LOOP
    FETCH cursor_proveedores INTO v_nombre, v_web, v_logo;
    IF done THEN
      LEAVE read_loop;
    END IF;

    -- Insertar nuevo proveedor si no existe
    INSERT IGNORE INTO proveedores (nombre, web, logo, tipo_proveedor, api_disponible)
    VALUES (v_nombre, v_web, v_logo, 'mixto', FALSE);

  END LOOP;

  CLOSE cursor_proveedores;
END$$

DELIMITER ;

-- 8. Llamar el procedure después de cada scraper (opcional)
-- CALL sp_sync_proveedores_desde_scraper();

-- 9. Estadísticas finales
SELECT
  'Tabla ofertas_scraping' as `Entidad`,
  COUNT(*) as `Registros`,
  COUNT(DISTINCT company) as `Proveedores únicos`,
  COUNT(DISTINCT postalCode) as `CP únicos`,
  ROUND(AVG(precio), 2) as `Precio promedio`,
  COUNT(CASE WHEN logo_url LIKE 'https://%' THEN 1 END) as `Logos por URL`,
  COUNT(CASE WHEN logo_url IS NULL THEN 1 END) as `Sin logo`
FROM ofertas_scraping;

-- 10. Limpiar datos antiguos (opcional - ejecutar 1x por semana)
-- DELETE FROM ofertas_scraping WHERE created_at < DATE_SUB(NOW(), INTERVAL 30 DAY);

-- ================================================================
-- FIN DE SCRIPT
-- ================================================================
-- Notas:
-- - Ejecuta este script en phpmyadmin o desde terminal:
--   mysql -u root -p nombre_bd < scraper_setup.sql
--
-- - Los logos se almacenan como URLs completas:
--   Ejemplo: https://www.endesa.com/etc/designs/logo.svg
--
-- - El campo 'estado_vinculacion' en v_ofertas_con_proveedores
--   indica si el proveedor ya existe en la BD principal
--
-- - Usa sp_sync_proveedores_desde_scraper() para importar
--   automáticamente nuevos proveedores desde ofertas_scraping
-- ================================================================
