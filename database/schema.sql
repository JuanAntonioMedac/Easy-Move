-- ============================================================================
-- EASYMOVE - Schema SQL Completo
-- Base de Datos: MySQL 8.0+
-- Descripción: Sistema de comparación de servicios (Telefonía, Luz, Gas)
-- ============================================================================

-- ============================================================================
-- 1. TABLA: USUARIOS
-- ============================================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    rol ENUM('admin', 'usuario') DEFAULT 'usuario',
    preferencias JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 2. TABLA: UBICACIONES
-- ============================================================================
CREATE TABLE IF NOT EXISTS ubicaciones (
    id_ubicacion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    codigo_postal VARCHAR(10) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    provincia VARCHAR(100) NOT NULL,
    numero INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_ubicacion (codigo_postal, ciudad, provincia, numero),
    INDEX idx_codigo_postal (codigo_postal),
    INDEX idx_ciudad (ciudad)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 3. TABLA: TIPOS_SERVICIOS
-- ============================================================================
CREATE TABLE IF NOT EXISTS tipos_servicios (
    id_tipo_servicio INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 4. TABLA: PROVEEDORES
-- ============================================================================
CREATE TABLE IF NOT EXISTS proveedores (
    id_proveedor INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL UNIQUE,
    web VARCHAR(255),
    logo VARCHAR(255),
    tipo_proveedor ENUM('telefonica', 'luz', 'gas', 'mixto') NOT NULL,
    api_disponible BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nombre (nombre),
    INDEX idx_tipo_proveedor (tipo_proveedor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 5. TABLA: SERVICIOS
-- ============================================================================
CREATE TABLE IF NOT EXISTS servicios (
    id_servicio INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_servicio VARCHAR(255) NOT NULL,
    descripcion TEXT,
    id_tipo_servicio INT UNSIGNED NOT NULL,
    id_proveedor INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tipo_servicio) REFERENCES tipos_servicios(id_tipo_servicio) ON DELETE CASCADE,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor) ON DELETE CASCADE,
    INDEX idx_tipo_servicio (id_tipo_servicio),
    INDEX idx_proveedor (id_proveedor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 6. TABLA: TARIFAS
-- ============================================================================
CREATE TABLE IF NOT EXISTS tarifas (
    id_tarifa INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre_tarifa VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    unidad_precio VARCHAR(50),
    permanencia VARCHAR(100),
    condiciones TEXT,
    url_oferta_externa VARCHAR(255),
    id_servicio INT UNSIGNED NOT NULL,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio) ON DELETE CASCADE,
    INDEX idx_servicio (id_servicio),
    INDEX idx_precio (precio),
    INDEX idx_fecha_actualizacion (fecha_actualizacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 7. TABLA: DISPONIBILIDAD
-- ============================================================================
CREATE TABLE IF NOT EXISTS disponibilidad (
    id_disponibilidad INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_tarifa INT UNSIGNED NOT NULL,
    id_ubicacion INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tarifa) REFERENCES tarifas(id_tarifa) ON DELETE CASCADE,
    FOREIGN KEY (id_ubicacion) REFERENCES ubicaciones(id_ubicacion) ON DELETE CASCADE,
    UNIQUE KEY unique_tarifa_ubicacion (id_tarifa, id_ubicacion),
    INDEX idx_tarifa (id_tarifa),
    INDEX idx_ubicacion (id_ubicacion)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 8. TABLA: COMPARACIONES
-- ============================================================================
CREATE TABLE IF NOT EXISTS comparaciones (
    id_comparacion INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT UNSIGNED,
    id_ubicacion INT UNSIGNED NOT NULL,
    id_tipo_servicio INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL,
    FOREIGN KEY (id_ubicacion) REFERENCES ubicaciones(id_ubicacion) ON DELETE CASCADE,
    FOREIGN KEY (id_tipo_servicio) REFERENCES tipos_servicios(id_tipo_servicio) ON DELETE CASCADE,
    INDEX idx_usuario (id_usuario),
    INDEX idx_ubicacion (id_ubicacion),
    INDEX idx_tipo_servicio (id_tipo_servicio),
    INDEX idx_fecha (fecha)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 9. TABLA PIVOTE: COMPARACION_TARIFAS
-- ============================================================================
CREATE TABLE IF NOT EXISTS comparacion_tarifas (
    id_comparacion_tarifa INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_comparacion INT UNSIGNED NOT NULL,
    id_tarifa INT UNSIGNED NOT NULL,
    posicion_resultado INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_comparacion) REFERENCES comparaciones(id_comparacion) ON DELETE CASCADE,
    FOREIGN KEY (id_tarifa) REFERENCES tarifas(id_tarifa) ON DELETE CASCADE,
    UNIQUE KEY unique_comparacion_tarifa (id_comparacion, id_tarifa),
    INDEX idx_comparacion (id_comparacion),
    INDEX idx_tarifa (id_tarifa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- ÍNDICES ADICIONALES PARA OPTIMIZACIÓN
-- ============================================================================
ALTER TABLE usuarios ADD KEY idx_fecha_registro (fecha_registro);
ALTER TABLE tarifas ADD KEY idx_servicio_precio (id_servicio, precio);
ALTER TABLE comparaciones ADD KEY idx_usuario_fecha (id_usuario, fecha);

-- ============================================================================
-- FIN DEL SCHEMA
-- ============================================================================
