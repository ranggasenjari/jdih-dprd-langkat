<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'appName'       => 'JDIH DPRD Kabupaten Langkat',
            'appDesc'       => 'Jaringan Dokumentasi dan Informasi Hukum DPRD Kabupaten Langkat',
            'appLogo'       => asset('assets/admin/images/logo_icon.svg'),
            'appUrl'        => url()->current(),
            'company'       => 'Pemerintah Kabupaten Langkat',
            'companyUrl'    => 'https://langkatkab.go.id',
            'address'       => fake()->streetAddress(),
            'city'          => fake()->city(),
            'district'      => fake()->city(),
            'regency'       => fake()->city(),
            'province'      => 'Sumatera Utara',
            'zip'           => fake()->postcode(),
            'phone'         => fake()->phoneNumber(),
            'fax'           => null,
            'email'         => fake()->safeEmail(),
            'facebook'      => fake()->url(),
            'twitter'       => fake()->url(),
            'instagram'     => fake()->url(),
            'tiktok'        => fake()->url(),
            'youtube'       => fake()->url(),
            'jdihnLogo'     => asset('assets/admin/images/jdihn-logo-web.png'),
            'jdihnTitle'    => 'Jaringan Dokumentasi dan Informasi Hukum Nasional',
            'jdihnUrl'      => 'https://jdihn.go.id',
            'region_code'   => 1205,
            'maintenance'   => null,
            'questionner'   => "{\"title\":\"Indeks Kepuasan Masyarakat\",\"desc\":\"Untuk mengetahui tingkat kepuasan masyarakat terhadap layanan JDIH\",\"active\":1}",
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'key'   => $key,
                'value' => $value
            ]);
        }
    }
}
