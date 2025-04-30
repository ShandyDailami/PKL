<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Jenis extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Router'],
            ['nama' => 'Switch'],
            ['nama' => 'Access Point'],
        ];
        $this->db->table('jenis')->insertBatch($data);
    }
}