<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\Admin\Barang_model;
use App\Models\Admin\Jenis_barang_model;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;
use App\Models\Transaksi_model;

class Bandingkan extends BaseController
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
            'menu'          => 'bandingkan',
            'submenu'       => '',
            'title'         => 'Pembandingan',
            'content'       => 'user/bandingkan/bandingkan',
            'content_foot'  => [
                'user/bandingkan/content_foot/cf_bandingkan',
                'universal_foot/cf_toastr',
            ],
            'jenis_barang' => $this->jenisBarangModel->findAll(),
        ];
        return view('user/layouts/wrapper', $data);
    }

    // ajax
    // bandingkan
    public function bandingkan()
    {
        $filter_tgl = $this->request->getVar('filter_tgl');
        $jb1 = $this->request->getVar('jb1');
        $jb2 = $this->request->getVar('jb2');

        // jenis barang1
        $barang = $this->barangModel->where('id_jenis_barang', $jb1)->findAll();

        $data_barang1 = [];
        $total_terjual_jb1 = 0;
        $total_nominal_jb1 = 0;
        $total_terjual_jb2 = 0;
        $total_nominal_jb2 = 0;

        if (count($barang) > 0) {
            foreach ($barang as $b) {
                $jb1 = [];
                $jb1['barang'] = $b;

                $all_transaksi = $this->transaksiModel->bandingkan($b['id'], $filter_tgl);

                $total_terjual = 0;
                $total_nominal_terjual = 0;
                if (count($all_transaksi) > 0) {
                    foreach ($all_transaksi as $at) {
                        $total_terjual += $at['qty'];
                        $total_nominal_terjual += $at['qty'] * $b['harga'];
                    }
                }
                $jb1['terjual'] = $total_terjual;
                $jb1['nominal_terjual'] = $total_nominal_terjual;

                $data_barang1[] = $jb1;

                $total_terjual_jb1 += $total_terjual;
                $total_nominal_jb1 += $total_nominal_terjual;
            }
        }


        // jenis barang2
        $barang2 = $this->barangModel->where('id_jenis_barang', $jb2)->findAll();

        $data_barang2 = [];
        if (count($barang2) > 0) {
            foreach ($barang2 as $b) {
                $jb2 = [];
                $jb2['barang'] = $b;

                $all_transaksi2 = $this->transaksiModel->bandingkan($b['id'], $filter_tgl);

                $total_terjual = 0;
                $total_nominal_terjual = 0;
                if (count($all_transaksi2) > 0) {
                    foreach ($all_transaksi2 as $at) {
                        $total_terjual += $at['qty'];
                        $total_nominal_terjual += $at['qty'] * $b['harga'];
                    }
                }
                $jb2['terjual'] = $total_terjual;
                $jb2['nominal_terjual'] = $total_nominal_terjual;

                $data_barang2[] = $jb2;

                $total_terjual_jb2 += $total_terjual;
                $total_nominal_jb2 += $total_nominal_terjual;
            }
        }

        $data = [
            'hitung_jb1'    => count($data_barang1),
            'hitung_jb2'    => count($data_barang2),
            'jb1'           => $data_barang1,
            'jb2'           => $data_barang2,
            'total_terjual_jb1' => $total_terjual_jb1,
            'total_terjual_jb2' => $total_terjual_jb2,
            'total_nominal_jb1' => "Rp " . number_format($total_nominal_jb1, 0, ',', '.'),
            'total_nominal_jb2' => "Rp " . number_format($total_nominal_jb2, 0, ',', '.'),
        ];

        echo json_encode($data);
    }
}
