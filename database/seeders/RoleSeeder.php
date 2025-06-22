<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB; 

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $role1 = Role:: firstOrCreate (['name'=>'Administrador']);
        $role2 = Role:: firstOrCreate (['name'=>'Profesor']);
        $role3 = Role:: firstOrCreate (['name'=>'Analista']);
        $role4 = Role:: firstOrCreate (['name'=>'Estudiante']);
        $role5 = Role:: firstOrCreate (['name'=>'Jefe Dasce']);
        $role6 = Role:: firstOrCreate (['name'=>'Coordinador PNFA']);
        $role7 = Role:: firstOrCreate (['name'=>'Coordinador PNFC']);
        $role8 = Role:: firstOrCreate (['name'=>'Coordinador PNFE']);
        $role9 = Role:: firstOrCreate (['name'=>'Coordinador PNFM']);
        $role9 = Role:: firstOrCreate (['name'=>'Supervisor PNFM']);
    
    }
}
