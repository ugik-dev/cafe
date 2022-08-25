<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'MejaModel', 'GeneralModel', 'MenuModel'));
        // var_dump($this->session->userdata());
        // $this->SecurityModel->roleOnlyGuard('admin');
    }
    public function getAllMeja()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->MejaModel->getAllMeja($this->input->post());
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllMenu()
    {
        try {
            // $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->MenuModel->getAllMenu($this->input->post());
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllKategori()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->GeneralModel->getAllKategori($this->input->post());
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
