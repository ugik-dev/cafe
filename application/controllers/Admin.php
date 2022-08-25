<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel', 'MejaModel', 'MenuModel'));
        // var_dump($this->session->userdata());
        $this->SecurityModel->roleOnlyGuard('admin');
    }
    public function index()
    {
        $data = [
            'page' => 'admin/dashboard'
        ];
        $this->load->view('template_user/index', $data);
    }

    public function pengguna()
    {
        // var_dump($this->session->userdata());
        $data = [
            'page' => 'admin/pengguna',
            'dataContent' => [
                // 'nama_meja' => $id
            ]
        ];
        $this->load->view('template_user/index', $data);
    }
    public function meja()
    {
        // var_dump($this->session->userdata());
        $data = [
            'page' => 'admin/meja',
            'dataContent' => [
                // 'nama_meja' => $id
            ]
        ];
        $this->load->view('template_user/index', $data);
    }
    public function menu()
    {
        // var_dump($this->session->userdata());
        $data = [
            'page' => 'admin/menu',
            'dataContent' => [
                // 'nama_meja' => $id
            ]
        ];
        $this->load->view('template_user/index', $data);
    }
    // function
    public function getAllUser()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->UserModel->getAllUser($this->input->post());
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getAllRole()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->UserModel->getAllRole($this->input->get());
            echo json_encode(array("data" => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function addUser()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $idUser = $this->UserModel->addUser($this->input->post());
            $user = $this->UserModel->getUser($idUser);
            echo json_encode(array("data" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function editUser()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $idUser = $this->UserModel->editUser($this->input->post());
            $user = $this->UserModel->getUser($idUser);
            if ($user['id_user'] == $this->session->userdata('id_user')) {
                $this->session->set_userdata(array_merge($this->session->userdata(), $user));
            }
            echo json_encode(array("data" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function deleteUser()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->input->post();
            $this->UserModel->deleteUser($data);
            echo json_encode(array());
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function addMeja()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $idMeja = $this->MejaModel->addMeja($this->input->post());
            $user = $this->MejaModel->getAllMeja(array('id_meja' => $idMeja))[$idMeja];
            echo json_encode(array("data" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function editMeja()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $idMeja = $this->MejaModel->editMeja($this->input->post());
            $user = $this->MejaModel->getAllMeja(array('id_meja' => $idMeja))[$idMeja];
            echo json_encode(array("data" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function deleteMeja()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->input->post();
            $this->MejaModel->deleteMeja($data);
            echo json_encode(array());
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function addMenu()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            if (!empty($_FILES['file_gambar']['name'])) {
                echo 'ada ';
                $config['upload_path'] = 'uploads/menu';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '1000'; // max_size in kb 
                $config['encrypt_name'] = TRUE; // max_size in kb 

                $config['file_name'] = $_FILES['file_gambar']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_gambar')) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                } else {
                    throw new UserException('Upload file Gagal');
                }
            }
            $data = $this->input->post();
            if (!empty($filename)) $data['gambar'] = $filename;
            $idMenu = $this->MenuModel->addMenu($data);
            $user = $this->MenuModel->getAllMenu(array('id_menu' => $idMenu))[$idMenu];
            echo json_encode(array("data" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function editMenu()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            if (!empty($_FILES['file_gambar']['name'])) {
                // echo 'ada ';
                $config['upload_path'] = 'uploads/menu';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['max_size'] = '1000'; // max_size in kb 
                $config['encrypt_name'] = TRUE; // max_size in kb 

                $config['file_name'] = $_FILES['file_gambar']['name'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file_gambar')) {
                    // Get data about the file
                    $uploadData = $this->upload->data();
                    $filename = $uploadData['file_name'];
                } else {
                    throw new UserException('Upload file Gagal');
                }
            }
            $data = $this->input->post();
            if (!empty($filename)) $data['gambar'] = $filename;
            $idMenu = $this->MenuModel->editMenu($data);
            $user = $this->MenuModel->getAllMenu(array('id_menu' => $idMenu))[$idMenu];
            echo json_encode(array("data" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function deleteMenu()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->input->post();
            $this->MenuModel->deleteMenu($data);
            echo json_encode(array());
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
