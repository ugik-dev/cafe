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
        // HotOffer();
        // die();
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
        $post = $this->input->post();
        if (!empty($post)) {
            $dataSess = $this->GeneralModel->cekToken(['date' => date('Y-m-d'), 'token' => $post['token']]);
            if (!empty($dataSess)) {
                // die();

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
                    'mobile_type' => $mobile_type,
                    'token' => $dataSess[0]['token'],
                    'id_ses' => $dataSess[0]['id_ses']
                ];
                $this->GeneralModel->editSessionPemesanan($data_pemesan);
                // echo json_encode($this->session->userdata('pemesanan'));
                // $data_pemesan['id_ses'] = $id_ses;
                $this->session->unset_userdata('pemesanan'); // $data_session = $this->session->userdata();
                $this->session->set_userdata(['pemesanan' => $data_pemesan]);
                // echo json_encode($this->session->userdata('pemesanan'));
                redirect(base_url('order'));
            } else {
                // redirect(base_url('order'));
                echo "Session tidak ada atau tidak expired";
            }
        } else {
            $data_sess = $this->session->userdata()['pemesanan'];
            $data_sess = $this->GeneralModel->getSesPemesanan(['id_ses' => $data_sess['id_ses']])[$data_sess['id_ses']];
            if ($data_sess['ses_status'] != 1)
                $data = [
                    'page' => 'pages/pilih_menu',
                    'dataContent' => [
                        'dataSes' => $data_sess,
                        'kategori' => $this->GeneralModel->getAllKategori([], FALSE)
                    ],
                ];
            else {
                $data = [
                    'page' => '/pages/error',
                    'dataContent' => [
                        'message' => "Pesanan anda sudah dibayar, silahkan meminta qrcode baru untuk peemesanan baru..",
                        'button' => '<a href=' . base_url('cart') . ' class="book-now text-center"><i class="icofont-double-left"></i>Cart</a>'
                    ]
                ];
            }
            // echo json_encode($data);
            // die();
            $this->load->view('template/index', $data);
        }
        // } else {
        //     $data_sess = $this->session->userdata()['pemesanan'];
        //     $data_sess = $this->GeneralModel->getSesPemesanan(['id_ses' => $data_sess['id_ses']])[$data_sess['id_ses']];
        //     $data = [
        //         'page' => '/pages/pilih_menu',
        //         'dataContent' => [
        //             'dataSes' => $data_sess
        //         ]
        //     ];
        //     $this->load->view('template/index', $data);
        // }

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
            // echo json_encode($pesanan_anda);
            // die();
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
        $dataSess = $this->GeneralModel->cekToken(['date' => date('Y-m-d'), 'token' => $code]);
        $meja = $this->MejaModel->getAllMeja(['status' => '1']);
        if (!empty($dataSess)) {
            if (!empty($dataSess[0]['id_meja'] && !empty($dataSess[0]['nama_pemesan']))) {
                $data_pemesan = [
                    'nama_pemesan' => $dataSess[0]['nama_pemesan'],
                    'id_meja' => $dataSess[0]['id_meja'],
                    'ip_address' => $dataSess[0]['ip_address'],
                    'mobile_type' => $dataSess[0]['mobile_type'],
                    'token' => $dataSess[0]['token'],
                    'id_ses' => $dataSess[0]['id_ses']
                ];
                $this->session->unset_userdata('pemesanan'); // $data_session = $this->session->userdata();
                $this->session->set_userdata(['pemesanan' => $data_pemesan]);
                redirect('cart');
            } else {
                $data = [
                    'page' => '/pages/input_name',
                    'dataContent' => [
                        'dataSes' => $dataSess[0],
                        'dataMeja' => $meja
                    ]
                ];
            }
        } else {
            $data = [
                'page' => '/pages/error',

            ];
        }
        $this->load->view('template/index', $data);
    }
}
