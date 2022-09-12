<?php
class CustomFunctions
{
  public static function status_permohonan_word($textrun, $status)
  {
    if ($status == 'DIMULAI')
      $textrun->addText('Draft', array('name' => 'Times New Roman', 'size' => 12, 'color' => 'f8ac59'));
    else if ($status == 'DIPROSES')
      $textrun->addText('Diproses', array('name' => 'Times New Roman', 'size' => 12, 'color' => '007bff'));
    else if ($status == 'DITERIMA')
      $textrun->addText('Diterima', array('name' => 'Times New Roman', 'size' => 12, 'color' => '28a745'));
    else if ($status == 'DITOLAK')
      $textrun->addText('Ditolak', array('name' => 'Times New Roman', 'size' => 12, 'color' => 'ed5565'));
    else
      $textrun->addText('-', array('name' => 'Times New Roman', 'size' => 12));
  }

  public static function tanggal_indonesia($tanggal)
  {
    if (empty($tanggal)) return '';
    $BULAN = [0, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $t = explode('-', $tanggal);
    return "{$t[2]} {$BULAN[intval($t[1])]} {$t[0]}";
  }
}
if (!function_exists('statusSession')) {
  function statusSession($status)
  {
    if ($status == "0")
      return "<i class='font-sanicod-clock text-danger'> Belum dibayar</i>";
    else if ($status == "1")
      return "<i class='icofont-restaurant text-success'> Sudah dibayar</i>";
  }
}

if (!function_exists('JamBuka')) {
  function JamBuka($cur = false)
  {
    $ci = &get_instance();
    $ci->db->select('*');
    $ci->db->from('jam_buka');
    if ($cur) {
      $ci->db->where('hari', date('N'));
      $cur_time = date("h:i");
      $ci->db->where('TIME(jam_start) <= "' . $cur_time . '"');
      $ci->db->where('TIME(jam_end) >= "' . $cur_time . '"');
    }

    $res = $ci->db->get();
    $res = $res->result_array();
    return $res;
  }
}


if (!function_exists('HotOffer')) {
  function HotOffer()
  {
    $ci = &get_instance();
    $ci->db->select('*');
    $ci->db->from('menu');
    // if ($cur) {
    // $ci->db->where('speca', 'Y');
    $ci->db->where('spesial', 'Y');

    $ci->db->limit(1);

    //   $cur_time = date("h:i");
    //   $ci->db->where('TIME(jam_start) <= "' . $cur_time . '"');
    //   $ci->db->where('TIME(jam_end) >= "' . $cur_time . '"');
    // }

    $res = $ci->db->get();
    $res = $res->result_array();
    if (!empty($res))
      $ret['spesial'] = $res[0];
    else {
      $ci = &get_instance();
      $ci->db->select('*');
      $ci->db->from('menu');
      $ci->db->where('promo', 'Y');
      $ci->db->limit(1);
      $res = $ci->db->get();
      $res = $res->result_array();
      if (!empty($res))
        $ret['spesial'] = $res[0];
    }

    $ci = &get_instance();
    // $ci->db->select('spesial,promo,rekomendasi');
    $ci->db->from('menu');
    // $ci->db->where('promo', 'Y');
    $ci->db->limit(6);
    $ci->db->order_by('spesial,promo,rekomendasi', 'DESC');

    $res = $ci->db->get();
    $res = $res->result_array();
    $ret['promo'] = $res;
    // echo $ci->db->last_query();
    return $ret;
    // echo json_encode($ret);
  }
}
