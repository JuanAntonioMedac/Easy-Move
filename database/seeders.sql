-- ============================================================================
-- EASYMOVE - Datos de Prueba (Seeding)
-- Ejecutar DESPUÉS de importar schema.sql
-- ============================================================================

-- ============================================================================
-- 1. TIPOS DE SERVICIOS
-- ============================================================================
INSERT INTO tipos_servicios (nombre, descripcion) VALUES
('Luz', 'Servicio de suministro eléctrico residencial'),
('Gas', 'Servicio de suministro de gas natural'),
('Telefonía', 'Servicio de telefonía fija e internet');

-- ============================================================================
-- 2. PROVEEDORES
-- ============================================================================
INSERT INTO proveedores (nombre, web, logo, tipo_proveedor, api_disponible) VALUES
('Endesa', 'https://www.endesa.es', 'https://logo.clearbit.com/endesa.es', 'luz', TRUE),
('Iberdrola', 'https://www.iberdrola.es', 'https://logo.clearbit.com/iberdrola.es', 'luz', TRUE),
('EDF', 'https://www.edf.es', 'https://logo.clearbit.com/edf.es', 'luz', FALSE),
('Naturgy', 'https://www.naturgy.es', 'https://logo.clearbit.com/naturgy.es', 'gas', TRUE),
('Telefónica', 'https://www.telefonica.es', 'https://logo.clearbit.com/telefonica.es', 'telefonica', TRUE),
('Vodafone', 'https://www.vodafone.es', 'https://logo.clearbit.com/vodafone.es', 'telefonica', TRUE);

-- ============================================================================
-- 3. SERVICIOS (Luz)
-- ============================================================================
INSERT INTO servicios (nombre_servicio, descripcion, id_tipo_servicio, id_proveedor) VALUES
('Luz Básica Endesa', 'Tarifa estándar de electricidad con acceso flexible', 1, 1),
('Luz Plus Endesa', 'Tarifa con descuentos y ofertas adicionales', 1, 1),
('Luz Eco Iberdrola', 'Tarifa con energías renovables certificadas', 1, 2),
('Luz Estándar EDF', 'Tarifa competitiva sin permanencia', 1, 3);

-- ============================================================================
-- 4. SERVICIOS (Gas)
-- ============================================================================
INSERT INTO servicios (nombre_servicio, descripcion, id_tipo_servicio, id_proveedor) VALUES
('Gas Natural Naturgy', 'Suministro de gas natural con contrato flexible', 2, 4),
('Gas Plus Naturgy', 'Tarifa premium con seguros incluidos', 2, 4);

-- ============================================================================
-- 5. SERVICIOS (Telefonía)
-- ============================================================================
INSERT INTO servicios (nombre_servicio, descripcion, id_tipo_servicio, id_proveedor) VALUES
('Fibra + Fijo Telefónica', 'Fibra óptica 300Mbps + telefonía fija', 3, 5),
('Fibra + Móvil Vodafone', 'Fibra óptica 600Mbps + línea móvil ilimitada', 3, 6);

-- ============================================================================
-- 6. TARIFAS (Luz - Endesa)
-- ============================================================================
INSERT INTO tarifas (nombre_tarifa, precio, unidad_precio, permanencia, condiciones, url_oferta_externa, id_servicio, fecha_actualizacion) VALUES
('Tarifa Luz Básica', 45.50, 'mes', 'Sin permanencia', 'Acceso 0.10€/kWh + potencia 90€/año', 'https://www.endesa.es/es/particulares/luz', 1, NOW()),
('Tarifa Luz Plus', 52.30, 'mes', '12 meses', 'Descuento 15% + seguros incluidos', 'https://www.endesa.es/es/particulares/luz', 2, NOW());

-- ============================================================================
-- 7. TARIFAS (Luz - Iberdrola)
-- ============================================================================
INSERT INTO tarifas (nombre_tarifa, precio, unidad_precio, permanencia, condiciones, url_oferta_externa, id_servicio, fecha_actualizacion) VALUES
('Tarifa Luz Eco', 48.75, 'mes', '12 meses', '100% energía renovable certificada', 'https://www.iberdrola.es/clientes/luz', 3, NOW()),
('Tarifa Luz Ahorro', 44.20, 'mes', 'Sin permanencia', 'Acceso flexible + cambio sin penalización', 'https://www.iberdrola.es/clientes/luz', 3, NOW());

-- ============================================================================
-- 8. TARIFAS (Luz - EDF)
-- ============================================================================
INSERT INTO tarifas (nombre_tarifa, precio, unidad_precio, permanencia, condiciones, url_oferta_externa, id_servicio, fecha_actualizacion) VALUES
('Tarifa Luz Estándar', 46.99, 'mes', 'Sin permanencia', 'Precio fijo durante 1 año', 'https://www.edf.es/es/hogares', 4, NOW());

-- ============================================================================
-- 9. TARIFAS (Gas - Naturgy)
-- ============================================================================
INSERT INTO tarifas (nombre_tarifa, precio, unidad_precio, permanencia, condiciones, url_oferta_externa, id_servicio, fecha_actualizacion) VALUES
('Tarifa Gas Natural', 35.40, 'mes', 'Sin permanencia', 'Precio variable + facturación mensual', 'https://www.naturgy.es', 5, NOW()),
('Tarifa Gas Plus', 42.80, 'mes', '24 meses', 'Incluye seguros de hogar + precio fijo', 'https://www.naturgy.es', 6, NOW());

