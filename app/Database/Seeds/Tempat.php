<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Tempat extends Seeder
{
    public function run()
    {
        $data = [
            ['nama' => 'Command Center'],
            ['nama' => 'Prodi Teknik Pertambangan'],
            ['nama' => 'Ruang Kesehatan'],
            ['nama' => 'Ruang Baca'],
            ['nama' => 'Prodi Teknik Sipil'],
            ['nama' => 'Lab. Terpadu Teknik Kimia'],
            ['nama' => 'Prodi Teknik Mesin'],
            ['nama' => 'Prodi Teknik Lingkungan'],
            ['nama' => 'Prodi Magister Teknik Kimia'],
            ['nama' => 'Lab. Teknik Mesin'],
            ['nama' => 'Lab. Teknik Pertambangan'],
            ['nama' => 'Lab Manajemen Lingkungan'],
            ['nama' => 'Lab. Proses Teknik Kimia'],
            ['nama' => 'Prodi Arsitektur'],
            ['nama' => 'Ruang Layanan Administrasi'],
            ['nama' => 'Ruang Dekan - Wakil Dekan'],
            ['nama' => 'Ruang Rapat'],
            ['nama' => 'Ruang ULAT '],
            ['nama' => 'Prodi Elektro'],
            ['nama' => 'Prodi Geologi'],
            ['nama' => 'Ruang Aula II'],
            ['nama' => 'Prodi Teknik Kimia'],
            ['nama' => 'Lab. Teknik Mesin'],
            ['nama' => 'Lab. Teknik Pertambangan'],
            ['nama' => 'Ruang Lab. Studio'],
        ];
        $this->db->table('tempat')->insertBatch($data);
    }
}
