<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\Admin\Barang_model;
use App\Models\Admin\Jenis_barang_model;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;

class Home extends BaseController
{
    public function __construct()
    {
        $this->akunModel          = new Akun_model();
        $this->akunDetailModel    = new Akun_detail_model();
        $this->barangModel        = new Barang_model();
        $this->jenisBarangModel   = new Jenis_barang_model();

        // email
        $this->email              = \Config\Services::email();
    }

    public function index()
    {
        helper(['form', 'url']);

        $data = [
            'menu'          => 'home',
            'content'       => 'user/home/home',
            'content_foot'  => [
                'user/home/content_foot/cf_home',
                'universal_foot/cf_toastr',
            ],
            'jenis_barang'  => $this->jenisBarangModel->findAll(),
        ];
        return view('user/layouts/wrapper', $data);
    }

    // ajax
    public function load_barang()
    {
        $jenis  = $this->request->getVar('jenis');
        $search = $this->request->getVar('search');
        $urutan = $this->request->getVar('urutan');

        $barang = $this->barangModel->load_barang($urutan, $jenis, $search, 'user');
        $harga = [];

        if (count($barang) > 0) {
            foreach ($barang as $b) {
                $harga[$b['id']] = "Rp " . number_format($b['harga'], 0, ',', '.');
            }
        }

        $data = [
            'hitung'    => count($barang),
            'barang'    => $barang,
            'harga'     => $harga,
        ];
        echo json_encode($data);
    }

    public function cek_total_harga()
    {
        $harga  = $this->request->getVar('harga');
        $qty    = $this->request->getVar('qty');

        if ($qty > 0) {
            $total = $harga * $qty;
        } else {
            $total = $harga;
        }

        $total_harga = "Rp " . number_format($total, 0, ',', '.');
        echo json_encode($total_harga);
    }
}
