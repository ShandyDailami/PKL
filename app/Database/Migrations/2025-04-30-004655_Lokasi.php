<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lokasi extends Migration
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
            'latitude' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'lantai' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tempat' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('lokasi');
    }

    public function down()
    {
        $this->forge->dropTable('lokasi');
    }
}
