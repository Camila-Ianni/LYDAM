<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            [
                'name' => 'BAGGYS POR CURVA',
                'slug' => 'baggys-por-curva',
                'image_path' => 'images/categories/baggys_curva.png',
            ],
            [
                'name' => 'BAGGYS POR MAYOR',
                'slug' => 'baggys-por-mayor',
                'image_path' => 'images/categories/baggys_mayor.png',
            ],
            [
                'name' => 'BERMUDAS POR CURVA',
                'slug' => 'bermudas-por-curva',
                'image_path' => 'images/categories/bermudas_curva.png',
            ],
            [
                'name' => 'BERMUDAS POR MAYOR',
                'slug' => 'bermudas-por-mayor',
                'image_path' => 'images/categories/bermudas_mayor.png',
            ],
            [
                'name' => 'REMERAS BOXIFIT POR MAYOR',
                'slug' => 'remeras-boxifit-por-mayor',
                'image_path' => 'images/categories/remeras_boxifit_mayor.png',
            ],
            [
                'name' => 'SWEATERS POR MAYOR',
                'slug' => 'sweaters-por-mayor',
                'image_path' => 'images/categories/sweaters_mayor.png',
            ],
            [
                'name' => 'CÁPSULA LYDAM',
                'slug' => 'capsula-lydam',
                'image_path' => 'images/categories/capsula_lydam.png',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[$data['slug']] = Category::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'image_path' => $data['image_path']
                ]
            );
        }

        // Remove any obsolete categories (like jorts ones from previous turns)
        Category::whereNotIn('slug', array_keys($categories))->delete();

        // Classify existing products
        $products = Product::all();
        foreach ($products as $product) {
            $nameEs = strtolower($product->translatedName('es'));
            
            if (Str::contains($nameEs, ['void walker'])) {
                // Limited drop goes to Capsula
                $product->category_id = $categories['capsula-lydam']->id;
            } elseif (Str::contains($nameEs, ['tee', 'remera', 'remeron', 'shirt'])) {
                // Remeras
                $product->category_id = $categories['remeras-boxifit-por-mayor']->id;
            } elseif (Str::contains($nameEs, 'sweater')) {
                // Sweaters
                $product->category_id = $categories['sweaters-por-mayor']->id;
            } elseif (Str::contains($nameEs, ['jort', 'short', 'bermuda'])) {
                // Bermudas
                if (Str::contains($nameEs, ['mayor', 'pack'])) {
                    $product->category_id = $categories['bermudas-por-mayor']->id;
                } else {
                    $product->category_id = $categories['bermudas-por-curva']->id;
                }
            } else {
                // Baggys / Pants
                if (Str::contains($nameEs, ['mayor', 'pack'])) {
                    $product->category_id = $categories['baggys-por-mayor']->id;
                } else {
                    $product->category_id = $categories['baggys-por-curva']->id;
                }
            }

            // Restore correct sizes for wholesale curve packs
            $product->sizes = ['talles 36 al 44 (pack de 5 prendas)'];
            $product->save();
        }
    }
}
