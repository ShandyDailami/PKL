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
            'tempat' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'jenis_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tipe' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255
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
            'kuantitas' => [
                'type' => 'VARCHAR',
                'constraint' => 255
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
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('status_id', 'status', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kondisi_id', 'kondisi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('jenis_id', 'jenis', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inventaris');
    }

    public function down()
    {
        $this->forge->dropTable('inventaris');
    }
}
