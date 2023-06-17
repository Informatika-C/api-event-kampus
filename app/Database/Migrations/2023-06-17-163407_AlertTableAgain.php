<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlertTableAgain extends Migration
{
    public function up()
    {
        $fields = [
            'final' => [
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
