<?php

namespace App\Models;

use CodeIgniter\Model;

class Jenis extends Model
{
    protected $table = 'jenis';
    protected $allowedFields = [
        'nama',
    ];
}