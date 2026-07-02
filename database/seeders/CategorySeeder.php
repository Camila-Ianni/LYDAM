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
                'name' => 'BAGGYS POR MAYOR',
                'slug' => 'baggys-por-mayor',
                'image_path' => 'images/categories/baggys_mayor.png',
            ],
            [
                'name' => 'BAGGYS POR CURVA',
                'slug' => 'baggys-por-curva',
                'image_path' => 'images/categories/baggys_curva.png',
            ],
            [
                'name' => 'JORTS POR MAYOR',
                'slug' => 'jorts-por-mayor',
                'image_path' => 'images/categories/jorts_mayor.png',
            ],
            [
                'name' => 'JORTS POR CURVA',
                'slug' => 'jorts-por-curva',
                'image_path' => 'images/categories/jorts_curva.png',
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

        // Classify existing products
        $products = Product::all();
        foreach ($products as $product) {
            $nameEs = strtolower($product->translatedName('es'));
            
            if (Str::contains($nameEs, 'jort')) {
                // If it contains jort, put it in Jorts
                if (Str::contains($nameEs, ['mayor', 'pack'])) {
                    $product->category_id = $categories['jorts-por-mayor']->id;
                } else {
                    $product->category_id = $categories['jorts-por-curva']->id;
                }
            } else {
                // If it is baggy/pants/sweater/tee
                if (Str::contains($nameEs, ['mayor', 'pack', 'tee', 'sweater', 'shirt'])) {
                    $product->category_id = $categories['baggys-por-mayor']->id;
                } else {
                    $product->category_id = $categories['baggys-por-curva']->id;
                }
            }
            $product->save();
        }
    }
}
