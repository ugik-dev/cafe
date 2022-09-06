<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'KasirModel'));
        // var_dump($this->session->userdata());
        $this->SecurityModel->rolesOnlyGuard(['kasir', 'admin']);
    }
    public function add_barcode()
    {
        $token = $this->random_str(5, '1234567890abcdefghijklmnopqrstuvwxyz');

        $data_pemesan = [
            'token' => $token,
            'add_id' => $this->session->userdata('id_user'),
            // 'ip_address' => $this->input->ip_address(),
            // 'mobile_type' => $mobile_type
        ];
        $id_ses = $this->GeneralModel->addSessionPemesanan($data_pemesan);


        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = false; //boolean, the default is true
        $config['cachedir']     = './uploads/'; //string, the default is application/cache/
        $config['errorlog']     = './uploads/'; //string, the default is application/logs/
        $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '200'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name =  date('Ymd') . '-' . $token . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = base_url() . 'order/' . $token; //data yang akan di jadikan QR CODE
        $params['level'] = 'S'; //H=High
        $params['size'] = 7;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data = $this->GeneralModel->getAllPesanan2(['id_ses' => $id_ses], true);
        echo json_encode(['error' => false, 'data' => $data[0]]);
    }
    public function index()
    {
        $data = [
            'page' => 'kasir/dashboard'
        ];
        $this->load->view('template_user/index', $data);
    }
    function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
    public function getListPesanan()
    {
        try {
            $filter = $this->input->get();
            // if (!empty($this->session->userdata()['pemesanan'])) {
            //     $id_ses = $this->session->userdata()['pemesanan']['id_ses'];
            if (empty($filter['id_ses']))
                $pesanan_anda =   $this->GeneralModel->getAllPesanan2();
            else
                $pesanan_anda =   $this->GeneralModel->getAllPesanan($filter)[$filter['id_ses']];
            echo json_encode(['error' => false, 'data' => $pesanan_anda]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        } // } else {
        //     redirect(base_url());
        // }
    }

    public function cart($id_ses)
    {
        $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses])[$id_ses];
        $data = [
            'page' => '/kasir/cart',
            'dataContent' => [
                'dataSes' => $pesanan_anda
            ]
        ];
        $this->load->view('template_user/index', $data);
    }

    public function qrcode($id_ses)
    {
        $data_qr =   $this->GeneralModel->getSesPemesanan(['id_ses' =>  $id_ses])[$id_ses];
        $data = [
            'page' => '/kasir/cetak_qr',
            'dataContent' => $data_qr

        ];
        $this->load->view('/kasir/cetak_qr', $data);
    }

    public function cetak($id_ses)
    {
        $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses])[$id_ses];
        if ($pesanan_anda['ses_status'] == 1) {
            $data = [
                'page' => '/kasir/cetak',
                'dataContent' => [
                    'dataSes' => $pesanan_anda
                ]
            ];
            $this->load->view('/kasir/cetak', $data);
        } else {
            $data = [
                'page' => '/pages/error',
                'dataContent' => [
                    'message' => "Pesanan ini belum dibayar",
                    'button' => '<a href=' . base_url('kasir') . ' class="book-now text-center"><i class="icofont-double-left"></i>Kembali</a>'
                ]
            ];
            $this->load->view('template_user/index', $data);
        }
    }

    public function konfirmasi_bayar()
    {
        try {

            $data = $this->input->post();
            $data['id_penerima'] = $this->session->userdata('login')['id_user'];
            $data['penerima'] = $this->session->userdata('login')['nama'];
            $data['ses_status'] = "1";
            $data['total_tagihan'] = preg_replace("/[^0-9]/", "", $data['total_tagihan']);
            $data['uang_diterima'] = preg_replace("/[^0-9]/", "", $data['uang_diterima']);
            $data['sub_total'] = preg_replace("/[^0-9]/", "", $data['sub_total']);
            $data['pajak'] = preg_replace("/[^0-9]/", "", $data['pajak']);
            $data['waktu_pembayaran'] = date("Y-m-d H:i:s");
            $this->KasirModel->konfirmasiBayar($data);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
