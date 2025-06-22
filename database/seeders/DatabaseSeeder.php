<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Añade esta línea


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            // UserSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            EspecialidadSeeder::class,
            TituloSeeder::class,
            ProgramaSeeder::class,
            TrayectoSeeder::class,
            EstudianteSeeder::class
        ]);


        /* User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
        ]);*/

        // 3. Volver a habilitar las restricciones de clave foránea
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
