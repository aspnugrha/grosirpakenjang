<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Barang_model;
use App\Models\Admin\Jenis_barang_model;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;
use App\Models\Transaksi_model;

class Pengambilan extends BaseController
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
    }

    public function index()
    {
        $data = [
            'menu'          => 'penjualan',
            'submenu'       => 'pengambilan',
            'title'         => 'Data Pesanan (Pengambilan)',
            'content'       => 'admin/penjualan/pengambilan/pengambilan',
            'content_foot'  => [
                'admin/penjualan/pengambilan/content_foot/cf_pengambilan',
                'universal_foot/cf_toastr',
            ],
        ];
        return view('admin/layouts/wrapper', $data);
    }

    // ajax
    // pengambilan
    public function load_pengambilan()
    {
        $tgl = $this->request->getVar('tgl');
        $urutan = $this->request->getVar('urutan');
        $search = $this->request->getVar('search');

        $list   = $this->transaksiModel->load_pengambilan($tgl, $urutan, $search);

        $akun = [];
        if (count($list) > 0) {
            $akun = array_unique(array_column($list, 'id_akun'));
        }

        $data = array();
        $no = 0;
        foreach ($akun as $rows) {
            $get_akun = $this->akunModel->get_join('first', $rows);
            $pesanan = $this->transaksiModel->get_join_pengambilan('findAll', $rows);

            $total = 0;
            if (count($pesanan) > 0) {
                foreach ($pesanan as $p) {
                    $total = $total + $p['qty'] * $p['harga'];
                }
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pesanan[0]['kode_transaksi'];
            $row[] = date('d F Y H:i', strtotime($pesanan[0]['tgl_dikonfirmasi']));
            $row[] = $get_akun['nama_lengkap'];
            $row[] = '<a class="btn btn-primary btn-sm" onclick="lihat_pesanan(' . $get_akun['id'] . ')">Lihat Pesanan</a>';
            $row[] = '<a class="btn btn-success btn-sm" onclick="ambil_pesanan(' . $get_akun['id'] . ')"><i class="mdi mdi-hand" style="font-size: 20px;"></i>Ambil Pesanan</a>';

            $data[] = $row;
        }

        $output = array(
            "data" => $data,
            // "pesanan" => $pesanan,
        );
        echo json_encode($output);
    }

    // siap diambil
    public function siap_diambil($id_akun)
    {
        $pesanan = $this->transaksiModel->where(['id_akun' => $id_akun, 'status_transaksi' => 'dikemas'])->findAll();

        foreach ($pesanan as $p) {
            $data = [
                'id'                => $p['id'],
                'status_transaksi'  => 'siap_diambil',
                'tgl_siap_diambil'  => date('Y-m-d H:i:s'),
                'u_id'              => session()->get('id'),
            ];
            $this->transaksiModel->save($data);
        }
        echo json_encode('success');
    }

    public function ambil_pesanan($id_akun)
    {
        $pesanan = $this->transaksiModel->where(['id_akun' => $id_akun, 'status_transaksi' => 'siap_diambil'])->findAll();

        foreach ($pesanan as $p) {
            $data = [
                'id'                => $p['id'],
                'status_transaksi'  => 'selesai',
                'tgl_selesai'       => date('Y-m-d H:i:s'),
                'u_id'              => session()->get('id'),
            ];
            $this->transaksiModel->save($data);
        }
        echo json_encode('success');
    }
}
