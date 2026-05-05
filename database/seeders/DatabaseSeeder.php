<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar el seeder completo solo si la base está vacía.
        // Evita truncar datos existentes en Railway o en re-deploys.
        if (Schema::hasTable('tipos_servicios') && !DB::table('tipos_servicios')->exists()) {
            $this->call(EasyMoveSeeder::class);
        }

        // Crear usuario admin
        User::firstOrCreate(
            ['email' => 'admin@easymove.com'],
            [
                'nombre' => 'Administrador',
                'email' => 'admin@easymove.com',
                'password' => Hash::make('password'),
                'rol' => 'admin',
            ]
        );

        // Crear usuario de prueba
        User::firstOrCreate(
            ['email' => 'usuario@easymove.com'],
            [
                'nombre' => 'Usuario de Prueba',
                'email' => 'usuario@easymove.com',
                'password' => Hash::make('password'),
                'rol' => 'usuario',
            ]
        );
    }
}
