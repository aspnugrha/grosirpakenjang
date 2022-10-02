<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Barang_model;
use App\Models\Admin\Jenis_barang_model;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;

class Data_master_barang extends BaseController
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
        $data = [
            'menu'          => 'data_master',
            'submenu'       => 'barang',
            'title'         => 'Data Master (Barang)',
            'content'       => 'admin/data_master/barang/dm_barang',
            'content_foot'  => [
                'admin/data_master/barang/content_foot/cf_dm_barang',
                'universal_foot/cf_toastr',
                'universal_foot/cf_validasi_file',
            ],
        ];
        return view('admin/layouts/wrapper', $data);
    }

    // ajax
    public function load_barang()
    {
        $urutan     = $this->request->getVar('urutan');
        $jenis      = $this->request->getVar('jenis');
        $search     = $this->request->getVar('search');

        $list       = $this->barangModel->load_barang($urutan, $jenis, $search);

        $data = array();
        $no = 0;
        foreach ($list as $rows) {
            $no++;
            $row = array();
            $row[] = $no;

            $foto_barang = '<i class="mdi mdi-image h2"></i>';
            if ($rows['foto_barang'] != null) {
                $foto_barang = '<img src="/assets/upload/admin/foto_barang/' . $rows['foto_barang'] . '" style="width: 80px;" />';
            }

            $row[] = $foto_barang;
            $row[] = $rows['nama_barang'];
            $row[] = $rows['jenis'];
            $row[] = $rows['stok'];
            $row[] = "Rp " . number_format($rows['harga'], 0, ',', '.');

            $aksi = '<a class="btn btn-primary btn-sm" onclick="edit(' . $rows['id'] . ')"><i class="mdi mdi-square-edit-outline"></i></a><a class="btn btn-danger btn-sm" onclick="hapus(' . $rows['id'] . ')"><i class="mdi mdi-delete"></i></a>';

            $row[] = $aksi;
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    function simpan_barang()
    {
        $id     = $this->request->getVar('id');
        $nama   = $this->request->getVar('nama');
        $jenis  = $this->request->getVar('jenis');
        $stok   = $this->request->getVar('stok');
        $harga  = $this->request->getVar('harga');
        $foto   = $this->request->getFile('foto');

        $data = [
            'nama_barang'       => $nama,
            'id_jenis_barang'   => $jenis,
            'stok'              => $stok,
            'harga'             => $harga,
        ];

        $cek = $this->barangModel->where('nama_barang', $nama)->first();

        if ($cek != null) {
            if (!empty($id)) {
                if ($cek['id'] == $id) {
                    $res = 'success';
                } else {
                    $res = 'barang_ada';
                }
            } else {
                $res = 'barang_ada';
            }
        } else {
            $res = 'success';
        }

        if ($res == 'success') {

            if ($foto->getError() != 4) {
                $nama_foto = $foto->getRandomName();
                $proses = \Config\Services::image()
                    ->withFile($foto)
                    ->resize(500, 400, true, 'height')
                    ->save(FCPATH . '/assets/upload/admin/foto_barang/' . $nama_foto);

                if (!empty($id)) {
                    $get = $this->barangModel->where('id', $id)->first();

                    if ($get['foto_barang'] != null) {
                        if ($get['foto_barang'] != null) {
                            if (file_exists('assets/upload/admin/foto_barang/' . $get['foto_barang']) == true) {

                                unlink('assets/upload/admin/foto_barang/' . $get['foto_barang']);
                            }
                        }
                    }
                }
                $data['foto_barang'] = $nama_foto;
            }

            if (!empty($id)) {
                $data['id']     = $id;
                $data['u_id']   = session()->get('id');
                $res            = 'success';
            } else {
                $data['c_id']   = session()->get('id');
            }

            $this->barangModel->save($data);
        }

        echo json_encode($res);
    }

    public function edit_barang($id)
    {
        $get    = $this->barangModel->where('id', $id)->first();
        $jenis  = $this->jenisBarangModel->where('id', $get['id_jenis_barang'])->first();
        $harga  = "Rp " . number_format($get['harga'], 0, ',', '.');
        $data = [
            'barang'    => $get,
            'jenis'     => $jenis,
            'harga'     => $harga,
        ];
        echo json_encode($data);
    }

    public function hapus_barang($id)
    {
        $get = $this->barangModel->where('id', $id)->first();

        if ($get['foto_barang'] != null) {
            if ($get['foto_barang'] != null) {
                if (file_exists('assets/upload/admin/foto_barang/' . $get['foto_barang']) == true) {

                    unlink('assets/upload/admin/foto_barang/' . $get['foto_barang']);
                }
            }
        }

        $this->barangModel->delete($id);
        echo json_encode('success');
    }
}
