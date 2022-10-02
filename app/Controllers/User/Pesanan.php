<?php

namespace App\Controllers\user;

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
        helper(['form', 'url']);
    }

    public function index()
    {
        if ($this->akunModel->cek_login('user')) {
            $data = [
                'menu'          => 'pesanan',
                'content'       => 'user/pesanan/pesanan',
                'content_foot'  => [
                    'user/pesanan/content_foot/cf_pesanan',
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

    public function load_pesanan()
    {
        $list = $this->transaksiModel
            ->select('transaksi.*, barang.nama_barang, barang.id_jenis_barang, barang.foto_barang, barang.stok, barang.harga, jenis_barang.jenis, akun.email, akun_detail.nama_lengkap')
            ->join('barang', 'barang.id = transaksi.id_barang')
            ->join('jenis_barang', 'jenis_barang.id = barang.id_jenis_barang')
            ->join('akun', 'akun.id = transaksi.id_akun')
            ->join('akun_detail', 'akun_detail.id_akun = akun.id')
            ->where('transaksi.id_akun', session()->get('id'))
            ->like('transaksi.status_transaksi', 'dipesan')
            // ->orLike('transaksi.status_transaksi', 'dibatalkan')
            ->orLike('transaksi.status_transaksi', 'dikonfirmasi')
            ->orLike('transaksi.status_transaksi', 'dikemas')
            ->orLike('transaksi.status_transaksi', 'siap_diambil')->findAll();

        $data = array();
        $no = 0;
        $total_harga = 0;

        foreach ($list as $rows) {
            $no++;
            $row = array();
            $row[] = $no;

            if ($rows['foto_barang'] != null) {
                $foto_barang = '<img class="px-2" src="/assets/upload/admin/foto_barang/' . $rows['foto_barang'] . '" style="width: 80px;" />';
            } else {
                $foto_barang = '<img class="card-img-top img-fluid w-100 px-2" src="/assets/img/kosong/img-kosong.jpg" >';
            }

            $row[] = $foto_barang;
            $row[] = $rows['nama_barang'];
            $row[] = $rows['jenis'];
            $row[] = '<center>' . $rows['qty'] . '</center>';
            $row[] = "<center>Rp " . number_format($rows['qty'] * $rows['harga'], 0, ',', '.') . '</center>';

            $data[] = $row;

            $total_harga = $total_harga + $rows['qty'] * $rows['harga'];
        }

        $output = array(
            "data" => $data,
            "total_harga" => "Rp " . number_format($total_harga, 0, ',', '.'),
        );
        echo json_encode($output);
    }

    public function tambah_keranjang()
    {
        $id  = $this->request->getVar('id');
        $qty = $this->request->getVar('qty');


        $cek = $this->transaksiModel->where(['status_transaksi' => 'keranjang', 'id_barang' => $id, 'id_akun' => session()->get('id')])->first();

        if ($cek != null) {
            $data = [
                'id'    => $cek['id'],
                'qty'   => $cek['qty'] + $qty,
                'u_id'  => session()->get('id'),
            ];
        } else {
            $kode_transaksi = $this->transaksiModel->makeKodeTransaksi();
            $data = [
                'kode_transaksi'    => $kode_transaksi,
                'id_akun'           => session()->get('id'),
                'id_barang'         => $id,
                'tgl_transaksi'     => date('Y-m-d H:i:s'),
                'qty'               => $qty,
                'status_transaksi'  => 'keranjang',
                'c_id'              => session()->get('id'),
            ];
        }

        $this->transaksiModel->save($data);
        echo json_encode('success');
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

    public function ubah_qty()
    {
        $id  = $this->request->getVar('id');
        $qty = $this->request->getVar('qty');

        $data = [
            'id'    => $id,
            'qty'   => $qty,
            'u_id'  => session()->get('id'),
        ];
        $this->transaksiModel->save($data);
        echo json_encode('success');
    }

    public function hapus_keranjang($id)
    {
        $this->transaksiModel->delete($id);
        echo json_encode('success');
    }

    public function pesan()
    {
        $keranjang      = $this->transaksiModel->where(['id_akun' => session()->get('id'), 'status_transaksi' => 'keranjang'])->findAll();
        $cek_pesanan    = $this->transaksiModel->where(['id_akun' => session()->get('id'), 'status_transaksi' => 'dipesan'])->findAll();

        if (count($cek_pesanan) > 0) {
            $res = 'pesanan_ada';
        } else {
            if (count($keranjang) > 0) {
                foreach ($keranjang as $k) {
                    $data = [
                        'id'                => $k['id'],
                        'status_transaksi'  => 'dipesan',
                        'tgl_dipesan'       => date('Y-m-d H:i:s'),
                    ];
                    $this->transaksiModel->save($data);
                }
                $res = 'success';
            } else {
                $res = 'keranjang_kosong';
            }
        }
        echo json_encode($res);
    }

    public function cek_progres_pesanan()
    {
        $cek_pesanan    = $this->transaksiModel
            ->where('id_akun', session()->get('id'))
            ->like('status_transaksi', 'dipesan')
            // ->orLike('status_transaksi', 'dibatalkan')
            ->orLike('status_transaksi', 'dikonfirmasi')
            ->orLike('status_transaksi', 'dikemas')
            ->orLike('status_transaksi', 'siap_diambil')->findAll();

        if (count($cek_pesanan) > 0) {

            $res = [
                'status'            => 'success',
                'kode_transaksi'    => $cek_pesanan[0]['kode_transaksi'],
                'progres'           => $cek_pesanan[0]['status_transaksi'],
                'tgl_dipesan'       => date('d F Y H:i', strtotime($cek_pesanan[0]['tgl_dipesan'])),
                'tgl_dibatalkan'    => date('d F Y H:i', strtotime($cek_pesanan[0]['tgl_dibatalkan'])),
                'tgl_dikonfirmasi'  => date('d F Y H:i', strtotime($cek_pesanan[0]['tgl_dikonfirmasi'])),
                'tgl_dikemas'       => date('d F Y H:i', strtotime($cek_pesanan[0]['tgl_dikemas'])),
                'tgl_siap_diambil'  => date('d F Y H:i', strtotime($cek_pesanan[0]['tgl_siap_diambil'])),
            ];
        } else {
            $res = [
                'status'    => 'gagal'
            ];
        }
        echo json_encode($res);
    }

    public function batalkan_pesanan()
    {
        $cek_pesanan    = $this->transaksiModel->where(['id_akun' => session()->get('id'), 'status_transaksi' => 'dipesan'])->findAll();

        foreach ($cek_pesanan as $cp) {
            $data = [
                'id'                => $cp['id'],
                'status_transaksi'  => 'dibatalkan',
                'u_id'              => session()->get('id'),
                'tgl_dibatalkan'    => date('Y-m-d H:i:s'),
            ];

            $this->transaksiModel->save($data);
        }
        echo json_encode('sucess');
    }
}
