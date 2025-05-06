<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Inventaris extends Migration
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
            'jenis_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'merek' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'autentikasi_perangkat_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'kondisi_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'lokasi_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('status_id', 'status', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kondisi_id', 'kondisi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jenis_id', 'jenis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('autentikasi_perangkat_id', 'autentikasi_perangkat', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lokasi_id', 'lokasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventaris');
    }

    public function down()
    {
        $this->forge->dropTable('inventaris');
    }
}
