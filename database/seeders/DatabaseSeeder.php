<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar el seeder de EasyMove
        $this->call(EasyMoveSeeder::class);

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
