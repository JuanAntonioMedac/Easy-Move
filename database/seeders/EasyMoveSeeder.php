<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EasyMoveSeeder extends Seeder
{
    public function run(): void
    {
        // 🧹 (Opcional) limpiar tablas para evitar duplicados
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('usuarios')->truncate();
        DB::table('disponibilidad')->truncate();
        DB::table('comparacion_tarifas')->truncate();
        DB::table('comparaciones')->truncate();
        DB::table('tarifas')->truncate();
        DB::table('servicios')->truncate();
        DB::table('proveedores')->truncate();
        DB::table('ubicaciones')->truncate();
        DB::table('tipos_servicios')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // =========================
        // USUARIOS
        // =========================
        DB::table('usuarios')->insert([
            [
                'id_usuario' => 1,
                'nombre' => 'Admin Easy-Move',
                'email' => 'admin@easymove.com',
                'password' => Hash::make('admin123456'),
                'rol' => 'admin',
                'preferencias' => json_encode(['language' => 'es', 'theme' => 'light']),
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => 2,
                'nombre' => 'Juan Pérez García',
                'email' => 'juan.perez@example.com',
                'password' => Hash::make('password123'),
                'rol' => 'usuario',
                'preferencias' => json_encode(['language' => 'es']),
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => 3,
                'nombre' => 'María López González',
                'email' => 'maria.lopez@example.com',
                'password' => Hash::make('password123'),
                'rol' => 'usuario',
                'preferencias' => json_encode(['language' => 'es']),
                'fecha_registro' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =========================
        // TIPOS DE SERVICIOS
        // =========================
        DB::table('tipos_servicios')->insert([
            ['id_tipo_servicio' => 1, 'nombre' => 'Luz', 'descripcion' => 'Servicio de suministro eléctrico residencial', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_servicio' => 2, 'nombre' => 'Gas', 'descripcion' => 'Servicio de suministro de gas natural', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_servicio' => 3, 'nombre' => 'Telefonía', 'descripcion' => 'Servicio de telefonía fija e internet', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =========================
        // PROVEEDORES
        // =========================
        DB::table('proveedores')->insert([
            ['id_proveedor' => 1, 'nombre' => 'Endesa', 'web' => 'https://www.endesa.es', 'logo' => 'proveedores/endesa.png', 'tipo_proveedor' => 'luz', 'api_disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_proveedor' => 2, 'nombre' => 'Iberdrola', 'web' => 'https://www.iberdrola.es', 'logo' => 'proveedores/iberdrola.png', 'tipo_proveedor' => 'luz', 'api_disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_proveedor' => 3, 'nombre' => 'EDF', 'web' => 'https://www.edf.es', 'logo' => 'proveedores/edf.png', 'tipo_proveedor' => 'luz', 'api_disponible' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['id_proveedor' => 4, 'nombre' => 'Naturgy', 'web' => 'https://www.naturgy.es', 'logo' => 'proveedores/naturgy.png', 'tipo_proveedor' => 'gas', 'api_disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_proveedor' => 5, 'nombre' => 'Telefónica', 'web' => 'https://www.telefonica.es', 'logo' => 'proveedores/telefonica.png', 'tipo_proveedor' => 'telefonica', 'api_disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_proveedor' => 6, 'nombre' => 'Vodafone', 'web' => 'https://www.vodafone.es', 'logo' => 'proveedores/vodafone.png', 'tipo_proveedor' => 'telefonica', 'api_disponible' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =========================
        // UBICACIONES
        // =========================
        DB::table('ubicaciones')->insert([
            // Madrid
            ['id_ubicacion' => 1, 'codigo_postal' => '28001', 'ciudad' => 'Madrid', 'provincia' => 'Madrid', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_ubicacion' => 2, 'codigo_postal' => '28002', 'ciudad' => 'Madrid', 'provincia' => 'Madrid', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_ubicacion' => 3, 'codigo_postal' => '28003', 'ciudad' => 'Madrid', 'provincia' => 'Madrid', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_ubicacion' => 4, 'codigo_postal' => '28004', 'ciudad' => 'Madrid', 'provincia' => 'Madrid', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_ubicacion' => 5, 'codigo_postal' => '28005', 'ciudad' => 'Madrid', 'provincia' => 'Madrid', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            // Barcelona
            ['id_ubicacion' => 11, 'codigo_postal' => '08001', 'ciudad' => 'Barcelona', 'provincia' => 'Barcelona', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_ubicacion' => 12, 'codigo_postal' => '08002', 'ciudad' => 'Barcelona', 'provincia' => 'Barcelona', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id_ubicacion' => 13, 'codigo_postal' => '08003', 'ciudad' => 'Barcelona', 'provincia' => 'Barcelona', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            // Valencia
            ['id_ubicacion' => 21, 'codigo_postal' => '46001', 'ciudad' => 'Valencia', 'provincia' => 'Valencia', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
            // Sevilla
            ['id_ubicacion' => 31, 'codigo_postal' => '41001', 'ciudad' => 'Sevilla', 'provincia' => 'Sevilla', 'numero' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =========================
        // SERVICIOS
        // =========================
        DB::table('servicios')->insert([
            ['id_servicio' => 1, 'nombre_servicio' => 'Luz Básica Endesa', 'descripcion' => 'Tarifa estándar de electricidad con acceso flexible', 'id_tipo_servicio' => 1, 'id_proveedor' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 2, 'nombre_servicio' => 'Luz Plus Endesa', 'descripcion' => 'Tarifa con descuentos y ofertas adicionales', 'id_tipo_servicio' => 1, 'id_proveedor' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 3, 'nombre_servicio' => 'Luz Eco Iberdrola', 'descripcion' => 'Tarifa con energías renovables certificadas', 'id_tipo_servicio' => 1, 'id_proveedor' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 4, 'nombre_servicio' => 'Luz Estándar EDF', 'descripcion' => 'Tarifa competitiva sin permanencia', 'id_tipo_servicio' => 1, 'id_proveedor' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 5, 'nombre_servicio' => 'Gas Natural Naturgy', 'descripcion' => 'Suministro de gas natural con contrato flexible', 'id_tipo_servicio' => 2, 'id_proveedor' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 6, 'nombre_servicio' => 'Gas Plus Naturgy', 'descripcion' => 'Tarifa premium con seguros incluidos', 'id_tipo_servicio' => 2, 'id_proveedor' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 7, 'nombre_servicio' => 'Fibra + Fijo Telefónica', 'descripcion' => 'Fibra óptica 300Mbps + telefonía fija', 'id_tipo_servicio' => 3, 'id_proveedor' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['id_servicio' => 8, 'nombre_servicio' => 'Fibra + Móvil Vodafone', 'descripcion' => 'Fibra óptica 600Mbps + línea móvil ilimitada', 'id_tipo_servicio' => 3, 'id_proveedor' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =========================
        // TARIFAS (Luz - Endesa)
        // =========================
        DB::table('tarifas')->insert([
            [
                'id_tarifa' => 1,
                'nombre_tarifa' => 'Tarifa Luz Básica',
                'precio' => 45.50,
                'unidad_precio' => 'mes',
                'permanencia' => 'Sin permanencia',
                'condiciones' => 'Acceso 0.10€/kWh + potencia 90€/año. Facturación mensual. Cambio sin penalización.',
                'url_oferta_externa' => 'https://www.endesa.es/es/particulares/luz',
                'id_servicio' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tarifa' => 2,
                'nombre_tarifa' => 'Tarifa Luz Plus',
                'precio' => 52.30,
                'unidad_precio' => 'mes',
                'permanencia' => '12 meses',
                'condiciones' => 'Descuento 15% + seguros incluidos. Acceso preferente a nuevas ofertas.',
                'url_oferta_externa' => 'https://www.endesa.es/es/particulares/luz',
                'id_servicio' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =========================
        // TARIFAS (Luz - Iberdrola)
        // =========================
        DB::table('tarifas')->insert([
            [
                'id_tarifa' => 3,
                'nombre_tarifa' => 'Tarifa Luz Eco',
                'precio' => 48.75,
                'unidad_precio' => 'mes',
                'permanencia' => '12 meses',
                'condiciones' => '100% energía renovable certificada. Contribuye a la transición energética.',
                'url_oferta_externa' => 'https://www.iberdrola.es/clientes/luz',
                'id_servicio' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tarifa' => 4,
                'nombre_tarifa' => 'Tarifa Luz Ahorro',
                'precio' => 44.20,
                'unidad_precio' => 'mes',
                'permanencia' => 'Sin permanencia',
                'condiciones' => 'Acceso flexible + cambio sin penalización. Mejor precio garantizado.',
                'url_oferta_externa' => 'https://www.iberdrola.es/clientes/luz',
                'id_servicio' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =========================
        // TARIFAS (Luz - EDF)
        // =========================
        DB::table('tarifas')->insert([
            [
                'id_tarifa' => 5,
                'nombre_tarifa' => 'Tarifa Luz Estándar',
                'precio' => 46.99,
                'unidad_precio' => 'mes',
                'permanencia' => 'Sin permanencia',
                'condiciones' => 'Precio fijo durante 1 año. Acceso 24/7 al servicio técnico.',
                'url_oferta_externa' => 'https://www.edf.es/es/hogares',
                'id_servicio' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =========================
        // TARIFAS (Gas - Naturgy)
        // =========================
        DB::table('tarifas')->insert([
            [
                'id_tarifa' => 6,
                'nombre_tarifa' => 'Tarifa Gas Natural',
                'precio' => 35.40,
                'unidad_precio' => 'mes',
                'permanencia' => 'Sin permanencia',
                'condiciones' => 'Precio variable + facturación mensual. Seguro de robo incluido.',
                'url_oferta_externa' => 'https://www.naturgy.es',
                'id_servicio' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tarifa' => 7,
                'nombre_tarifa' => 'Tarifa Gas Plus',
                'precio' => 42.80,
                'unidad_precio' => 'mes',
                'permanencia' => '24 meses',
                'condiciones' => 'Incluye seguros de hogar + precio fijo durante todo el contrato.',
                'url_oferta_externa' => 'https://www.naturgy.es',
                'id_servicio' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =========================
        // TARIFAS (Telefonía)
        // =========================
        DB::table('tarifas')->insert([
            [
                'id_tarifa' => 8,
                'nombre_tarifa' => 'Fibra 300Mbps + Fijo',
                'precio' => 49.95,
                'unidad_precio' => 'mes',
                'permanencia' => '12 meses',
                'condiciones' => 'Velocidad hasta 300Mbps + llamadas ilimitadas. Instalación gratis.',
                'url_oferta_externa' => 'https://www.telefonica.es',
                'id_servicio' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_tarifa' => 9,
                'nombre_tarifa' => 'Fibra 600Mbps + Móvil',
                'precio' => 59.90,
                'unidad_precio' => 'mes',
                'permanencia' => '12 meses',
                'condiciones' => 'Velocidad 600Mbps + línea móvil 50GB ilimitados. Router WiFi 6 incluido.',
                'url_oferta_externa' => 'https://www.vodafone.es',
                'id_servicio' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // =========================
        // DISPONIBILIDAD - Luz (Madrid)
        // =========================
        DB::table('disponibilidad')->insert([
            ['id_disponibilidad' => 1, 'id_tarifa' => 1, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 2, 'id_tarifa' => 1, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 3, 'id_tarifa' => 1, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 4, 'id_tarifa' => 1, 'id_ubicacion' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 5, 'id_tarifa' => 1, 'id_ubicacion' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['id_disponibilidad' => 6, 'id_tarifa' => 2, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 7, 'id_tarifa' => 2, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 8, 'id_tarifa' => 2, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['id_disponibilidad' => 9, 'id_tarifa' => 3, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 10, 'id_tarifa' => 3, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 11, 'id_tarifa' => 3, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 12, 'id_tarifa' => 3, 'id_ubicacion' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['id_disponibilidad' => 13, 'id_tarifa' => 4, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 14, 'id_tarifa' => 4, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 15, 'id_tarifa' => 4, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 16, 'id_tarifa' => 4, 'id_ubicacion' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 17, 'id_tarifa' => 4, 'id_ubicacion' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['id_disponibilidad' => 18, 'id_tarifa' => 5, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 19, 'id_tarifa' => 5, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 20, 'id_tarifa' => 5, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =========================
        // DISPONIBILIDAD - Luz (Barcelona y otras ciudades)
        // =========================
        DB::table('disponibilidad')->insert([
            ['id_disponibilidad' => 21, 'id_tarifa' => 1, 'id_ubicacion' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 22, 'id_tarifa' => 1, 'id_ubicacion' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 23, 'id_tarifa' => 2, 'id_ubicacion' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 24, 'id_tarifa' => 3, 'id_ubicacion' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 25, 'id_tarifa' => 3, 'id_ubicacion' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 26, 'id_tarifa' => 4, 'id_ubicacion' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 27, 'id_tarifa' => 4, 'id_ubicacion' => 12, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =========================
        // DISPONIBILIDAD - Gas (Madrid)
        // =========================
        DB::table('disponibilidad')->insert([
            ['id_disponibilidad' => 28, 'id_tarifa' => 6, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 29, 'id_tarifa' => 6, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 30, 'id_tarifa' => 6, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 31, 'id_tarifa' => 6, 'id_ubicacion' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 32, 'id_tarifa' => 6, 'id_ubicacion' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['id_disponibilidad' => 33, 'id_tarifa' => 7, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 34, 'id_tarifa' => 7, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 35, 'id_tarifa' => 7, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // =========================
        // DISPONIBILIDAD - Telefonía (Madrid)
        // =========================
        DB::table('disponibilidad')->insert([
            ['id_disponibilidad' => 36, 'id_tarifa' => 8, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 37, 'id_tarifa' => 8, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 38, 'id_tarifa' => 8, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 39, 'id_tarifa' => 8, 'id_ubicacion' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['id_disponibilidad' => 40, 'id_tarifa' => 9, 'id_ubicacion' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 41, 'id_tarifa' => 9, 'id_ubicacion' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 42, 'id_tarifa' => 9, 'id_ubicacion' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 43, 'id_tarifa' => 9, 'id_ubicacion' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['id_disponibilidad' => 44, 'id_tarifa' => 9, 'id_ubicacion' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
