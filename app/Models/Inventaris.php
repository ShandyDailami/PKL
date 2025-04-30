<?php

namespace App\Models;

use CodeIgniter\Model;

class Inventaris extends Model
{
    const KONDISI_JARINGAN = 1;
    const KONDISI_INVENTARIS = 2;
    protected $table = 'inventaris';
    protected $allowedFields = [
        'tempat',
        'jenis_id',
        'tipe',
        'nama',
        'password',
        'gambar',
        'kondisi_id',
        'status_id',
        'kuantitas',
        'latitude',
        'longitude',
        'lantai'
    ];

    public function dataJoin()
    {
        return $this->select('inventaris.*, kondisi.nama AS kondisi_nama, jenis.nama AS jenis_nama, status.nama AS status_nama')
            ->join('kondisi', 'kondisi.id = inventaris.kondisi_id')
            ->join('jenis', 'jenis.id = inventaris.jenis_id')
            ->join('status', 'status.id = inventaris.status_id');
    }
}
