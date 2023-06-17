<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldTipe extends Migration
{
    public function up()
    {
        // add column tipe in table event
        $this->forge->addColumn('event', [
            'tipe' => [
                'type' => 'ENUM',
                'constraint' => ['akademik', 'non-akademik'],
                'after' => 'nama_event'
            ]
        ]);
    }

    public function down()
    {
        // drop column tipe in table event
        $this->forge->dropColumn('event', 'tipe');
    }
}
