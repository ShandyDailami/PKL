<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Status extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Aktif'],
            ['nama' => 'Nonaktif'],
        ];
        $this->db->table('status')->insertBatch($data);
    }
}