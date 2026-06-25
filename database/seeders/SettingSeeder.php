<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'bank_holder' => 'LYDAM Store',
            'bank_name' => 'Banco de la Nación Argentina',
            'bank_cbu' => '0000003100098765432101',
            'bank_alias_1' => 'LYDAM.TRIBAL.UNO',
            'bank_alias_2' => 'LYDAM.TRIBAL.DOS',
            'bank_threshold' => '300000',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
