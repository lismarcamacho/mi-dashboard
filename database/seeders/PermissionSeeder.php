<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; 

use Spatie\Permission\Models\Permission; 

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reinicia el caché de permisos (muy importante con Spatie)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crea los permisos
        // Usa firstOrCreate para evitar duplicados si lo ejecutas varias veces
        Permission::firstOrCreate(['name' => 'crear-usuarios']);
        Permission::firstOrCreate(['name' => 'editar-usuarios']);
        Permission::firstOrCreate(['name' => 'eliminar-usuarios']);
        Permission::firstOrCreate(['name' => 'ver-usuarios']);

        Permission::firstOrCreate(['name' => 'crear-roles']);
        Permission::firstOrCreate(['name' => 'editar-roles']);
        Permission::firstOrCreate(['name' => 'eliminar-roles']);

        // Permisos para programas
        Permission::firstOrCreate(['name' => 'ver-programas']);
        Permission::firstOrCreate(['name' => 'crear-programas']);
        Permission::firstOrCreate(['name' => 'editar-programas']);
        Permission::firstOrCreate(['name' => 'eliminar-programas']);

        // Permisos para especialidades
        Permission::firstOrCreate(['name' => 'ver-especialidades']);
        Permission::firstOrCreate(['name' => 'crear-especialidades']);
        Permission::firstOrCreate(['name' => 'editar-especialidades']);
        Permission::firstOrCreate(['name' => 'eliminar-especialidades']);

        // Permisos para estudiantes
        Permission::firstOrCreate(['name' => 'ver-estudiantes']);
        Permission::firstOrCreate(['name' => 'crear-estudiantes']);
        Permission::firstOrCreate(['name' => 'editar-estudiantes']);
        Permission::firstOrCreate(['name' => 'eliminar-estudiantes']);

        // Permisos para secciones
        Permission::firstOrCreate(['name' => 'ver-secciones']);
        Permission::firstOrCreate(['name' => 'crear-secciones']);
        Permission::firstOrCreate(['name' => 'editar-secciones']);
        Permission::firstOrCreate(['name' => 'eliminar-secciones']);

        // Permisos para matrículas
        Permission::firstOrCreate(['name' => 'ver-matriculas']);
        Permission::firstOrCreate(['name' => 'crear-matriculas']);
        Permission::firstOrCreate(['name' => 'editar-matriculas']);
        Permission::firstOrCreate(['name' => 'eliminar-matriculas']);

        // Agrega más permisos según las funcionalidades de tu aplicación
        // Ej:
        // Permission::firstOrCreate(['name' => 'manage settings']);
        // Permission::firstOrCreate(['name' => 'export data']);

        // 3. Asignar permisos a roles (Opcional, también se puede hacer en RoleSeeder o aparte)
        // Obtén los roles (asegúrate de que RoleSeeder se ejecute antes o ya existan)
        $adminRole = Role::where('name', 'Administrador')->first();
        $profesorRole = Role::where('name', 'Profesor')->first();
        $analistaRole = Role::where('name', 'Analista')->first();
        $estudianteRole = Role::where('name', 'Estudiante')->first();
        $jefeDasceRole = Role::where('name', 'Jefe Dasce')->first();
        $coordPnfaRole = Role::where('name', 'Coordinador PNFA')->first();
        // ... y así con el resto de tus roles

        if ($adminRole) {
            // El administrador tiene todos los permisos o un conjunto muy amplio
            // Opción 1: Asignar permisos específicos
            $adminRole->givePermissionTo([
                'crear-usuarios', 'editar-usuarios', 'eliminar-usuarios', 'ver-usuarios',
                'crear-roles', 'editar-roles', 'eliminar-roles',
                'ver-programas', 'crear-programas', 'editar-programas', 'eliminar-programas',
                'ver-especialidades', 'crear-especialidades', 'editar-especialidades', 'eliminar-especialidades',
                'ver-estudiantes', 'crear-estudiantes', 'editar-estudiantes', 'eliminar-estudiantes',
                'ver-secciones', 'crear-secciones', 'editar-secciones', 'eliminar-secciones',
                'ver-matriculas', 'crear-matriculas', 'editar-matriculas', 'eliminar-matriculas',
                // Agrega todos los permisos que quieras para el administrador
            ]);

            // Opción 2: Asignar todos los permisos existentes (si tienes muchos y quieres que el admin tenga todos)
            // $adminRole->givePermissionTo(Permission::all());
        }

        if ($profesorRole) {
            $profesorRole->givePermissionTo([
                'ver-estudiantes',
                'ver-secciones',
                'ver-matriculas',
                 // ver notas, editar notas eliminar notas
                // etc.
            ]);
        }
        if ($analistaRole) {
            $analistaRole->givePermissionTo([
                'ver-programas', 'crear-programas', 'editar-programas', 'eliminar-programas',
                'ver-especialidades', 'crear-especialidades', 'editar-especialidades', 'eliminar-especialidades',
                'ver-estudiantes', 'crear-estudiantes', 'editar-estudiantes', 'eliminar-estudiantes',
                'ver-secciones', 'crear-secciones', 'editar-secciones', 'eliminar-secciones',
                'ver-matriculas', 'crear-matriculas', 'editar-matriculas', 'eliminar-matriculas',
                // etc.
            ]);
        }
        // Repite para los demás roles
        if ($estudianteRole) {
            $estudianteRole->givePermissionTo([
                'ver-matriculas', // El estudiante solo ve sus matrículas
                'ver-secciones', // Ver las secciones disponibles
                // etc.
            ]);

           // jefeDasceRole carga la malla  y es el admin principal pero eso aun tengo que revisarlo bien
        }
        // ... y así sucesivamente para Jefe Dasce, Coordinador PNFA, etc.
    }
}