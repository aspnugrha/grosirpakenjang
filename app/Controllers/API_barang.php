<?php

namespace App\Controllers;

use App\Models\Admin\Barang_model;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class API_barang extends ResourceController
{
    use ResponseTrait;
    // all users
    public function index()
    {
        $model = new Barang_model();
        $data['produk'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }
    // create
    public function create()
    {
        $model = new Barang_model();
        $data = [
            'id_jenis_barang' => $this->request->getVar('id_jenis_barang'),
            'nama_barang' => $this->request->getVar('nama_barang'),
            'stok'  => $this->request->getVar('stok'),
            'harga'  => $this->request->getVar('harga'),
        ];
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data produk berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
    }
    // single user
    public function show($id = null)
    {
        $model = new Barang_model();
        $data = $model->where('id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
    // update
    public function update($id = null)
    {
        $model = new Barang_model();
        $data = [
            'nama_barang' => $this->request->getVar('nama_barang'),
            'stok'  => $this->request->getVar('stok'),
            'harga'  => $this->request->getVar('harga'),
        ];
        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data produk berhasil diubah.'
            ]
        ];
        return $this->respond($response);
    }
    // delete
    public function delete($id = null)
    {
        $model = new Barang_model();
        $cek = $model->where('id', $id)->first();
        if ($cek != null) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data produk berhasil dihapus.'
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data barang tidak ditemukan.');
        }
    }
}
