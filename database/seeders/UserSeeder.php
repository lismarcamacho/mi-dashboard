<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de que el modelo User esté importado.
use Illuminate\Support\Facades\Hash; // Si usas Hash::make() directamente en el seeder.

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                // Opción 1: Crear un único usuario específico (por ejemplo, un administrador)
         //Puedes crear un usuario específico de administrador si lo deseas:
         User::factory()->create([
             'name' => 'Admin User',
             'email' => 'admin@example.com',
             'password' => Hash::make('password'),
        ]);

        // Esto es lo que crea los usuarios ficticios:
        User::factory()->count(10)->create(); // Cambia 10 por el número de usuarios que quieres
    }
}
