<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KasirModel extends CI_Model
{
    public  function konfirmasiBayar($data)
    {
        $this->db->set(DataStructure::slice($data, ['id_penerima', 'nama_penerima', 'penerima', 'waktu_pembayaran', 'total_tagihan', 'sub_total', 'pajak', 'uang_diterima', 'ses_status']));
        $this->db->where('id_ses', $data['id_ses']);
        $this->db->update('ses_pemesanan');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah User", "ses_pemesanan");

        return $data['id_ses'];
    }
}
