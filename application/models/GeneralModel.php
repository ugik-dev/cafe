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

    public function getSesPemesanan($filter = [], $key = false)
    {
        $this->db->select("*");

        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja', 'LEFT');
        if (!empty($filter['token'])) $this->db->where('u.token', $filter['token']);
        if (!empty($filter['date'])) $this->db->where('DATE(u.waktu)', $filter['date']);
        if (!empty($filter['id_ses'])) $this->db->where('id_ses', $filter['id_ses']);
        $res = $this->db->get();
        if ($key) return $res->result_array();
        return DataStructure::keyValue($res->result_array(), 'id_ses');
    }

    public function cekToken($filter)
    {
        $this->db->select("*");

        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja', 'LEFT');
        $this->db->where('u.token', $filter['token']);
        $this->db->where('DATE(u.waktu)', $filter['date']);
        // if (!empty($filter['id_ses'])) $this->db->where('id_ses', $filter['id_ses']);
        $res = $this->db->get();
        return $res->result_array();
    }
    public function getAllPesananItem($filter = [])
    {
        // $this->db->select("SUBSTRING(u.waktu,1,10)");

        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja', 'RIGHT');
        $this->db->join('pesanan as p', 'p.id_ses = u.id_ses', 'RIGHT');
        // $this->db->join('menu as mn', 'p.id_menu = mn.id_menu');

        if (!empty($filter['id_pesanan'])) $this->db->where('p.id_pesanan', $filter['id_pesanan']);
        if (!empty($filter['id_ses'])) $this->db->where('u.id_ses', $filter['id_ses']);
        if (!empty($filter['today'])) $this->db->where('SUBSTRING(u.waktu,1,10)', date('Y-m-d'));
        if (!empty($filter['c1'])) {
            if ($filter['c1'] == 'waiting_dibuat')
                $this->db->where_in('status_pesanan', ['0', '1']);
            else if ($filter['c1'] == 'waiting')
                $this->db->where('status_pesanan', 1);
            else if ($filter['c1'] == 'selesai')
                $this->db->where('status_pesanan', 2);
            else if ($filter['c1'] == 'dibatalkan')
                $this->db->where('status_pesanan', 3);
        }
        $this->db->order_by('waktu_pesanan', 'ASC');
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_pesanan');
        // echo json_encode($res->result_array());
        // die();
        // return DataStructure::groupByRecursive2(
        //     $res->result_array(),
        //     ['id_ses'],
        //     ['id_pesanan'],
        //     [
        //         ['id_ses', 'nama_pemesan',  'nama_meja', 'waktu', 'ses_status'],
        //         ['id_pesanan', 'id_menu', 'qyt', 'status_pesanan', 'nama_pesanan', 'harga_pesanan'],
        //     ],
        //     ['children']
        // );
    }
    public function getAllPesanan($filter = [])
    {
        // die();
        $this->db->select("u.*, m.*, p.*, ud.nama as nama_dapur");
        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja', 'LEFT');
        $this->db->join('pesanan as p', 'p.id_ses = u.id_ses', 'LEFT');
        $this->db->join('user as ud', 'ud.id_user = p.dapur_id', 'LEFT');
        // $this->db->join('menu as mn', 'p.id_menu = mn.id_menu');
        if (!empty($filter['token'])) $this->db->where('u.token', $filter['token']);
        if (!empty($filter['date'])) $this->db->where('DATE(u.waktu)', $filter['date']);
        if (!empty($filter['id_ses'])) $this->db->where('u.id_ses', $filter['id_ses']);
        $res = $this->db->get();
        // echo json_encode($res->result_array());
        // die();
        return DataStructure::groupByRecursive2(
            $res->result_array(),
            ['id_ses'],
            ['id_pesanan'],
            [
                ['id_ses', 'nama_pemesan', 'ip_address', 'mobile_type', 'id_meja', 'nama_meja', 'waktu', 'waktu_pembayaran', 'penerima', 'total_tagihan', 'sub_total', 'pajak', 'uang_diterima', 'ses_status'],
                ['id_pesanan', 'id_menu', 'qyt', 'status_pesanan', 'nama_pesanan', 'harga_pesanan', 'nama_dapur'],
            ],
            ['children']
        );
    }

    public function getAllPesanan2($filter = [], $key = false)
    {
        // echo (isset($filter['status']));
        // die();
        $this->db->select("u.*,ud.nama as nama_dapur,m.nama_meja, sum(qyt) as total_qyt,sum(qyt*harga) as total_harga");

        $this->db->from('ses_pemesanan as u');
        $this->db->join('meja as m', 'm.id_meja = u.id_meja', 'LEFT');
        $this->db->join('pesanan as p', 'p.id_ses = u.id_ses', 'LEFT');
        $this->db->join('user as ud', 'ud.id_user = p.dapur_id', 'LEFT');
        $this->db->join('menu as mn', 'p.id_menu = mn.id_menu', 'LEFT');
        $this->db->group_by('u.id_ses');
        if (!empty($filter['id_ses'])) $this->db->where('u.id_ses', $filter['id_ses']);
        if (isset($filter['status'])) {
            if ($filter['status'] == '0') $this->db->where('u.ses_status', '0');
            if ($filter['status'] == '1') $this->db->where('u.ses_status', '1');
        }
        if (!empty($filter['date_start'])) $this->db->where('u.waktu >= "' . $filter['date_start'] . ' 00:00:00"');
        if (!empty($filter['date_end'])) $this->db->where('u.waktu <= "' . $filter['date_end'] . ' 23:59:59"');
        if (!empty($filter['date'])) {
            $this->db->where('u.waktu >= "' . $filter['date'] . ' 00:00:00"');
            $this->db->where('u.waktu <= "' . $filter['date'] . ' 23:59:59"');
        }
        $res = $this->db->get();
        if ($key) return $res->result_array();
        else
            return DataStructure::keyValue($res->result_array(), 'id_ses');
    }


    public function addSessionPemesanan($data)
    {
        // echo 'ok';
        $this->db->insert('ses_pemesanan', DataStructure::slice($data, [
            'nama_pemesan',  'id_meja', 'ip_address', 'mobile_type', 'token', 'add_id'
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Meja", "ses_pemesanan");

        $id_meja = $this->db->insert_id();

        return $id_meja;
    }
    public function editSessionPemesanan($data)
    {
        // echo 'ok';
        $this->db->where('id_ses', $data['id_ses']);
        $this->db->update('ses_pemesanan', DataStructure::slice($data, [
            'nama_pemesan',  'id_meja', 'ip_address', 'mobile_type', 'token', 'add_id'
        ], TRUE));
        ExceptionHandler::handleDBError($this->db->error(), "Tambah Meja", "ses_pemesanan");

        // $id_meja = $this->db->insert_id();

        return $data['id_ses'];
    }
    public function pushPesanan($data)
    {
        // echo 'ok';
        foreach ($data as $d) {

            $this->db->insert('pesanan', $d);
        }
    }
}
