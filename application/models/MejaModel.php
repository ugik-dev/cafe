<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MejaModel extends CI_Model
{


    public function getAllMeja($filter = [], $DataStructure = true)
    {
        $this->db->select("*");

        $this->db->from('meja as u');
        if (!empty($filter['id_meja'])) $this->db->where('id_meja', $filter['id_meja']);
        if (!empty($filter['code'])) $this->db->where('code', $filter['code']);
        if (!empty($filter['status'])) $this->db->where('status', $filter['status']);
        if (!empty($filter['limit'])) $this->db->limit($filter['limit']);
        $res = $this->db->get();
        if ($DataStructure) return DataStructure::keyValue($res->result_array(), 'id_meja');
        else return $res->result_array();
    }

    public function addMeja($data)
    {

        $this->db->insert('meja', DataStructure::slice($data, [
            'nama_meja',  'code', 'status'
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Meja", "Meja");

        $id_meja = $this->db->insert_id();

        return $id_meja;
    }




    public function editMeja($data)
    {
        $this->db->set(DataStructure::slice($data, ['nama_meja',  'code', 'status']));
        $this->db->where('id_meja', $data['id_meja']);
        $this->db->update('meja');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah Meja", "Meja");

        return $data['id_meja'];
    }

    public function deleteMeja($data)
    {
        $this->db->where('id_meja', $data['id_meja']);
        $this->db->delete('meja');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Meja", "Meja");
    }
}
