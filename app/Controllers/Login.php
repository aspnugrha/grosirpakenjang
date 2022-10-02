<?php

namespace App\Controllers;

use App\Models\Akun_detail_model;
use App\Models\Akun_model;

class Login extends BaseController
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
        return view('login/login');
    }

    // login
    public function login()
    {
        $email       = $this->request->getVar('email');
        $password    = $this->request->getVar('password');

        $cek = $this->akunModel->where('email', $email)->first();

        if ($cek != null) {
            if (password_verify($password, $cek['password'])) {
                if ($cek['aktif'] == 'y') {

                    $data = [
                        'id'        => $cek['id'],
                        'email'     => $cek['email'],
                        'role'      => $cek['role'],
                        'profile'   => $cek['profile'],
                    ];
                    session()->set($data);

                    $response = [
                        'status'    => 'success',
                        'role'      => $cek['role']
                    ];
                } else {
                    $response = [
                        'status'    => 'belum_aktivasi',
                    ];
                }
            } else {
                $response = [
                    'status'    => 'gagal',
                ];
            }
        } else {
            $response = [
                'status'    => 'email_belum_terdaftar',
            ];
        }
        echo json_encode($response);
    }

    // register
    public function register()
    {
        $nama       = $this->request->getVar('reg_nama');
        $email      = $this->request->getVar('reg_email');
        $password   = $this->request->getVar('reg_password');

        $cek_email = $this->akunModel->where('email', $email)->first();

        if ($cek_email != null) {
            $response = 'email_terpakai';
        } else {
            $this->email->setFrom('grosirpakenjang@gmail.com', 'Grosir Pak Enjang | Aktivasi');
            $this->email->setTo($email);

            // $this->email->attach($attachment);

            $this->email->setSubject('Kode Aktivasi | Grosir Pak Enjang');

            $kode_aktivasi = rand(100000, 999999);

            $message = '<h4>Kode Aktivasi Akun Anda</h4><br>
                                <p><b>Selamat!</b> Akun anda berhasil dibuat. Kode aktivasi akun anda adalah = <b>' . $kode_aktivasi . '</b> . Langsung lakukan aktivasi dan jangan sebarkan kode tersebut.</p>';

            $this->email->setMessage($message);
            $this->email->send();


            $akun = [
                'email'         => $email,
                'password'      => password_hash($password, PASSWORD_DEFAULT),
                'role'          => 'user',
                'aktif'         => 't',
                'kode_aktivasi' => $kode_aktivasi,
            ];
            $this->akunModel->save($akun);
            $get = $this->akunModel->where('email', $email)->first();

            $akun_detail = [
                'id_akun'       => $get['id'],
                'nama_lengkap'  => $nama,
            ];

            $this->akunDetailModel->save($akun_detail);

            $response = 'success';
        }
        echo json_encode($response);
    }

    // aktivasi
    public function aktivasi_kirim_kode()
    {
        $email = $this->request->getVar('email');

        $get = $this->akunModel->where('email', $email)->first();

        if ($get != null) {
            $this->email->setFrom('grosirpakenjang@gmail.com', 'Grosir Pak Enjang | Aktivasi');
            $this->email->setTo($email);

            // $this->email->attach($attachment);

            $this->email->setSubject('Kode Aktivasi | Grosir Pak Enjang');

            $kode_aktivasi = rand(100000, 999999);

            $data = [
                'id'            => $get['id'],
                'aktif'         => 't',
                'kode_aktivasi' => $kode_aktivasi
            ];

            $this->akunModel->save($data);

            $message = '<h4>Kode Aktivasi Akun Anda</h4><br>
                                <p><b>Selamat!</b> Akun anda berhasil dibuat. Kode aktivasi akun anda adalah = <b>' . $kode_aktivasi . '</b> . Langsung lakukan aktivasi dan jangan sebarkan kode tersebut.</p>';

            $this->email->setMessage($message);
            $kirim = $this->email->send();

            if ($kirim) {
                $res = 'success';
            } else {
                $res = 'gagal';
            }
        } else {
            $res = 'email_tidak_ditemukan';
        }
        echo json_encode($res);
    }

    public function aktivasi()
    {
        $email  = $this->request->getVar('email');
        $kode   = $this->request->getVar('kode');

        $get    = $this->akunModel->where('email', $email)->first();

        if ($kode == $get['kode_aktivasi']) {
            $data = [
                'id'            => $get['id'],
                'aktif'         => 'y',
                'kode_aktivasi' => null
            ];

            $this->akunModel->save($data);

            $res = 'success';
        } else {
            $res = 'gagal';
        }
        echo json_encode($res);
    }

    // lupa password
    public function create_new_pass()
    {
        $email = $this->request->getVar('email');
        $pass  = $this->request->getVar('pass');

        $get    = $this->akunModel->where('email', $email)->first();

        $data = [
            'id'        => $get['id'],
            'password'  => password_hash($pass, PASSWORD_DEFAULT),
        ];

        $this->akunModel->save($data);
        echo json_encode('success');
    }

    public function logout()
    {
        $session = session();
        // $id = $session->get('id');
        // // log
        // $this->logModel->log_out($id);

        $session->destroy();
        return redirect()->to('/');
    }

    public function get_user($id)
    {
        $get = $this->akunModel->get_join('first', $id);
        echo json_encode($get);
    }
}
