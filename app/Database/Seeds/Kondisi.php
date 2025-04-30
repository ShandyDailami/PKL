<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Kondisi extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Terpasang'],
            ['nama' => 'Tidak Terpasang'],
        ];
        $this->db->table('kondisi')->insertBatch($data);
    }
}