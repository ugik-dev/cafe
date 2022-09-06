<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DapurModel extends CI_Model
{
    public  function edit_pesanan($id, $status)
    {
        // echo $id . $status;
        $this->db->set('status_pesanan', $status);
        $this->db->set('dapur_id', $this->session->userdata('login')['id_user']);
        $this->db->where('id_pesanan', $id);
        $this->db->update('pesanan');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah Status Pesanan", "pesanan");

        // return $data['id_ses'];
    }
}
