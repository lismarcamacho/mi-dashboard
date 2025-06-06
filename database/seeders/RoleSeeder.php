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

        $role1 = Role:: create(['name'=>'Administrador']);
        $role2 = Role:: create(['name'=>'Profesor']);
        $role3 = Role:: create(['name'=>'Analista']);
        $role4 = Role:: create(['name'=>'Estudiante']);
        $role5 = Role:: create(['name'=>'Jefe Dasce']);
        $role6 = Role:: create(['name'=>'Coordinador PNFA']);
        $role7 = Role:: create(['name'=>'Coordinador PNFC']);
        $role8 = Role:: create(['name'=>'Coordinador PNFE']);
        $role9 = Role:: create(['name'=>'Coordinador PNFM']);
        $role9 = Role:: create(['name'=>'Supervisor PNFM']);
    
    }
}
