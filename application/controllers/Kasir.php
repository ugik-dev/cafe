<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'KasirModel'));
        // var_dump($this->session->userdata());
        $this->SecurityModel->roleOnlyGuard('kasir');
    }
    public function index()
    {
        $data = [
            'page' => 'kasir/dashboard'
        ];
        $this->load->view('template_user/index', $data);
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
        // if (!empty($this->session->userdata()['pemesanan'])) {
        // $id_ses = $this->session->userdata()['pemesanan']['id_ses'];
        $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses])[$id_ses];
        $data = [
            'page' => '/kasir/cart',
            'dataContent' => [
                'dataSes' => $pesanan_anda
            ]
        ];
        $this->load->view('template_user/index', $data);
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
            $data['waktu_pembayaran'] = date("Y-m-d H:i:s");
            $this->KasirModel->konfirmasiBayar($data);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
