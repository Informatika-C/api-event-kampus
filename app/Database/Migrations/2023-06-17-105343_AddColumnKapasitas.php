<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnKapasitas extends Migration
{
    public function up()
    {
        // add column kapasitas on kategori table
        $this->forge->addColumn('kategori', [
            'kapasitas' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'final',
            ],
        ]);
    }

    public function down()
    {
        // drop column kapasitas on kategori table
        $this->forge->dropColumn('kategori', 'kapasitas');
    }
}
