<?php

namespace App\Models\Wilayah;

use CodeIgniter\Model;

class Kec_model extends Model
{
    protected $table = 'wil_kec';
    protected $primaryKey = 'id_kec';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_kab', 'nama'];
}
