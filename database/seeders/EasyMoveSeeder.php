<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EasyMoveSeeder extends Seeder
{
    public function run(): void
    {
        // 🧹 (Opcional) limpiar tablas para evitar duplicados
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

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
        // TIPOS DE SERVICIOS
        // =========================
        DB::table('tipos_servicios')->insert([
            ['id_tipo_servicio' => 1, 'nombre' => 'Luz', 'descripcion' => 'Servicio de suministro electrico residencial'],
            ['id_tipo_servicio' => 2, 'nombre' => 'Gas', 'descripcion' => 'Servicio de suministro de gas natural'],
            ['id_tipo_servicio' => 3, 'nombre' => 'Telefonia', 'descripcion' => 'Servicio de telefonia fija e internet'],
        ]);

        // =========================
        // PROVEEDORES
        // =========================
        DB::table('proveedores')->insert([
            ['id_proveedor' => 1, 'nombre' => 'Endesa', 'web' => 'https://www.endesa.es', 'logo' => 'https://logo.clearbit.com/endesa.es', 'tipo_proveedor' => 'luz', 'api_disponible' => 1],
            ['id_proveedor' => 2, 'nombre' => 'Iberdrola', 'web' => 'https://www.iberdrola.es', 'logo' => 'https://logo.clearbit.com/iberdrola.es', 'tipo_proveedor' => 'luz', 'api_disponible' => 1],
            ['id_proveedor' => 3, 'nombre' => 'EDF', 'web' => 'https://www.edf.es', 'logo' => 'https://logo.clearbit.com/edf.es', 'tipo_proveedor' => 'luz', 'api_disponible' => 0],
            ['id_proveedor' => 4, 'nombre' => 'Naturgy', 'web' => 'https://www.naturgy.es', 'logo' => 'https://logo.clearbit.com/naturgy.es', 'tipo_proveedor' => 'gas', 'api_disponible' => 1],
            ['id_proveedor' => 5, 'nombre' => 'Telefonica', 'web' => 'https://www.telefonica.es', 'logo' => 'https://logo.clearbit.com/telefonica.es', 'tipo_proveedor' => 'telefonia', 'api_disponible' => 1],
            ['id_proveedor' => 6, 'nombre' => 'Vodafone', 'web' => 'https://www.vodafone.es', 'logo' => 'https://logo.clearbit.com/vodafone.es', 'tipo_proveedor' => 'telefonia', 'api_disponible' => 1],
        ]);

        // =========================
        // UBICACIONES
        // =========================
        DB::table('ubicaciones')->insert([
            ['id_ubicacion' => 1, 'codigo_postal' => '28001', 'ciudad' => 'Madrid', 'provincia' => 'Madrid'],
            ['id_ubicacion' => 2, 'codigo_postal' => '28002', 'ciudad' => 'Madrid', 'provincia' => 'Madrid'],
            ['id_ubicacion' => 3, 'codigo_postal' => '28003', 'ciudad' => 'Madrid', 'provincia' => 'Madrid'],
            ['id_ubicacion' => 11, 'codigo_postal' => '08001', 'ciudad' => 'Barcelona', 'provincia' => 'Barcelona'],
            ['id_ubicacion' => 12, 'codigo_postal' => '08002', 'ciudad' => 'Barcelona', 'provincia' => 'Barcelona'],
        ]);

        // =========================
        // SERVICIOS
        // =========================
        DB::table('servicios')->insert([
            ['id_servicio' => 1, 'nombre_servicio' => 'Luz Basica Endesa', 'id_tipo_servicio' => 1, 'id_proveedor' => 1],
            ['id_servicio' => 2, 'nombre_servicio' => 'Luz Plus Endesa', 'id_tipo_servicio' => 1, 'id_proveedor' => 1],
            ['id_servicio' => 3, 'nombre_servicio' => 'Luz Eco Iberdrola', 'id_tipo_servicio' => 1, 'id_proveedor' => 2],
            ['id_servicio' => 4, 'nombre_servicio' => 'Gas Natural Naturgy', 'id_tipo_servicio' => 2, 'id_proveedor' => 4],
            ['id_servicio' => 5, 'nombre_servicio' => 'Fibra Telefonica', 'id_tipo_servicio' => 3, 'id_proveedor' => 5],
        ]);

        // =========================
        // TARIFAS
        // =========================
        DB::table('tarifas')->insert([
            ['id_tarifa' => 1, 'nombre_tarifa' => 'Tarifa Luz Basica', 'precio' => 45.50, 'unidad_precio' => 'mes', 'id_servicio' => 1],
            ['id_tarifa' => 2, 'nombre_tarifa' => 'Tarifa Luz Plus', 'precio' => 52.30, 'unidad_precio' => 'mes', 'id_servicio' => 2],
            ['id_tarifa' => 3, 'nombre_tarifa' => 'Tarifa Luz Eco', 'precio' => 48.75, 'unidad_precio' => 'mes', 'id_servicio' => 3],
            ['id_tarifa' => 4, 'nombre_tarifa' => 'Tarifa Gas', 'precio' => 35.40, 'unidad_precio' => 'mes', 'id_servicio' => 4],
        ]);

        // =========================
        // DISPONIBILIDAD
        // =========================
        DB::table('disponibilidad')->insert([
            ['id_disponibilidad' => 1, 'id_tarifa' => 1, 'id_ubicacion' => 1],
            ['id_disponibilidad' => 2, 'id_tarifa' => 2, 'id_ubicacion' => 2],
            ['id_disponibilidad' => 3, 'id_tarifa' => 3, 'id_ubicacion' => 3],
        ]);
    }
}
