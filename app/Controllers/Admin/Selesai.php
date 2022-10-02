<?php

namespace App\Controllers\Admin;

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
    }

    public function index()
    {
        $data = [
            'menu'          => 'penjualan',
            'submenu'       => 'selesai',
            'title'         => 'Data Pesanan (Selesai)',
            'content'       => 'admin/penjualan/selesai/selesai',
            'content_foot'  => [
                'admin/penjualan/selesai/content_foot/cf_selesai',
                'universal_foot/cf_toastr',
            ],
        ];
        return view('admin/layouts/wrapper', $data);
    }

    // ajax
    // selesai
    public function load_selesai()
    {
        $tgl = $this->request->getVar('tgl');
        $urutan = $this->request->getVar('urutan');

        $search = $this->request->getVar('search');

        $list   = $this->transaksiModel->load_selesai($tgl, $urutan, $search);
        $kode = [];
        if (count($list) > 0) {
            $kode = array_unique(array_column($list, 'kode_transaksi'));
        }

        $data = array();
        $no = 0;
        foreach ($kode as $rows) {
            $pesanan = $this->transaksiModel->get_join_selesai('findAll', $rows);
            // dd($pesanan);
            $get_akun = $this->akunModel->get_join('first', $pesanan[0]['id_akun']);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pesanan[0]['kode_transaksi'];
            $row[] = date('d F Y H:i', strtotime($pesanan[0]['tgl_dikonfirmasi']));
            $row[] = $get_akun['nama_lengkap'];
            $row[] = '<a class="btn btn-primary btn-sm" onclick="lihat_pesanan(' . $get_akun['id'] . ', ' . $pesanan[0]['id'] . ')">Lihat Pesanan</a>';
            $row[] = $pesanan[0]['status_transaksi'];

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
