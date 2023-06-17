<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlertKategori extends Migration
{
    public function up()
    {
        $fields = [
            'pendaftaran' => [
                'type' => 'DATE',
            ],
            'penyisihan' => [
                'type' => 'DATE',
            ],
        ];
        $this->forge->modifyColumn('kategori', $fields);
    }

    public function down()
    {
        //
    }
}
