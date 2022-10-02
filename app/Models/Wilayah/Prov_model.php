<?php

namespace App\Models\Wilayah;

use CodeIgniter\Model;

class Prov_model extends Model
{
    protected $table = 'wil_prov';
    protected $primaryKey = 'id_prov';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama'];
}
