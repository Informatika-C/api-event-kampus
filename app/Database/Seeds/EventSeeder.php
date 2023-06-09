<?php

namespace App\Database\Seeds;

use App\Models\EventModel;
use CodeIgniter\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Event 1',
                'keterangan' => 'Keterangan event 1',
                'tanggal' => '2021-01-01',
                'tempat' => 'Tempat event 1',
                'penanggung_jawab' => 'Penanggung jawab event 1',
                'gambar_poster' => 'event-1-poster.jpg',
                'gambar_banner' => 'event-1-banner.jpg'
            ],
            [
                'nama' => 'Event 2',
                'keterangan' => 'Keterangan event 2',
                'tanggal' => '2021-02-02',
                'tempat' => 'Tempat event 2',
                'penanggung_jawab' => 'Penanggung jawab event 2',
                'gambar_poster' => 'event-2-poster.jpg',
                'gambar_banner' => 'event-2-banner.jpg'
            ],
            [
                'nama' => 'Event 3',
                'keterangan' => 'Keterangan event 3',
                'tanggal' => '2021-03-03',
                'tempat' => 'Tempat event 3',
                'penanggung_jawab' => 'Penanggung jawab event 3',
                'gambar_poster' => 'event-3-poster.jpg',
                'gambar_banner' => 'event-3-banner.jpg'
            ],
            [
                'nama' => 'Event 4',
                'keterangan' => 'Keterangan event 4',
                'tanggal' => '2021-04-04',
                'tempat' => 'Tempat event 4',
                'penanggung_jawab' => 'Penanggung jawab event 4',
                'gambar_poster' => 'event-4-poster.jpg',
                'gambar_banner' => 'event-4-banner.jpg'
            ]
        ];

        $model = new EventModel();
        if(!$model->insertBatch($data)){
            echo "Gagal menambahkan data event.";
            throw new \CodeIgniter\Database\Exceptions\DatabaseException('Gagal menambahkan data event.');
        }
    }
}
