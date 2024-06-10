<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bicicletas',
                'slug' => Str::slug('Bicicletas'),
                'icon' => '<i class="fas fa-mobile-alt"></i>'
            ],
            [
                'name' => 'Accesorios',
                'slug' => Str::slug('Accesorios'),
                'icon' => '<i class="fas fa-tv"></i>'
            ],
            [
                'name' => 'Indumentaria',
                'slug' => Str::slug('Indumentaria'),
                'icon' => '<i class="fas fa-gamepad"></i>'
            ]
        ];

        foreach ($categories as $category) {
            Category::factory(1)->create($category);
        }
    }
}
