<?php


namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategories = [
            [
                'category_id' => 1,
                'name' => 'Infantil',
                'slug' => Str::slug('Infantil'),
                'color' => true
            ],
            [
                'category_id' => 1,
                'name' => 'Montaña',
                'slug' => Str::slug('Montaña'),
            ],
            [
                'category_id' => 1,
                'name' => 'Ruta y gravel',
                'slug' => Str::slug('Ruta y gravel'),
            ],

            [
                'category_id' => 1,
                'name' => 'Urbana de ciudad',
                'slug' => Str::slug('Urbana de ciudad'),
            ],

            [
                'category_id' => 2,
                'name' => 'ACCESORIOS VARIOS',
                'slug' => Str::slug('ACCESORIOS VARIOS'),
                'color' => true
            ],
            [
                'category_id' => 2,
                'name' => 'HIDRATACION',
                'slug' => Str::slug('HIDRATACION'),
            ],
            [
                'category_id' => 2,
                'name' => 'SEGURIDAD Y LUCES',
                'slug' => Str::slug('SEGURIDAD Y LUCES'),
            ],

            
            [
                'category_id' => 3,
                'name' => 'CASCOS',
                'slug' => Str::slug('CASCOS'),
                'color' => true
            ],
            [
                'category_id' => 3,
                'name' => 'PROTECCIONES',
                'slug' => Str::slug('PROTECCIONES'),
            ],

            [
                'category_id' => 3,
                'name' => 'ROPA',
                'slug' => Str::slug('ROPA'),
            ],

        ];

        foreach ($subcategories as $subcategory) {
            
            Subcategory::factory(1)->create($subcategory);
        }
    }
}
