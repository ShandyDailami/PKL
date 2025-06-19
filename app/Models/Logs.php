<?php

namespace App\Models;

use CodeIgniter\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $allowedFields = [
        'inventaris_id',
        'aktivitas',
        'deskripsi',
        'gambar',
        'waktu',
        'status'
    ];

    public function dataJoin($statusId = null)
    {
        return $this->select(
            'logs.*, 
            inventaris.*, 
            kondisi.*,
            kondisi.nama AS kondisi_nama,
            status.nama AS status_nama'
        )
            ->join('inventaris', 'inventaris.id = logs.inventaris_id')
            ->join('kondisi', 'kondisi.id = inventaris.kondisi_id')
            ->join('status', 'status.id = inventaris.status_id');

        if ($statusId !== null) {
            $builder->where('inventaris.status_id', $statusId);
        }

        return $builder;
    }
}
