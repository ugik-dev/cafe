<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'MejaModel', 'GeneralModel', 'MenuModel'));
        // var_dump($this->session->userdata());
        // $this->SecurityModel->roleOnlyGuard('admin');
    }

    public function index()
    {
        $data = [
            'page' => 'landing_page'
        ];
        $this->load->view('template/index', $data);
    }

    public function order_meja($id)
    {
        // var_dump($this->session->userdata());
        $data = [
            'page' => '/pages/input_name',
            'dataContent' => [
                'nama_meja' => $id
            ]
        ];
        $this->load->view('template/index', $data);
    }
    public function order_process()
    {
        if (empty($this->session->userdata()['pemesanan'])) {
            echo 'ses ada';
            $post = $this->input->post();
            if (!empty($post)) {
                $this->load->library('user_agent');
                if ($this->agent->is_browser()) {
                    $agent = $this->agent->browser() . ' ' . $this->agent->version();
                } elseif ($this->agent->is_robot()) {
                    $agent = $this->agent->robot();
                } elseif ($this->agent->is_mobile()) {
                    $agent = $this->agent->mobile();
                } else {
                    $agent = 'Unidentified User Agent';
                }

                $mobile_type =  $agent . ' ' . $this->agent->platform();
                $data_pemesan = [
                    'nama_pemesan' => $post['nama_pemesan'],
                    'id_meja' => $post['id_meja'],
                    'ip_address' => $this->input->ip_address(),
                    'mobile_type' => $mobile_type
                ];
                $id_ses = $this->GeneralModel->addSessionPemesanan($data_pemesan);
                $data_pemesan['id_ses'] = $id_ses;
                // $data_session = $this->session->userdata();
                $this->session->set_userdata(['pemesanan' => $data_pemesan]);
                redirect(base_url('order'));
            } else {
                redirect(base_url());
            }
        } else {
            $data_sess = $this->session->userdata()['pemesanan'];
            $data_sess = $this->GeneralModel->getSesPemesanan(['id_ses' => $data_sess['id_ses']])[$data_sess['id_ses']];
            $data = [
                'page' => '/pages/pilih_menu',
                'dataContent' => [
                    'dataSes' => $data_sess
                ]
            ];
            $this->load->view('template/index', $data);
        }

        // var_dump()
    }

    public function order_process_two()
    {
        if (!empty($this->session->userdata()['pemesanan'])) {
            $id_ses = $this->session->userdata()['pemesanan']['id_ses'];
            $data = $this->input->post();
            $pesanan = [];
            $menu = $this->MenuModel->getAllMenu();
            foreach ($menu as $m) {
                if ($data['menu_' . $m['id_menu']] > 0) {
                    $tmp = [
                        'id_menu' => $m['id_menu'],
                        'harga_pesanan' => $m['harga'],
                        'nama_pesanan' => $m['nama_menu'],
                        'id_ses' => $id_ses,
                        'qyt' => $data['menu_' . $m['id_menu']]
                    ];
                    array_push($pesanan, $tmp);
                }
            }
            $this->GeneralModel->pushPesanan($pesanan);
            // echo json_encode($pesanan);
            echo json_encode(array('error' => false));
        }
    }

    public function cart()
    {
        if (!empty($this->session->userdata()['pemesanan'])) {
            $id_ses = $this->session->userdata()['pemesanan']['id_ses'];
            $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses]);
            if (!empty($pesanan_anda))
                $data = [
                    'page' => '/pages/list_pesanan',
                    'dataContent' => [
                        'dataSes' => $pesanan_anda[$id_ses]
                    ]
                ];
            else
                $data = [
                    'page' => '/pages/error',
                    'dataContent' => [
                        'message' => "Maaf anda belum memiliki pesanan! klik tombol dibawah untuk melakuka besanan.",
                        'button' => '<a href=' . base_url('order') . ' class="book-now text-center"><i class="icofont-double-left"></i>Buka Menu</a>'
                    ]
                ];
            $this->load->view('template/index', $data);
            // echo json_encode($pesanan_anda);
        } else {
            redirect(base_url());
        }
    }

    public function getListPesanan()
    {
        if (!empty($this->session->userdata()['pemesanan'])) {
            $id_ses = $this->session->userdata()['pemesanan']['id_ses'];
            $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses])[$id_ses];
            echo json_encode(['error' => false, 'data' => $pesanan_anda]);
        } else {
            redirect(base_url());
        }
    }

    public function order($code)
    {
        // var_dump($this->session->userdata());
        $this->load->model('MejaModel');
        $dataMeja = $this->MejaModel->getAllMeja(['code' => $code, 'limit' => 1], false);
        if (!empty($dataMeja)) {
            // var_dump($dataMeja[0]);
            $data = [
                'page' => '/pages/input_name',
                'dataContent' => [
                    'dataMeja' => $dataMeja[0]
                ]
            ];
        } else {
            $data = [
                'page' => '/pages/error',

            ];
        }
        $this->load->view('template/index', $data);
        // $data = [
        //     'page' => '/pages/input_name',
        //     'dataContent' => [
        // 'nama_meja' => $id
        //     ]
        // ];
        // $this->load->view('template/index', $data);
    }

    public function pilih_menu()
    {
        // var_dump($this->session->userdata());
        $data = [
            'page' => '/pages/pilih_menu',
            'dataContent' => [
                // 'nama_meja' => $id
            ]
        ];
        $this->load->view('template/index', $data);
    }
}
