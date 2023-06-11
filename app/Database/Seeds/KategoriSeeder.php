<?php

namespace App\Database\Seeds;

use App\Models\KategoriModel;
use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_event' => 1,
                'kategori' => 'Web Design',
                'pendaftaran' => '2021-01-01',
                'jam_awal_pendaftaran' => '2021-01-01 00:00:00',
                'jam_akhir_pendaftaran' => '2021-01-01 23:59:59',
                'penyisihan' => '2021-01-01',
                'jam_awal_penyisihan' => '2021-01-01 00:00:00',
                'jam_akhir_penyisihan' => '2021-01-01 23:59:59',
                'pengumuman' => '2021-01-01',
                'final' => '2021-01-01',
            ],
            [
                'id_event' => 2,
                'kategori' => 'Programming',
                'pendaftaran' => '2021-01-01',
                'jam_awal_pendaftaran' => '2021-01-01 00:00:00',
                'jam_akhir_pendaftaran' => '2021-01-01 23:59:59',
                'penyisihan' => '2021-01-01',
                'jam_awal_penyisihan' => '2021-01-01 00:00:00',
                'jam_akhir_penyisihan' => '2021-01-01 23:59:59',
                'pengumuman' => '2021-01-01',
                'final' => '2021-01-01',
            ],
            [
                'id_event' => 3,
                'kategori' => 'UI/UX',
                'pendaftaran' => '2021-01-01',
                'jam_awal_pendaftaran' => '2021-01-01 00:00:00',
                'jam_akhir_pendaftaran' => '2021-01-01 23:59:59',
                'penyisihan' => '2021-01-01',
                'jam_awal_penyisihan' => '2021-01-01 00:00:00',
                'jam_akhir_penyisihan' => '2021-01-01 23:59:59',
                'pengumuman' => '2021-01-01',
                'final' => '2021-01-01',
            ],
            [
                'id_event' => 4,
                'kategori' => 'Mobile Apps',
                'pendaftaran' => '2021-01-01',
                'jam_awal_pendaftaran' => '2021-01-01 00:00:00',
                'jam_akhir_pendaftaran' => '2021-01-01 23:59:59',
                'penyisihan' => '2021-01-01',
                'jam_awal_penyisihan' => '2021-01-01 00:00:00',
                'jam_akhir_penyisihan' => '2021-01-01 23:59:59',
                'pengumuman' => '2021-01-01',
                'final' => '2021-01-01',
            ],
            [
                'id_event' => 5,
                'kategori' => 'Network Security',
                'pendaftaran' => '2021-01-01',
                'jam_awal_pendaftaran' => '2021-01-01 00:00:00',
                'jam_akhir_pendaftaran' => '2021-01-01 23:59:59',
                'penyisihan' => '2021-01-01',
                'jam_awal_penyisihan' => '2021-01-01 00:00:00',
                'jam_akhir_penyisihan' => '2021-01-01 23:59:59',
                'pengumuman' => '2021-01-01',
                'final' => '2021-01-01',
            ],
        ];

        $model = new KategoriModel();
        if(!$model->insertBatch($data)){
            echo "Gagal menambahkan data event.";
            throw new \CodeIgniter\Database\Exceptions\DatabaseException('Gagal menambahkan data event.');
        }
    }
}
