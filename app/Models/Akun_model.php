<?php

namespace App\Models;

use CodeIgniter\Model;

class Akun_model extends Model
{
    protected $table = 'akun';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['email', 'hp', 'password', 'role', 'aktif', 'kode_aktivasi', 'profile', 'created_at', 'updated_at'];

    public function load_user($role, $search)
    {
        $this->select('akun.*, akun_detail.*');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        if ($role != null) {
            $this->where('akun.role', $role);
        }
        if ($search != null) {
            // $this->where("akun.email LIKE '%" . $search . "%' OR akun_detail.nama_lengkap LIKE  '%" . $search . "%'");
            $this->like('akun.email', $search);
            // $this->orLike('akun_detail.nama_lengkap', $search);
        }
        return $this->findAll();
    }
    public function get_join($kondisi, $id = false)
    {
        $this->select('akun.*, akun_detail.*');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        if ($kondisi == 'first') {
            $this->where('akun.id', $id);
            return $this->first();
        } else {
            return $this->findAll();
        }
    }

    function cek_login($kondisi)
    {

        if (session()->get('id') != null) {
            if ($kondisi == 'user') {
                if (session()->get('role') == 'user') {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (session()->get('role') == 'user') {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return false;
        }
    }
}
