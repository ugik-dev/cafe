<?php
defined('BASEPATH') or exit('No direct script access allowed');

class menuModel extends CI_Model
{


    public function getAllmenu($filter = [], $DataStructure = true)
    {
        $this->db->select("*");

        $this->db->from('menu as u');
        $this->db->join('kategori as j', 'u.id_kategori = j.id_kategori', 'LEFT');
        if (!empty($filter['id_menu'])) $this->db->where('id_menu', $filter['id_menu']);
        if (!empty($filter['status'])) $this->db->where('status', $filter['status']);
        if (!empty($filter['limit'])) $this->db->limit($filter['limit']);
        $res = $this->db->get();
        if ($DataStructure) return DataStructure::keyValue($res->result_array(), 'id_menu');
        else return $res->result_array();
    }

    public function addmenu($data)
    {

        $this->db->insert('menu', DataStructure::slice($data, [
            'nama_menu',  'id_kategori', 'harga', 'gambar', 'status'
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah menu", "menu");

        $id_menu = $this->db->insert_id();

        return $id_menu;
    }




    public function editmenu($data)
    {
        $this->db->set(DataStructure::slice($data, ['nama_menu',  'id_kategori', 'harga', 'gambar', 'status']));
        $this->db->where('id_menu', $data['id_menu']);
        $this->db->update('menu');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah menu", "menu");

        return $data['id_menu'];
    }

    public function deletemenu($data)
    {
        $this->db->where('id_menu', $data['id_menu']);
        $this->db->delete('menu');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus menu", "menu");
    }
}
