<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GeneralModel extends CI_Model
{
    public function getAllKategori($filter = [])
    {
        $this->db->select("*");

        $this->db->from('kategori as u');
        if (!empty($filter['id_kategori'])) $this->db->where('id_kategori', $filter['id_kategori']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_kategori');
    }

    public function getSesPemesanan($filter = [])
    {
        $this->db->select("*");

        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja');
        if (!empty($filter['id_ses'])) $this->db->where('id_ses', $filter['id_ses']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_ses');
    }

    public function getAllPesanan($filter = [])
    {
        $this->db->select("*");

        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja');
        $this->db->join('pesanan as p', 'p.id_ses = u.id_ses', 'RIGHT');
        // $this->db->join('menu as mn', 'p.id_menu = mn.id_menu');
        if (!empty($filter['id_ses'])) $this->db->where('u.id_ses', $filter['id_ses']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        return DataStructure::groupByRecursive2(
            $res->result_array(),
            ['id_ses'],
            ['id_pesanan'],
            [
                ['id_ses', 'nama_pemesan', 'ip_address', 'mobile_type', 'id_meja', 'nama_meja', 'waktu', 'waktu_pembayaran', 'penerima', 'total_tagihan', 'uang_diterima', 'ses_status'],
                ['id_pesanan', 'id_menu', 'qyt', 'status_pesanan', 'nama_pesanan', 'harga_pesanan'],
            ],
            ['children']
        );
    }

    public function getAllPesanan2($filter = [])
    {
        $this->db->select("u.*,m.nama_meja, sum(qyt) as total_qyt,sum(qyt*harga) as total_harga");

        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja');
        $this->db->join('pesanan as p', 'p.id_ses = u.id_ses');
        $this->db->join('menu as mn', 'p.id_menu = mn.id_menu');
        $this->db->group_by('u.id_ses');
        if (!empty($filter['id_ses'])) $this->db->where('u.id_ses', $filter['id_ses']);
        $res = $this->db->get();
        return DataStructure::keyValue(
            $res->result_array(),
            'id_ses'
            // $res->result_array(),
            // ['id_ses'],
            // ['id_pesanan'],
            // [
            //     ['id_ses', 'nama_pemesan', 'ip_address', 'mobile_type', 'id_meja', 'nama_meja'],
            //     ['id_pesanan', 'id_menu', 'qyt', 'status_pesanan', 'nama_menu', 'harga'],
            // ],
            // ['children']
        );
    }


    public function addSessionPemesanan($data)
    {
        // echo 'ok';
        $this->db->insert('ses_pemesanan', DataStructure::slice($data, [
            'nama_pemesan',  'id_meja', 'ip_address', 'mobile_type'
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Meja", "ses_pemesanan");

        $id_meja = $this->db->insert_id();

        return $id_meja;
    }

    public function pushPesanan($data)
    {
        // echo 'ok';
        foreach ($data as $d) {

            $this->db->insert('pesanan', $d);
        }
    }
}
