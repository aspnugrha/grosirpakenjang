<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Barang_model;
use App\Models\Admin\Jenis_barang_model;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;

class Data_master_jenis_barang extends BaseController
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
            'submenu'       => 'jenis_barang',
            'title'         => 'Data Master (Jenis Barang)',
            'content'       => 'admin/data_master/jenis_barang/dm_jenis_barang',
            'content_foot'  => [
                'admin/data_master/jenis_barang/content_foot/cf_dm_jenis_barang',
                'universal_foot/cf_toastr',
            ],
        ];
        return view('admin/layouts/wrapper', $data);
    }

    // ajax
    public function get_all()
    {
        echo json_encode($this->jenisBarangModel->findAll());
    }

    public function load_jenis_barang()
    {
        $list   = $this->jenisBarangModel->findAll();

        $data = array();
        $no = 0;
        foreach ($list as $rows) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rows['jenis'];

            $aksi = '<a class="btn btn-primary btn-sm" onclick="edit(' . $rows['id'] . ')"><i class="mdi mdi-square-edit-outline"></i></a><a class="btn btn-danger btn-sm" onclick="hapus(' . $rows['id'] . ')"><i class="mdi mdi-delete"></i></a>';

            $row[] = $aksi;
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    function simpan_jenis_barang()
    {
        $id     = $this->request->getVar('id');
        $jenis  = $this->request->getVar('jenis');

        $data = [
            'jenis' => $jenis,
        ];

        $cek = $this->jenisBarangModel->where('jenis', $jenis)->first();

        if ($cek != null) {
            if (!empty($id)) {
                if ($cek['id'] == $id) {
                    $res = 'success';
                } else {
                    $res = 'jenis_ada';
                }
            } else {
                $res = 'jenis_ada';
            }
        } else {
            $res = 'success';
        }

        if ($res == 'success') {
            if (!empty($id)) {
                $data['id']     = $id;
                $data['u_id']   = session()->get('id');
                $res            = 'success';
            } else {
                $data['c_id']   = session()->get('id');
            }

            $this->jenisBarangModel->save($data);
        }
        echo json_encode($res);
    }

    public function edit_jenis_barang($id)
    {
        $get = $this->jenisBarangModel->where('id', $id)->first();
        echo json_encode($get);
    }

    public function hapus_jenis_barang($id)
    {
        $this->jenisBarangModel->delete($id);
        echo json_encode('success');
    }

    public function load_select2()
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();

        if (!isset($postData['searchTerm'])) {
            // Fetch record
            $list = $this->jenisBarangModel
                ->orderBy('jenis', 'ASC')
                ->findAll();
        } else {
            $searchTerm = $postData['searchTerm'];

            // Fetch record
            $list = $this->jenisBarangModel
                ->like('jenis', $searchTerm)
                ->orderBy('jenis', 'ASC')
                ->findAll();
        }

        $data = array();
        foreach ($list as $l) {
            $data[] = array(
                "id" => $l['id'],
                "text" => $l['jenis'],
            );
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }

    public function load_select22($id_jenis_barang)
    {
        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();

        if (!isset($postData['searchTerm'])) {
            // Fetch record
            $list = $this->jenisBarangModel
                ->orderBy('jenis', 'ASC')
                ->findAll();
        } else {
            $searchTerm = $postData['searchTerm'];

            // Fetch record
            $list = $this->jenisBarangModel
                ->like('jenis', $searchTerm)
                ->orderBy('jenis', 'ASC')
                ->findAll();
        }

        $data = array();
        foreach ($list as $l) {
            if ($l['id'] != $id_jenis_barang) {
                $data[] = array(
                    "id" => $l['id'],
                    "text" => $l['jenis'],
                );
            }
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);
    }
}
