<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AutentikasiPerangkat extends Migration
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
            'SSID' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('autentikasi_perangkat');
    }

    public function down()
    {
        $this->forge->dropTable('autentikasi_perangkat');
    }
}
