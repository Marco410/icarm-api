<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=> 'Admin','guard_name'=> 'api']);
        $role2 = Role::create(['name'=> 'Coordinadora','guard_name'=> 'api']);
        $role3 = Role::create(['name'=> 'Lider','guard_name'=> 'api']);
        $role3 = Role::create(['name'=> 'Mama','guard_name'=> 'api']);

        /* Permission::create(['name' => 'eventos.registro'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'admin.users'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.agencies'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.agencies.add'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.agencies.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.agencies.delete'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'admin.brands'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.brands.add'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.brands.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.brands.delete'])->syncRoles([$role1]); */

        User::create([
            'nombre' => 'Admin',
            'email' => 'admin@gmail.com',
            'apellido_p' => 'LllApp',
            'embarazada' => 0,
            'password' =>hash('sha512', '1234567890'),
        ])->assignRole('Admin');

        User::create([
            'nombre' => 'Lorena',
            'email' => 'lorena@gmail.com',
            'apellido_p' => 'Perez',
            'embarazada' => 0,
            'password' =>hash('sha512', '1234567890'),
        ])->assignRole('Lider');

    } 
}
