<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Barang_model;
use App\Models\Admin\Jenis_barang_model;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;
use App\Models\Transaksi_model;

class Pesanan extends BaseController
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

    public function cek_pesanan()
    {
        $data = [
            'menu'          => 'penjualan',
            'submenu'       => 'cek_pesanan',
            'title'         => 'Data Master (Jenis Barang)',
            'content'       => 'admin/penjualan/cek_pesanan/cek_pesanan',
            'content_foot'  => [
                'admin/penjualan/cek_pesanan/content_foot/cf_cek_pesanan',
                'universal_foot/cf_toastr',
            ],
        ];
        return view('admin/layouts/wrapper', $data);
    }

    public function pesanan()
    {
        $data = [
            'menu'          => 'penjualan',
            'submenu'       => 'pesanan',
            'title'         => 'Data Master (Jenis Barang)',
            'content'       => 'admin/penjualan/pesanan/pesanan',
            'content_foot'  => [
                'admin/penjualan/pesanan/content_foot/cf_pesanan',
                'universal_foot/cf_toastr',
            ],
        ];
        return view('admin/layouts/wrapper', $data);
    }

    // ajax
    // CEK PESANAN
    public function load_pesanan()
    {
        $tgl = $this->request->getVar('tgl');
        $urutan = $this->request->getVar('urutan');

        $list   = $this->transaksiModel->load_all_pesanan($tgl, $urutan);

        $akun = [];
        if (count($list) > 0) {
            $akun = array_unique(array_column($list, 'id_akun'));
        }

        $data = array();
        $no = 0;
        foreach ($akun as $rows) {
            $get_akun = $this->akunModel->get_join('first', $rows);
            $pesanan = $this->transaksiModel->get_join('findAll', $rows);

            $total = 0;
            if (count($pesanan) > 0) {
                foreach ($pesanan as $p) {
                    $total = $total + $p['qty'] * $p['harga'];
                }
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date('d F Y H:i', strtotime($pesanan[0]['updated_at']));
            $row[] = $get_akun['nama_lengkap'];
            $row[] = "Rp " . number_format($total, 0, ',', '.');
            $row[] = '<a class="btn btn-primary btn-sm" onclick="lihat_pesanan(' . $get_akun['id'] . ')">Lihat Pesanan</a>';

            // $aksi = '<a class="btn btn-success btn-sm" onclick="konfirmasi(' . $rows . ')"><i class="mdi mdi-square-edit-outline"></i> Konfirmasi Pesanan</a>';

            // $row[] = $aksi;
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
            // "pesanan" => $pesanan,
        );
        echo json_encode($output);
    }

    public function load_list_pesanan()
    {
        $id_akun = $this->request->getVar('id_akun');
        $list   = $this->transaksiModel->get_join('findAll', $id_akun);

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

    public function load_list_pesanan2()
    {
        $id_akun = $this->request->getVar('id_akun');
        $list   = $this->transaksiModel->get_join2('findAll', $id_akun);

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

    public function load_list_pesanan_selesai()
    {
        $id_pesanan = $this->request->getVar('id_pesanan');
        $pesanan = $this->transaksiModel->where('id', $id_pesanan)->first();

        $list   = $this->transaksiModel->get_join_selesai('findAll', $pesanan['kode_transaksi']);

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

    public function cek_total_harga($id_akun)
    {
        $list = $this->transaksiModel->get_join('findAll', $id_akun);

        $total_harga = 0;
        if (count($list) > 0) {
            foreach ($list as $l) {
                $total = $l['qty'] * $l['harga'];
                $total_harga = $total_harga + $total;
            }
        }

        echo json_encode("Rp " . number_format($total_harga, 0, ',', '.'));
    }
    public function cek_total_harga2($id_akun)
    {
        $list = $this->transaksiModel->get_join2('findAll', $id_akun);

        $total_harga = 0;
        if (count($list) > 0) {
            foreach ($list as $l) {
                $total = $l['qty'] * $l['harga'];
                $total_harga = $total_harga + $total;
            }
        }

        echo json_encode("Rp " . number_format($total_harga, 0, ',', '.'));
    }
    public function cek_total_harga_selesai($id_pesanan)
    {
        $pesanan = $this->transaksiModel->where('id', $id_pesanan)->first();
        $list = $this->transaksiModel->get_join_selesai('findAll', $pesanan['kode_transaksi']);

        $total_harga = 0;
        if (count($list) > 0) {
            foreach ($list as $l) {
                $total = $l['qty'] * $l['harga'];
                $total_harga = $total_harga + $total;
            }
        }

        echo json_encode("Rp " . number_format($total_harga, 0, ',', '.'));
    }

    public function konfirmasi_pesanan($id_akun)
    {
        $pesanan = $this->transaksiModel->where(['status_transaksi' => 'dipesan', 'id_akun' => $id_akun])->findAll();

        foreach ($pesanan as $p) {
            $barang = $this->barangModel->where('id', $p['id_barang'])->first();

            $sisa_stok = $barang['stok'] - $p['qty'];

            $data_stok = [
                'id'    => $p['id_barang'],
                'stok'  => $sisa_stok,
            ];

            $this->barangModel->save($data_stok);

            $data = [
                'id'                => $p['id'],
                'status_transaksi'  => 'dikonfirmasi',
                'u_id'              => session()->get('id'),
                'tgl_dikonfirmasi'  => date('Y-m-d H:i:s'),
            ];
            $this->transaksiModel->save($data);
        }
        echo json_encode('success');
    }


    // PESANAN
    public function load_all_pesanan()
    {
        $tgl = $this->request->getVar('tgl');
        $urutan = $this->request->getVar('urutan');

        $list   = $this->transaksiModel->load_pesanan2($tgl, $urutan);

        $akun = [];
        if (count($list) > 0) {
            $akun = array_unique(array_column($list, 'id_akun'));
        }

        $data = array();
        $no = 0;
        foreach ($akun as $rows) {
            $get_akun = $this->akunModel->get_join('first', $rows);
            $pesanan = $this->transaksiModel->get_join2('findAll', $rows);

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $pesanan[0]['kode_transaksi'];
            $row[] = date('d F Y H:i', strtotime($pesanan[0]['tgl_dikonfirmasi']));
            $row[] = $get_akun['nama_lengkap'];
            $row[] = '<a class="btn btn-primary btn-sm" onclick="lihat_pesanan(' . $get_akun['id'] . ')">Lihat Pesanan</a>';

            if ($pesanan[0]['status_transaksi'] == 'dikonfirmasi') {
                $progres = '<a class="btn btn-success btn-sm" onclick="kemas_pesanan(' . $rows . ')"><i class="mdi mdi-package-variant-closed" style="font-size: 20px;"></i> Kemas Pesanan</a>';
            } else if ($pesanan[0]['status_transaksi'] == 'dikemas') {
                $progres = '<a class="btn btn-secondary btn-sm" onclick="siap_diambil(' . $rows . ')"><i class="mdi mdi-check-decagram" style="font-size: 20px;"></i> Konfirmasi Siap Diambil</a>';
            } else if ($pesanan[0]['status_transaksi'] == 'siap_diambil') {
                $progres = 'Pesanan Siap Diambil';
            }

            $row[] = $progres;
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
            // "pesanan" => $pesanan,
        );
        echo json_encode($output);
    }

    // kemas
    public function kemas_pesanan($id_akun)
    {
        $pesanan = $this->transaksiModel->where(['id_akun' => $id_akun, 'status_transaksi' => 'dikonfirmasi'])->findAll();

        foreach ($pesanan as $p) {
            $data = [
                'id'                => $p['id'],
                'status_transaksi'  => 'dikemas',
                'tgl_dikemas'       => date('Y-m-d H:i:s'),
                'u_id'              => session()->get('id'),
            ];
            $this->transaksiModel->save($data);
        }
        echo json_encode('success');
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
}
