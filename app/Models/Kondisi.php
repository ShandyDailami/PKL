<?php

namespace App\Models;

use CodeIgniter\Model;

class Kondisi extends Model
{
    protected $table = 'kondisi';
    protected $allowedFields = [
        'nama'
    ];
}