-- ============================================================================
-- 10. TARIFAS (Telefonía)
-- ============================================================================
INSERT INTO tarifas (nombre_tarifa, precio, unidad_precio, permanencia, condiciones, url_oferta_externa, id_servicio, fecha_actualizacion) VALUES
('Fibra 300Mbps + Fijo', 49.95, 'mes', '12 meses', 'Velocidad hasta 300Mbps + llamadas ilimitadas', 'https://www.telefonica.es', 7, NOW()),
('Fibra 600Mbps + Móvil', 59.90, 'mes', '12 meses', 'Velocidad 600Mbps + línea móvil 50GB', 'https://www.vodafone.es', 8, NOW());

-- ============================================================================
-- 11. UBICACIONES (Madrid)
-- ============================================================================
INSERT INTO ubicaciones (codigo_postal, ciudad, provincia, numero) VALUES
('28001', 'Madrid', 'Madrid', NULL),
('28002', 'Madrid', 'Madrid', NULL),
('28003', 'Madrid', 'Madrid', NULL),
('28004', 'Madrid', 'Madrid', NULL),
('28005', 'Madrid', 'Madrid', NULL),
('28006', 'Madrid', 'Madrid', NULL),
('28007', 'Madrid', 'Madrid', NULL),
('28008', 'Madrid', 'Madrid', NULL),
('28009', 'Madrid', 'Madrid', NULL),
('28010', 'Madrid', 'Madrid', NULL);

-- ============================================================================
-- 12. UBICACIONES (Barcelona)
-- ============================================================================
INSERT INTO ubicaciones (codigo_postal, ciudad, provincia, numero) VALUES
('08001', 'Barcelona', 'Barcelona', NULL),
('08002', 'Barcelona', 'Barcelona', NULL),
('08003', 'Barcelona', 'Barcelona', NULL);

-- ============================================================================
-- 13. DISPONIBILIDAD - Luz (Madrid)
-- ============================================================================
INSERT INTO disponibilidad (id_tarifa, id_ubicacion) VALUES
-- Tarifa 1 (Luz Básica Endesa) en Madrid
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5),
-- Tarifa 2 (Luz Plus Endesa) en Madrid
(2, 1), (2, 2), (2, 3),
-- Tarifa 3 (Luz Eco Iberdrola) en Madrid
(3, 1), (3, 2), (3, 3), (3, 4),
-- Tarifa 4 (Luz Ahorro Iberdrola) en Madrid
(4, 1), (4, 2), (4, 3), (4, 4), (4, 5),
-- Tarifa 5 (Luz Estándar EDF) en Madrid
(5, 1), (5, 2), (5, 3);

-- ============================================================================
-- 14. DISPONIBILIDAD - Luz (Barcelona)
-- ============================================================================
INSERT INTO disponibilidad (id_tarifa, id_ubicacion) VALUES
-- Tarifas en Barcelona
(1, 11), (2, 11), (3, 11), (4, 11), (5, 11),
(1, 12), (3, 12), (4, 12);

-- ============================================================================
-- 15. DISPONIBILIDAD - Gas (Madrid)
-- ============================================================================
INSERT INTO disponibilidad (id_tarifa, id_ubicacion) VALUES
-- Tarifa 6 (Gas Natural Naturgy) en Madrid
(6, 1), (6, 2), (6, 3), (6, 4), (6, 5),
-- Tarifa 7 (Gas Plus Naturgy) en Madrid
(7, 1), (7, 2), (7, 3);

-- ============================================================================
-- 16. DISPONIBILIDAD - Telefonía (Madrid)
-- ============================================================================
INSERT INTO disponibilidad (id_tarifa, id_ubicacion) VALUES
-- Tarifa 8 (Fibra + Fijo Telefónica) en Madrid
(8, 1), (8, 2), (8, 3), (8, 4),
-- Tarifa 9 (Fibra + Móvil Vodafone) en Madrid
(9, 1), (9, 2), (9, 3), (9, 4), (9, 5);

-- ============================================================================
-- 17. USUARIO DE PRUEBA (Optional - si tienes tabla usuarios)
-- ============================================================================
-- INSERT INTO usuarios (nombre, email, password, fecha_registro, rol, preferencias) VALUES
-- ('Juan Pérez', 'juan@example.com', '$2y$12$hashedpassword', NOW(), 'usuario', '{"langauge":"es"}'),
-- ('Admin Test', 'admin@example.com', '$2y$12$hashedpassword', NOW(), 'admin', NULL);

-- ============================================================================
-- VERIFICACIÓN (Ejecuta estos SELECT para validar datos)
-- ============================================================================
-- SELECT COUNT(*) as total_tipos_servicios FROM tipos_servicios;
-- SELECT COUNT(*) as total_proveedores FROM proveedores;
-- SELECT COUNT(*) as total_tarifas FROM tarifas;
-- SELECT COUNT(*) as total_ubicaciones FROM ubicaciones;
-- SELECT COUNT(*) as total_disponibilidades FROM disponibilidad;

-- Búsqueda de ejemplo: Luz en Madrid 28001
-- SELECT t.*, ts.nombre, p.nombre as proveedor, u.ciudad
-- FROM tarifas t
-- JOIN servicios s ON t.id_servicio = s.id_servicio
-- JOIN tipos_servicios ts ON s.id_tipo_servicio = ts.id_tipo_servicio
-- JOIN proveedores p ON s.id_proveedor = p.id_proveedor
-- JOIN disponibilidad d ON t.id_tarifa = d.id_tarifa
-- JOIN ubicaciones u ON d.id_ubicacion = u.id_ubicacion
-- WHERE ts.id_tipo_servicio = 1 AND u.codigo_postal = '28001'
-- ORDER BY t.precio ASC
-- LIMIT 2;

-- ============================================================================
-- FIN DE DATOS DE PRUEBA
-- ============================================================================
