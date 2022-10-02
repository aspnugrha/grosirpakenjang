<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Jenis_barang_model extends Model
{
    protected $table = 'jenis_barang';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['jenis', 'c_id', 'u_id', 'created_at', 'updated_at'];
}
