<?php

namespace App\Models;

use CodeIgniter\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $allowedFields = [
        'nama'
    ];
}
