<?php

namespace App\Models\Wilayah;

use CodeIgniter\Model;

class Kokab_model extends Model
{
    protected $table = 'wil_kab';
    protected $primaryKey = 'id_kab';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_prov', 'nama'];
}
