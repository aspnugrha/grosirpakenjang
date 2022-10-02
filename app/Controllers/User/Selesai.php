<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\Admin\Barang_model;
use App\Models\Admin\Jenis_barang_model;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;
use App\Models\Transaksi_model;

class Selesai extends BaseController
{
    public function __construct()
    {
        $this->akunModel          = new Akun_model();
        $this->akunDetailModel    = new Akun_detail_model();
        $this->barangModel        = new Barang_model();
        $this->jenisBarangModel   = new Jenis_barang_model();
        $this->transaksiModel     = new Transaksi_model();

        // email
        $this->email              = \Config\Services::email();
        helper(['form', 'url']);
    }

    public function index()
    {
        if ($this->akunModel->cek_login('user')) {
            $data = [
                'menu'          => 'pesanan',
                'content'       => 'user/selesai/selesai',
                'content_foot'  => [
                    'user/selesai/content_foot/cf_selesai',
                    'universal_foot/cf_toastr',
                ],
                'jenis_barang'  => $this->jenisBarangModel->findAll(),
            ];
            return view('user/layouts/wrapper', $data);
        } else {
            return redirect()->to('/login');
        }
    }

    // ajax

    public function load_pesanan_selesai()
    {
        $list = $this->transaksiModel->where(['status_transaksi' => 'selesai', 'id_akun' => session()->get('id')])->findAll();

        $kode = [];
        if (count($list) > 0) {
            $kode = array_unique(array_column($list, 'kode_transaksi'));
        }

        $data = array();
        $no = 0;
        $total_harga = 0;

        foreach ($kode as $rows) {
            $pesanan = $this->transaksiModel->where('kode_transaksi', $rows)->first();
            // dd($pesanan);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pesanan['kode_transaksi'];
            $row[] = '<span class="mx-2">' . date('d F Y', strtotime($pesanan['tgl_dikonfirmasi'])) . '</span>';
            $row[] = '<a class="btn btn-primary btn-sm" onclick="lihat_pesanan(`' . $pesanan['id'] . '`)"><i class="mdi mdi-magnify"></i> Lihat Pesanan</a>';

            $data[] = $row;

            // $total_harga = $total_harga + $rows['qty'] * $rows['harga'];
        }

        $output = array(
            "data" => $data,
            // "total_harga" => "Rp " . number_format($total_harga, 0, ',', '.'),
        );
        echo json_encode($output);
    }

    public function load_list_pesanan_selesai()
    {
        $id_pesanan = $this->request->getVar('id_pesanan');
        $list   = $this->transaksiModel->get_join_selesai_user('findAll', $id_pesanan);

        $data = array();
        $no = 0;
        $total_harga = 0;

        foreach ($list as $rows) {
            $total = 0;
            $total = $total + $rows['qty'] * $rows['harga'];

            if ($rows['foto_barang'] != null) {
                $foto = '<img src="/assets/upload/admin/foto_barang/' . $rows['foto_barang'] . '" class="mr-3 img-fluid rounded" style="width: 150px;">';
            } else {
                $foto = '<img class="mr-3 rounded img-fluid" style="width: 150px;" src="/assets/img/kosong/img-kosong.jpg" >';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $foto;
            $row[] = $rows['nama_barang'];
            $row[] = $rows['qty'];
            $row[] = "Rp " . number_format($total, 0, ',', '.');
            $data[] = $row;

            $total_harga = $total_harga + $total;
        }

        $output = array(
            "data" => $data,
            "total_harga" => $total_harga,
        );
        echo json_encode($output);
    }

    public function cek_total_harga_selesai($id)
    {
        $list = $this->transaksiModel->get_join_selesai_user('findAll', $id);

        $total_harga = 0;
        if (count($list) > 0) {
            foreach ($list as $l) {
                $total = $l['qty'] * $l['harga'];
                $total_harga = $total_harga + $total;
            }
        }

        echo json_encode("Rp " . number_format($total_harga, 0, ',', '.'));
    }
}
