<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Akun_detail_model;
use App\Models\Akun_model;

class Data_master_user extends BaseController
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
            'menu'          => 'data_master',
            'submenu'       => 'user',
            'title'         => 'Data Master (User)',
            'content'       => 'admin/data_master/user/dm_user',
            'content_foot'  => [
                'admin/data_master/user/content_foot/cf_dm_user',
                'universal_foot/cf_toastr',
            ],
        ];
        return view('admin/layouts/wrapper', $data);
    }

    // ajax
    public function load_user()
    {
        $role   = $this->request->getVar('role');
        $search = $this->request->getVar('search');

        $list   = $this->akunModel->load_user($role, $search);

        $data = array();
        $no = 0;
        foreach ($list as $rows) {
            $no++;
            $row = array();
            $row[] = $no;

            $profile = '<i class="mdi mdi-account-circle-outline h2"></i>';
            if ($rows['profile'] != null) {
                $profile = '<img src="/assets/upload/' . $rows['role'] . '/profile/' . $rows['profile'] . '" class="user-image rounded-circle" />';
            }

            $row[] = $profile;
            $row[] = $rows['nama_lengkap'];
            $row[] = $rows['email'];

            $role = ['superadmin', 'admin', 'user'];
            // $option_role = '<option>Select Role</option>';
            $option_role = '';
            foreach ($role as $r) {
                if ($rows['role'] == $r) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $option_role .= '<option value ="' . $r . '" ' . $selected . '>' . ucfirst($r) . '</option>';
            }

            $select_role = '<select name="role_' . $no . '" id="role_' . $no . '" class="form-control" onchange="ubah_role(' . $rows['id'] . ', ' . $no . ')">
            ' . $option_role . '                
            </select>';

            $row[] = $select_role;

            if ($rows['aktif'] == 'y') {
                $val = 'on';
                $checked = 'checked';
            } else {
                $val = 'off';
                $checked = '';
            }
            $switch_aktif = '<label class="switch switch-icon switch-outline-alt-success switch-pill form-control-label">
                                <input type="checkbox" class="switch-input form-check-input" value="' . $val . '" ' . $checked . ' onclick="ubah_aktif(' . $rows['id'] . ', `' . $val . '`)">
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>';

            $row[] = $switch_aktif;
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
        );
        echo json_encode($output);
    }

    function ubah_role()
    {
        $id     = $this->request->getVar('id');
        $role   = $this->request->getVar('role');

        $data = [
            'id'    => $id,
            'role'  => $role,
        ];

        $this->akunModel->save($data);
        echo json_encode('success');
    }

    public function ubah_aktif($id)
    {
        $get = $this->akunModel->where('id', $id)->first();

        $data = [
            'id'    => $id,
        ];
        if ($get['aktif'] == 'y') {
            $data['aktif'] = 't';
        } else {
            $data['aktif'] = 'y';
        }

        $this->akunModel->save($data);
        echo json_encode('success');
    }
}
