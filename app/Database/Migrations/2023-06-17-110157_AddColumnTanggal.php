<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnTanggal extends Migration
{
    public function up()
    {
        //add created_at on peserta_kategori table
        $this->forge->addColumn('peserta_kategori', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'id_kategori',
            ],
        ]);
    }

    public function down()
    {
        // drop created_at on peserta_kategori table
        $this->forge->dropColumn('peserta_kategori', 'created_at');
    }
}
