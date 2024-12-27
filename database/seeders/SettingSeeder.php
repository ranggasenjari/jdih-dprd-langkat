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
            'appLogo'       => asset('assets/admin/images/logo-langkat.jpg'),
            'appUrl'        => url()->current(),
            'company'       => 'Pemerintah Kabupaten Langkat',
            'companyUrl'    => 'https://langkatkab.go.id',
            'address'       => 'Jl. Pusara No.1',
            'city'          => 'Langkat',
            'district'      => 'Stabat',
            'regency'       => 'Kabupaten Langkat',
            'province'      => 'Sumatera Utara',
            'zip'           => '20811',
            'phone'         => '(061) 8910525',
            'fax'           => null,
            'email'         => 'dprd@langkatkab.go.id',
            'facebook'      => 'https://www.facebook.com/dprd.langkat.31',
            'twitter'       => null,
            'instagram'     => 'https://www.instagram.com/dprdlangkat',
            'tiktok'        => 'https://www.tiktok.com/@dprdlangkat',
            'youtube'       => null,
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
