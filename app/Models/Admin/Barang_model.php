<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Barang_model extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['id_jenis_barang', 'foto_barang', 'nama_barang', 'stok', 'harga', 'c_id', 'u_id', 'created_at', 'updated_at'];

    public function load_barang($urutan, $jenis, $search, $kondisi = false)
    {
        $this->select('barang.*, jenis_barang.id as id_jenis_barang, jenis_barang.jenis');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        if (!empty($urutan)) {
            if ($urutan == 'a-z') {
                $this->orderBy('barang.nama_barang', 'ASC');
            } else if ($urutan == 'z-a') {
                $this->orderBy('barang.nama_barang', 'DESC');
            } else if ($urutan == 'terbaru') {
                $this->orderBy('barang.created_at', 'DESC');
            } else if ($urutan == 'terlama') {
                $this->orderBy('barang.created_at', 'ASC');
            }
        }
        if (!empty($jenis)) {
            $this->where('id_jenis_barang', $jenis);
        }

        if (!empty($search)) {
            $this->like('barang.nama_barang', $search);
            $this->orLike('barang.harga', $search);
        }
        if (!empty($kondisi)) {
            if ($kondisi == 'user') {
                $this->where('barang.stok > 0');
            }
        }
        return $this->findAll();
    }
}
