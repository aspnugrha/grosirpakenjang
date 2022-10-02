<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;

class Dashboard extends BaseController
{
    public function __construct()
    {
        $this->akunModel          = new Akun_model();
        $this->akunDetailModel    = new Akun_detail_model();

        // email
        $this->email              = \Config\Services::email();
    }

    public function index()
    {
        $data = [
            'menu'          => 'dashboard',
            'submenu'       => '',
            'title'         => 'Dashboard',
            'content'       => 'admin/dashboard/dashboard',
            'content_foot'  => [],
        ];
        return view('admin/layouts/wrapper', $data);
    }
}
