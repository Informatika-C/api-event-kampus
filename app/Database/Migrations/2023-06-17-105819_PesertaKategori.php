<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PesertaKategori extends Migration
{
    public function up()
    {
        //make table peserta_kategori
        $this->forge->addField([
            'id_peserta_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_kategori' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id_peserta_kategori', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peserta_kategori');
    }

    public function down()
    {
        // drop table peserta_kategori
        $this->forge->dropTable('peserta_kategori');
    }
}
