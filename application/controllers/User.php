<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'UserModel'));
    }
    public function index()
    {
        $this->SecurityModel->guestOnlyGuard();

        $data = [
            'page' => 'pages/login'
        ];
        $this->load->view('template/index', $data);
    }

    public function loginProcess()
    {
        try {
            $this->SecurityModel->guestOnlyGuard(TRUE);
            Validation::ajaxValidateForm($this->SecurityModel->loginValidation());

            $loginData = $this->input->post();

            $user = $this->UserModel->login($loginData);

            $this->session->set_userdata(['login' => $user]);
            echo json_encode(array("error" => FALSE, "user" => $user));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
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

    public function update()
    {
        try {
            $profile = $this->input->post();
            $profile['id_user'] = $this->session->userdata('id_user');
            $newProfile = $this->UserModel->updateDosenLocal($profile);
            $oldSess = $this->session->userdata();
            $this->session->set_userdata(array_merge($oldSess, $newProfile));
            $profile = DataStructure::slice($this->session->userdata(), ['nidn', 'nohp', 'telepon', 'email', 'bidang_keahlian']);
            echo json_encode(array('profile' => $profile));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function changePassword()
    {
        try {
            $this->SecurityModel->roleOnlyGuard('pengusul', TRUE);
            $this->SecurityModel->pengusulSubTypeGuard(['dosen_tendik'], TRUE);
            // Validation::ajaxValidateForm($this->SecurityModel->deleteDosenTendik());

            $CP = $this->input->post();
            if (md5($CP['old_password']) != $this->session->userdata('password')) {
                throw new UserException('Password Lama Salah', 0);
            }
            $this->UserModel->changePassword($CP);
            $this->session->set_userdata('password', md5($CP['password']));
            echo json_encode(array());
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function changeUsername()
    {
        $this->SecurityModel->apiKeyGuard();
        try {
            $data = $this->input->post();

            if (!isset($data['username']) || !isset($data['username_new'])) {
                throw new UserException('Parameter tidak lengkap', 0);
            }
            $this->UserModel->changeUsername($data);
            echo json_encode(array());
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

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
            if ($user['id_role'] == '2') {
                $id = $this->PerusahaanModel->getAll(array('is_user' => '1', 'id_user' => $user['id_user']));
                $this->PerusahaanModel->updateModifedDate($id);
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

    public function logout()
    {
        // $this->SecurityModel->userOnlyGuard();
        $this->session->sess_destroy();
        redirect(base_url());
        // echo json_encode(["error" => FALSE, 'data' => 'Logout berhasil.']);
    }
}
