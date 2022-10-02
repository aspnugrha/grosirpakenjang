<?php

namespace App\Models;

use CodeIgniter\Model;

class Akun_detail_model extends Model
{
    protected $table = 'akun_detail';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_akun', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'foto_ktp', 'foto_verifikasi_ktp', 'status_ktp', 'alamat', 'id_kel', 'id_kec', 'id_kab', 'id_prov', 'created_at', 'updated_at'];
}
