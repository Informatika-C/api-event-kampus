<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKategoriTable extends Migration
{
    public function up()
    {
        // make kategori table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'id_event' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'pendaftaran' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'jam_awal_pendaftaran' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'jam_akhir_pendaftaran' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'penyisihan' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'jam_awal_penyisihan' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'jam_akhir_penyisihan' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'pengumuman' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'final' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        // drop kategori table
        $this->forge->dropTable('kategori');
    }
}
