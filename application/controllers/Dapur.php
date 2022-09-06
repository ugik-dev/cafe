<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dapur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'DapurModel'));
        // var_dump($this->session->userdata());
        $this->SecurityModel->roleOnlyGuard('dapur');
    }
    public function index()
    {
        $data = [
            'page' => 'dapur/dashboard'
        ];
        $this->load->view('template_user/index', $data);
    }

    public function getListPesanan()
    {
        try {
            $filter = $this->input->get();
            $pesanan_anda =   $this->GeneralModel->getAllPesananItem($filter);
            echo json_encode(['error' => false, 'data' => $pesanan_anda]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        } // } else {
        //     redirect(base_url());
        // }
    }

    public function terima()
    {
        try {
            $id = $this->input->get()['id_pesanan'];
            $valid_data =   $this->GeneralModel->getAllPesananItem(['id_pesanan' => $id])[$id];
            if ($valid_data['status_pesanan'] != 0)
                throw new UserException('Pesanan sudah diterima atau dibatalkan', UNAUTHORIZED_CODE);

            $this->DapurModel->edit_pesanan($id, 1);
            $valid_data =   $this->GeneralModel->getAllPesananItem(['id_pesanan' => $id])[$id];
            echo json_encode(['error' => false, 'data' => $valid_data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function selesai()
    {
        try {
            $id = $this->input->get()['id_pesanan'];
            $valid_data =   $this->GeneralModel->getAllPesananItem(['id_pesanan' => $id])[$id];
            if ($valid_data['status_pesanan'] == 3)
                throw new UserException('Pesanan sudah dibatalkan', UNAUTHORIZED_CODE);

            $this->DapurModel->edit_pesanan($id, 2);
            $valid_data =   $this->GeneralModel->getAllPesananItem(['id_pesanan' => $id])[$id];
            echo json_encode(['error' => false, 'data' => $valid_data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    public function batalkan()
    {
        try {
            $id = $this->input->get()['id_pesanan'];
            $valid_data =   $this->GeneralModel->getAllPesananItem(['id_pesanan' => $id])[$id];
            if ($valid_data['status_pesanan'] ==  "2")
                throw new UserException('Pesanan sudah selesai', UNAUTHORIZED_CODE);

            $this->DapurModel->edit_pesanan($id, 3);
            $valid_data =   $this->GeneralModel->getAllPesananItem(['id_pesanan' => $id])[$id];
            echo json_encode(['error' => false, 'data' => $valid_data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
