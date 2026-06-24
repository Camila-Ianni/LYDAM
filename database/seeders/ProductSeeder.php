<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => [
                    'es' => 'BAGGY JEAN ULTIMATE SKULL',
                    'en' => 'BAGGY JEAN ULTIMATE SKULL'
                ],
                'slug' => 'baggy-jean-ultimate-skull',
                'description' => [
                    'es' => 'Denim negro pesado de 14oz lavado en ácido. Presenta un bordado agresivo de calavera tribal roja de alta densidad en los bolsillos traseros y la pierna inferior. Costuras rojas en contraste en toda la prenda. Ajuste de pierna ultra ancha diseñado para el máximo arrastre. No confíes en nadie.',
                    'en' => 'Acid-washed 14oz heavy black denim. Features aggressive high-density red tribal skull embroidery on the back pockets and lower leg. Contrast red stitching throughout. Ultra baggy fit designed for maximum drag. Trust no one.'
                ],
                'sku' => 'LYD-BGY-SKL',
                'price' => 425000.00,
                'stock' => 35,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAYMkMUwGEZ6NXQsCB0zWOjnoXuZoXpSf_X2LTqO1k2m5y1duqcpSE67RgFkr-30D2e8X_0916Nl7dujbD9T43DmXmwQHKXlfRd_Vsxm8lUabDLb8Q29rUL__YPBxoIaLJe_Zbm8Qo3WeuoDhT7BPHSi4xVrbiaF8UWcOMXHYjnN5xDL7y8Lr0RcEptceqz-LuFerwdRpx7W7kUqK7daKi2zg2gxuRfVHJlbySatyfvQD99MAp5Yfye6po094lo_X5XYMHxtcZ7C6kD',
            ],
            [
                'name' => [
                    'es' => 'INFERNAL STITCH BAGGY',
                    'en' => 'INFERNAL STITCH BAGGY'
                ],
                'slug' => 'infernal-stitch-baggy',
                'description' => [
                    'es' => 'Pantalón baggy con costuras reforzadas infernales y bordado tribal distintivo de la colección Tribal Under.',
                    'en' => 'Baggy pants with infernal reinforced stitching and signature tribal embroidery from the Tribal Under collection.'
                ],
                'sku' => 'LYD-BGY-INF',
                'price' => 540000.00,
                'stock' => 45,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBEsQ1LWYLuT5D6mQGsV8ORduRQTcFdLsrQFBGUTk7IZoKXYEKkdePLBH_yjHszhJ0MoGC_bQF3jCmxp2Ga769MTJIQLjIK9u7clByfGX-SYmEEkgOli9_kgiOr19PBjqUvKF8aAzVmPQ8atTp55aAzSgdZ9pssh_l4La7udBz5UAzbckjq3itx9mqia-kOw6CciFNdlCE-K8QAIXUu_6qoRNZIfQBOWlaxfe4xTFEOMlZd3DEaXe99TrUDNxLLorDXd43PTRkx_k0V',
            ],
            [
                'name' => [
                    'es' => 'VOID WALKER PANTS',
                    'en' => 'VOID WALKER PANTS'
                ],
                'slug' => 'void-walker-pants',
                'description' => [
                    'es' => 'Pantalones holgados de estilo brutalista y estética underground para caminar por el vacío.',
                    'en' => 'Loose fit brutalist style pants with underground aesthetics for walking the void.'
                ],
                'sku' => 'LYD-PTS-VOD',
                'price' => 375000.00,
                'stock' => 20,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBpd74_Fbl-nsIWnM2od-Tuu3RGZnvjINnkNMati83l5jNXk_f_xiROWkp2_FJ2lUHXBnlT2kw2O3AvCleeS2peeXf6UJtaNt0kaRN6QM9fZMq4ao3uMVTeli-hqUSivcLZIwnWsGLeDQhFeH8U8kU5yLuocIdm4pmeJbigNq1k44rS0QKhYxj35V2S31NI0TS1UNMaQgluw5BuJU-2cHEDRx88ZjaJFZcNnsSlxN4Bm5TR4ZmCPhTHTtXxgMi4K35BmVThqBv_unUw',
            ],
            [
                'name' => [
                    'es' => 'BLOODLINE DENIM',
                    'en' => 'BLOODLINE DENIM'
                ],
                'slug' => 'bloodline-denim',
                'description' => [
                    'es' => 'Denim de primera calidad con detalles en rojo sangre y un ajuste holgado diseñado para durar.',
                    'en' => 'Premium denim featuring blood-red accents and a baggy fit built to last.'
                ],
                'sku' => 'LYD-DNM-BLD',
                'price' => 550000.00,
                'stock' => 12,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBcjtbyo0Xf_wiMUtTF99JJ5vmBzVr-0fHgPoUv592XjKan7dWs7HuomVd5P69ji_xe5XU7K0WSlgBT6Ruy5ajBzO-0XCEWtLCsDbTmDjlHeesqjwruTvUQ-GwdBWfPQqWZM6hWpKt3E2js_5m615d0FNKY7wHY3YS4C69js_1eJGjrwjS8ip66Y-WRomG1pIKWLrQ_rawgvxG9S-hp2Rt_ygZdJcYGkjWN1gkpD49iMn-rph_HzB4t9oClsmp_6D-3ytks7iRbem90',
            ],
            [
                'name' => [
                    'es' => 'REMERÓN BOXFIT',
                    'en' => 'REMERÓN BOXFIT'
                ],
                'slug' => 'remeron-boxfit',
                'description' => [
                    'es' => 'Remera boxy fit pesada de algodón con diseño brutalista impreso en el pecho.',
                    'en' => 'Heavy cotton boxy fit t-shirt with brutalist graphic printed on the chest.'
                ],
                'sku' => 'LYD-TEE-BXF',
                'price' => 240000.00,
                'stock' => 15,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDc3H3FSWA3yWW9JuDKuw-GfzN0uYTZIAKDPLDCvvzwBMUornG3_CDGCqY7ZBEyef3L6ZjALp1_LTKYU4FxTPbGqNqOKmygYguFztLAEsSMbZCW9BPusT1hd0copgjn5KWzZzB3IVmPZ0HMtO8X6lZuLH77h5EoJu2dV1xXDGdKyl6LMrvZuOr1G-Xx1S_sUDdj-a2saO8urclxjs1LN-SLzWM27fcVnv0NoVpOOTX7IMNz3kqYPc-dviLn18irKSgFda6SwY6OUkht',
            ],
            [
                'name' => [
                    'es' => 'TEE SPIDERWEB OVERSIZE',
                    'en' => 'TEE SPIDERWEB OVERSIZE'
                ],
                'slug' => 'tee-spiderweb-oversize',
                'description' => [
                    'es' => 'Remera oversized negra con un gráfico distressed de telaraña blanca y tribal. Estética underground.',
                    'en' => 'Oversized black t-shirt featuring a distressed white spiderweb and tribal graphic. Underground aesthetic.'
                ],
                'sku' => 'LYD-TEE-SPW',
                'price' => 140000.00,
                'stock' => 30,
                'image_path' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAjYIUsIMtQk2ql4ErWmcPTazG6Wx9zOitJC-lK4xU36aM1GmFDkvdhgDNt6x0yu5tgcRwDm7lWraBosc6BsJi--Qa4FYRj8d3GwRtbHg9G8BY-nGMXiAsJ6WDU8tQ4TQASevGGCMMYbd9wWjynnedFRYPXlVdLps0hi-lz18mnpbD792-6cbhazi4N7eB6rTWCKl4CCs6GximHxcIscfYyzv6ZXD5nNZ3X40e04u4smImaSPIYnlykj5rC3KKFnLTzU5UnLESYG7Fv',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['sku' => $product['sku']],
                $product + ['is_active' => true],
            );
        }
    }
}
