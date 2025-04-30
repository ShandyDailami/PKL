<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jenis extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('jenis');
    }

    public function down()
    {
        $this->forge->dropTable('jenis');
    }
}
