<?php

namespace App\Models;

use CodeIgniter\Model;

class Transaksi_model extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['kode_transaksi', 'id_akun', 'id_barang', 'tgl_transaksi', 'tgl_dipesan', 'tgl_dibatalkan', 'tgl_dikonfirmasi', 'tgl_dikemas', 'tgl_siap_diambil', 'tgl_selesai', 'qty', 'status_transaksi', 'c_id', 'u_id', 'created_at', 'updated_at'];

    public function load_keranjang()
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->where('transaksi.id_akun', session()->get('id'));
        $this->where('transaksi.status_transaksi', 'keranjang');
        $this->orderBy('transaksi.created_at', 'DESC');
        return $this->findAll();
    }

    public function load_pesanan()
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->where('transaksi.id_akun', session()->get('id'));
        $this->like('transaksi.status_transaksi', 'dipesan');
        $this->orLike('transaksi.status_transaksi', 'dibatalkan');
        $this->orLike('transaksi.status_transaksi', 'dikonfirmasi');
        $this->orLike('transaksi.status_transaksi', 'dikemas');
        $this->orderBy('transaksi.created_at', 'DESC');
        return $this->findAll();
    }
    public function load_pengambilan($tgl, $urutan, $search)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        // $this->where('transaksi.id_akun');
        $this->where('transaksi.status_transaksi', 'siap_diambil');
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
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
        }
        if ($tgl != null) {
            $pisah_tgl = explode(" - ", $tgl);

            if ($pisah_tgl[0] == $pisah_tgl[1]) {
                $key = "transaksi.tgl_transaksi like '%" . date('Y-m-d', strtotime($pisah_tgl[0])) . "%'";
                $this->where($key);
            } else {
                $key1 = "date(transaksi.tgl_transaksi) between date('" . date('Y-m-d', strtotime($pisah_tgl[0])) . "') and date('" . date('Y-m-d', strtotime($pisah_tgl[1])) . "')";
                $this->where($key1);
            }
        }
        if (!empty($search)) {
            $this->like('transaksi.kode_transaksi', $search);
            $this->orLike('transaksi.tgl_dikonfirmasi', $search);
        }
        return $this->findAll();
    }
    public function load_pesanan2($tgl, $urutan)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->like('transaksi.status_transaksi', 'dikonfirmasi');
        $this->orLike('transaksi.status_transaksi', 'dikemas');
        $this->orLike('transaksi.status_transaksi', 'siap_diambil');
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
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
        }
        if ($tgl != null) {
            $pisah_tgl = explode(" - ", $tgl);

            if ($pisah_tgl[0] == $pisah_tgl[1]) {
                $key = "transaksi.tgl_dikonfirmasi = " . date('Y-m-d', strtotime($pisah_tgl[0])) . "";
                $this->where($key);
            } else {
                $key1 = "date(transaksi.tgl_dikonfirmasi) between date('" . date('Y-m-d', strtotime($pisah_tgl[0])) . "') and date('" . date('Y-m-d', strtotime($pisah_tgl[1])) . "')";
                $this->where($key1);
            }
        }
        return $this->findAll();
    }

    public function load_all_pesanan($tgl, $urutan)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->where('transaksi.status_transaksi', 'dipesan');

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
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
        }
        if ($tgl != null) {
            $pisah_tgl = explode(" - ", $tgl);

            if ($pisah_tgl[0] == $pisah_tgl[1]) {
                $key = "transaksi.tgl_transaksi like '%" . date('Y-m-d', strtotime($pisah_tgl[0])) . "%'";
                $this->where($key);
            } else {
                $key1 = "date(transaksi.tgl_transaksi) between date('" . date('Y-m-d', strtotime($pisah_tgl[0])) . "') and date('" . date('Y-m-d', strtotime($pisah_tgl[1])) . "')";
                $this->where($key1);
            }
        }
        return $this->findAll();
    }

    public function load_selesai($tgl, $urutan, $search)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        // $this->where('transaksi.id_akun');
        $this->where('transaksi.status_transaksi', 'selesai');
        if (!empty($search)) {
            $this->like('transaksi.kode_transaksi', $search);
            $this->orLike('transaksi.tgl_dikonfirmasi', $search);
        }
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
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
        }
        if ($tgl != null) {
            $pisah_tgl = explode(" - ", $tgl);

            if ($pisah_tgl[0] == $pisah_tgl[1]) {
                $key = "transaksi.tgl_transaksi like '%" . date('Y-m-d', strtotime($pisah_tgl[0])) . "%'";
                $this->where($key);
            } else {
                $key1 = "date(transaksi.tgl_transaksi) between date('" . date('Y-m-d', strtotime($pisah_tgl[0])) . "') and date('" . date('Y-m-d', strtotime($pisah_tgl[1])) . "')";
                $this->where($key1);
            }
        }
        return $this->findAll();
    }

    public function get_join($kondisi, $id = false)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->where('transaksi.status_transaksi', 'dipesan');
        $this->where('transaksi.id_akun', $id);
        if ($kondisi == 'first') {
            return $this->first();
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
            return $this->findAll();
        }
    }

    public function get_join2($kondisi, $id = false)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->like('transaksi.status_transaksi', 'dikonfirmasi');
        $this->orLike('transaksi.status_transaksi', 'dikemas');
        $this->orLike('transaksi.status_transaksi', 'siap_diambil');
        $this->where('transaksi.id_akun', $id);
        if ($kondisi == 'first') {
            return $this->first();
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
            return $this->findAll();
        }
    }
    public function get_join_pengambilan($kondisi, $id = false)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->where('transaksi.status_transaksi', 'siap_diambil');
        $this->where('transaksi.id_akun', $id);
        if ($kondisi == 'first') {
            return $this->first();
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
            return $this->findAll();
        }
    }

    public function get_join_selesai($kondisi, $kode = false)
    {
        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->where('transaksi.status_transaksi', 'selesai');
        // $this->where('transaksi.id_akun', $id);
        $this->where('transaksi.kode_transaksi', $kode);
        if ($kondisi == 'first') {
            return $this->first();
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
            return $this->findAll();
        }
    }

    public function get_join_selesai_user($kondisi, $id_pesanan)
    {
        $get = $this->where('id', $id_pesanan)->first();

        $this->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap');
        $this->join('barang', 'barang.id = transaksi.id_barang');
        $this->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang');
        $this->join('akun', 'akun.id = transaksi.id_akun');
        $this->join('akun_detail', 'akun_detail.id_akun = akun.id');
        $this->where('transaksi.status_transaksi', 'selesai');
        $this->where('transaksi.kode_transaksi', $get['kode_transaksi']);
        if ($kondisi == 'first') {
            return $this->first();
        } else {
            $this->orderBy('transaksi.created_at', 'DESC');
            return $this->findAll();
        }
    }

    public function bandingkan($id_barang, $filter_tgl = false)
    {
        $this->where('id_barang', $id_barang);
        $this->where('status_transaksi', 'selesai');
        if ($filter_tgl != null) {
            $pisah_tgl = explode(" - ", $filter_tgl);

            if ($pisah_tgl[0] == $pisah_tgl[1]) {
                $key = "tgl_transaksi like '%" . date('Y-m-d', strtotime($pisah_tgl[0])) . "%'";
                $this->where($key);
            } else {
                $key1 = "date(tgl_transaksi) between date('" . date('Y-m-d', strtotime($pisah_tgl[0])) . "') and date('" . date('Y-m-d', strtotime($pisah_tgl[1])) . "')";
                $key2 = "";
                $key2 = "tgl_transaksi <= '%" . date('Y-m-d', strtotime($pisah_tgl[1])) . "%'";
                $this->where($key1);
            }
        }
        return $this->findAll();
    }

    public function makeKodeTransaksi()
    {
        $get = $this->orderBy('kode_transaksi', 'DESC')->first();

        $cek = $this->where(['id_akun' => session()->get('id'), 'status_transaksi' => 'keranjang'])->findAll();

        if (count($cek) > 0) {
            $kode   = $cek[0]['kode_transaksi'];
            $pisah  = explode('.', $kode);
            $number = $pisah[2];

            $kode = 'TR.' . date('YmdHis') . '.' . $number;

            // update kode
            foreach ($cek as $c) {
                $data = [
                    'id'                => $c['id'],
                    'kode_transaksi'    => $kode,
                ];
                $this->save($data);
            }
        } else {
            if ($get != null) {
                $pisah = explode('.', $get['kode_transaksi']);
                $tambah = $pisah[2] + 1;
            } else {
                $tambah = 1;
            }

            if (strlen($tambah) == 1) {
                $new_number = '0000' . $tambah;
            } else if (strlen($tambah) == 2) {
                $new_number = '000' . $tambah;
            } else if (strlen($tambah) == 3) {
                $new_number = '00' . $tambah;
            } else if (strlen($tambah) == 4) {
                $new_number = '0' . $tambah;
            } else if (strlen($tambah) == 5) {
                $new_number = $tambah;
            }

            $kode = 'TR.' . date('YmdHis') . '.' . $new_number;
        }
        return $kode;
    }
}
