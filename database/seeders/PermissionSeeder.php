<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permissions
        Permission::insert([
            ['name' => 'create_post', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit_post', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete_post', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'publish_post', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
