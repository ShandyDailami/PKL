<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Inventaris extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tempat' => 'Prodi Sipil',
                'jenis_id' => 3,
                'tipe' => 'Ubiquiti',
                'nama' => 'FT-ItuKeren01',
                'password' => '123345456',
                'gambar' => 'AccessPoint1.jpg',
                'kondisi_id' => 1,
                'status_id' => 1,
                'kuantitas' => '1',
                'latitude' => '-3.44574',
                'longitude' => '114.840613',
                'lantai' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tempat' => 'Lab. Kimia',
                'jenis_id' => 2,
                'tipe' => 'Ubiquiti',
                'nama' => '-',
                'password' => '-',
                'gambar' => 'Switch1.jpg',
                'kondisi_id' => 2,
                'status_id' => 1,
                'kuantitas' => '1',
                'latitude' => '-3.44574',
                'longitude' => '114.840613',
                'lantai' => '1',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('inventaris')->insertBatch($data);
    }
}