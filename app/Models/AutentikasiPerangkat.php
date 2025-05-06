<?php

namespace App\Models;

use CodeIgniter\Model;

class AutentikasiPerangkat extends Model
{
    protected $table = 'autentikasi_perangkat';
    protected $allowedFields = [
        'SSID',
        'password',
    ];
}