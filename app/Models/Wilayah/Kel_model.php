<?php

namespace App\Models\Wilayah;

use CodeIgniter\Model;

class Kel_model extends Model
{
    protected $table = 'wil_kel';
    protected $primaryKey = 'id_kel';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_kec', 'nama'];
}
