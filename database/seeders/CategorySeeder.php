<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan make:seeder CategorySeeder (creates a new seeder)
     * php artisan migrate:fresh --seed (migrates and seeds the database)
     */
    public function run(): void
    {
        Category::insert([
            ['nombre' => 'ACEITE',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['nombre' => 'COMPONENTE ELECTRÓNICO',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['nombre' => 'REFRIGERANTE',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['nombre' => 'HERRAMIENTAS',
             'created_at' => now(),
             'updated_at' => now(),
            ]
        ]);
    }
}
