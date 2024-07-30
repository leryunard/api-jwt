<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'name'    => 'admin',
            'email'       => 'admin@backend.com',
            'password'    => Hash::make('admin123'),
        ]);
        // logica de asignacion de roles y permisos
        $adminRole = Role::where('name', 'admin')->where('estado',true)->first();
        $user = User::where('email', 'admin@backend.com')->first();
        $editPermission = Permission::where('estado',true)->get();
        
        $adminRole->permissions()->attach($editPermission);
        $user->roles()->attach($adminRole);
    }
}
