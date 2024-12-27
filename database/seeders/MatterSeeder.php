<?php

namespace Database\Seeders;

use App\Models\Matter;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MatterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Matter::create(['name' => 'Pendidikan', 'slug' => Str::slug('Pendidikan'), 'desc' => 'Urusan yang berkaitan dengan penyelenggaraan pendidikan formal dan nonformal, serta pemerataan akses pendidikan.']);
        Matter::create(['name' => 'Pertanian', 'slug' => Str::slug('Pertanian'), 'desc' => 'Urusan yang mengatur kebijakan, program, dan kegiatan dalam bidang pertanian untuk meningkatkan produksi dan kesejahteraan petani.']);
        Matter::create(['name' => 'Keuangan', 'slug' => Str::slug('Keuangan'), 'desc' => 'Urusan yang mencakup pengelolaan anggaran, pendapatan, dan belanja negara maupun daerah.']);
        Matter::create(['name' => 'Kebudayaan', 'slug' => Str::slug('Kebudayaan'), 'desc' => 'Urusan yang berfokus pada pelestarian, pengembangan, dan promosi kebudayaan lokal dan nasional.']);
        Matter::create(['name' => 'UMKM', 'slug' => Str::slug('UMKM'), 'desc' => 'Urusan yang mendukung pengembangan usaha mikro, kecil, dan menengah untuk meningkatkan perekonomian masyarakat.']);
        Matter::create(['name' => 'Industri', 'slug' => Str::slug('Industri'), 'desc' => 'Urusan yang mengelola kebijakan dan pengembangan sektor industri untuk mendorong pertumbuhan ekonomi.']);
        Matter::create(['name' => 'Kepemudaan', 'slug' => Str::slug('Kepemudaan'), 'desc' => 'Urusan yang mendukung pemberdayaan dan pengembangan potensi pemuda dalam berbagai bidang.']);
        Matter::create(['name' => 'Kesehatan', 'slug' => Str::slug('Kesehatan'), 'desc' => 'Urusan yang berkaitan dengan pelayanan kesehatan, pengendalian penyakit, dan promosi kesehatan masyarakat.']);
        Matter::create(['name' => 'Lingkungan Hidup', 'slug' => Str::slug('Lingkungan Hidup'), 'desc' => 'Urusan yang meliputi pelestarian dan pengelolaan lingkungan untuk menjaga keseimbangan ekosistem.']);
        Matter::create(['name' => 'Transportasi', 'slug' => Str::slug('Transportasi'), 'desc' => 'Urusan yang mengatur sarana, prasarana, dan sistem transportasi untuk mendukung mobilitas masyarakat.']);
        Matter::create(['name' => 'Pariwisata', 'slug' => Str::slug('Pariwisata'), 'desc' => 'Urusan yang mengelola pengembangan destinasi wisata, promosi, dan perlindungan budaya lokal sebagai daya tarik wisata.']);
        Matter::create(['name' => 'Energi dan Sumber Daya Mineral', 'slug' => Str::slug('Energi dan Sumber Daya Mineral'), 'desc' => 'Urusan yang mengatur pengelolaan energi, pertambangan, dan sumber daya mineral untuk kebutuhan nasional.']);
        Matter::create(['name' => 'Ketahanan Pangan', 'slug' => Str::slug('Ketahanan Pangan'), 'desc' => 'Urusan yang memastikan ketersediaan, akses, dan konsumsi pangan yang berkelanjutan bagi masyarakat.']);
        Matter::create(['name' => 'Perdagangan', 'slug' => Str::slug('Perdagangan'), 'desc' => 'Urusan yang mengelola kebijakan ekspor, impor, dan perdagangan domestik untuk mendukung pertumbuhan ekonomi.']);
        Matter::create(['name' => 'Perhubungan', 'slug' => Str::slug('Perhubungan'), 'desc' => 'Urusan yang berkaitan dengan transportasi darat, laut, udara, serta sistem komunikasi publik.']);
        Matter::create(['name' => 'Perumahan dan Permukiman', 'slug' => Str::slug('Perumahan dan Permukiman'), 'desc' => 'Urusan yang mengatur pembangunan perumahan dan pemukiman untuk masyarakat, termasuk pengelolaan fasilitas umum.']);
        Matter::create(['name' => 'Telekomunikasi dan Informatika', 'slug' => Str::slug('Telekomunikasi dan Informatika'), 'desc' => 'Urusan yang mengelola teknologi informasi dan komunikasi untuk mendukung pelayanan publik dan akses informasi.']);
        Matter::create(['name' => 'Pertanahan', 'slug' => Str::slug('Pertanahan'), 'desc' => 'Urusan yang meliputi pengelolaan dan pengaturan hak atas tanah untuk keperluan publik maupun individu.']);
        Matter::create(['name' => 'Kependudukan dan Catatan Sipil', 'slug' => Str::slug('Kependudukan dan Catatan Sipil'), 'desc' => 'Urusan yang mengelola administrasi kependudukan seperti KTP, akta kelahiran, dan statistik penduduk.']);
        Matter::create(['name' => 'Tenaga Kerja', 'slug' => Str::slug('Tenaga Kerja'), 'desc' => 'Urusan yang berkaitan dengan perlindungan tenaga kerja, pelatihan kerja, dan hubungan industrial.']);
        Matter::create(['name' => 'Sosial', 'slug' => Str::slug('Sosial'), 'desc' => 'Urusan yang meliputi pelayanan sosial, bantuan kepada masyarakat miskin, serta pemberdayaan komunitas rentan.']);
        Matter::create(['name' => 'Hukum dan Hak Asasi Manusia (HUM-HAM)', 'slug' => Str::slug('Hukum dan Hak Asasi Manusia (HAM)'), 'desc' => 'Urusan yang mencakup penegakan hukum, perlindungan hak asasi manusia, dan pembinaan kesadaran hukum masyarakat.']);
        Matter::create(['name' => 'Penanggulangan Bencana', 'slug' => Str::slug('Penanggulangan Bencana'), 'desc' => 'Urusan yang mengatur mitigasi, respons, dan rehabilitasi pasca-bencana untuk melindungi masyarakat.']);
        Matter::create(['name' => 'Keamanan dan Ketertiban Umum', 'slug' => Str::slug('Keamanan dan Ketertiban Umum'), 'desc' => 'Urusan yang menjamin keamanan, ketertiban, dan perlindungan masyarakat dari ancaman.']);
        Matter::create(['name' => 'Pertahanan', 'slug' => Str::slug('Pertahanan'), 'desc' => 'Urusan yang berfokus pada pertahanan negara untuk menjaga kedaulatan dan keutuhan wilayah.']);
        Matter::create(['name' => 'Perikanan dan Kelautan', 'slug' => Str::slug('Perikanan dan Kelautan'), 'desc' => 'Urusan yang mencakup pengelolaan sumber daya laut dan pemberdayaan nelayan untuk ekonomi maritim.']);        
    }
}
