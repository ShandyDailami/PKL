<?php

namespace App\Models;

use CodeIgniter\Model;

class Inventaris extends Model
{
    const KONDISI_JARINGAN = 1;
    const KONDISI_INVENTARIS = 2;
    protected $table = 'inventaris';
    protected $allowedFields = [
        'user_id',
        'jenis_id',
        'kondisi_id',
        'merek',
        'autentikasi_perangkat_id',
        'gambar',
        'tanggal_perolehan',
        'status_id',
        'lokasi_id',
        'tempat_id',
    ];

    public function dataJoin()
    {
        return $this->select('inventaris.*, 
        kondisi.nama AS kondisi_nama, 
        jenis.nama AS jenis_nama, 
        status.nama AS status_nama, 
        lokasi.latitude AS latitude, 
        lokasi.longitude AS longitude,
        lokasi.lantai AS lantai, 
        tempat.nama AS tempat, 
        autentikasi_perangkat.SSID AS SSID,
        autentikasi_perangkat.password AS password')
            ->join('kondisi', 'kondisi.id = inventaris.kondisi_id')
            ->join('jenis', 'jenis.id = inventaris.jenis_id')
            ->join('status', 'status.id = inventaris.status_id')
            ->join('lokasi', 'lokasi.id = inventaris.lokasi_id', 'left')
            ->join('tempat', 'tempat.id = inventaris.tempat_id', 'left')
            ->join('autentikasi_perangkat', 'autentikasi_perangkat.id = 
            inventaris.autentikasi_perangkat_id', 'left');
    }
}
