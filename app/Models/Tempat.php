<?php

namespace App\Models;

use CodeIgniter\Model;

class Tempat extends Model
{
    protected $table = 'tempat';
    protected $allowedFields = [
        'nama'
    ];
}
