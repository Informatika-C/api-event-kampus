<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCostumColumUser extends Migration
{
    public function up()
    {
        $fields = [
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'npm' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'nama');
        $this->forge->dropColumn('users', 'npm');
        $this->forge->dropColumn('users', 'no_hp');
    }
}
