<?php
defined('BASEPATH') or exit('No direct script access allowed');

// use Dompdf\Dompdf;
// require_once './vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Kasir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('SecurityModel', 'GeneralModel', 'KasirModel'));
        // var_dump($this->session->userdata());
        $this->SecurityModel->rolesOnlyGuard(['kasir', 'admin']);
    }
    public function add_barcode()
    {
        $token = $this->random_str(5, '1234567890abcdefghijklmnopqrstuvwxyz');

        $data_pemesan = [
            'token' => $token,
            'add_id' => $this->session->userdata('id_user'),
            // 'ip_address' => $this->input->ip_address(),
            // 'mobile_type' => $mobile_type
        ];
        $id_ses = $this->GeneralModel->addSessionPemesanan($data_pemesan);


        $this->load->library('ciqrcode'); //pemanggilan library QR CODE

        $config['cacheable']    = false; //boolean, the default is true
        $config['cachedir']     = './uploads/'; //string, the default is application/cache/
        $config['errorlog']     = './uploads/'; //string, the default is application/logs/
        $config['imagedir']     = './uploads/qrcode/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '200'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name =  date('Ymd') . '-' . $token . '.png'; //buat name dari qr code sesuai dengan nim

        $params['data'] = base_url() . 'order/' . $token; //data yang akan di jadikan QR CODE
        $params['level'] = 'S'; //H=High
        $params['size'] = 7;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        $data = $this->GeneralModel->getAllPesanan2(['id_ses' => $id_ses], true);
        echo json_encode(['error' => false, 'data' => $data[0]]);
    }
    public function index()
    {
        $data = [
            'page' => 'kasir/dashboard'
        ];
        $this->load->view('template_user/index', $data);
    }
    function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }
    public function getListPesanan()
    {
        try {
            $filter = $this->input->get();
            // if (!empty($this->session->userdata()['pemesanan'])) {
            //     $id_ses = $this->session->userdata()['pemesanan']['id_ses'];
            if (empty($filter['id_ses']))
                $pesanan_anda =   $this->GeneralModel->getAllPesanan2($filter);
            else
                $pesanan_anda =   $this->GeneralModel->getAllPesanan($filter)[$filter['id_ses']];
            echo json_encode(['error' => false, 'data' => $pesanan_anda]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        } // } else {
        //     redirect(base_url());
        // }
    }

    public function cart($id_ses)
    {
        $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses])[$id_ses];
        $data = [
            'page' => '/kasir/cart',
            'dataContent' => [
                'dataSes' => $pesanan_anda
            ]
        ];
        $this->load->view('template_user/index', $data);
    }

    public function qrcode($id_ses)
    {
        $data_qr =   $this->GeneralModel->getSesPemesanan(['id_ses' =>  $id_ses])[$id_ses];
        $data = [
            'page' => '/kasir/cetak_qr',
            'dataContent' => $data_qr

        ];
        $this->load->view('/kasir/cetak_qr', $data);
    }

    public function qrcode_pdf($id_ses)
    {

        $dataContent =   $this->GeneralModel->getSesPemesanan(['id_ses' =>  $id_ses])[$id_ses];
        $htmlScript = '<style>
            #invoice-POS {
                box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
                padding: 2mm;
                margin: 0 auto;
                width: 44mm;
                background: #FFF;
            }

            ::selection {
                background: #f31544;
                color: #FFF;
            }

            ::moz-selection {
                background: #f31544;
                color: #FFF;
            }

            h1 {
                font-size: 1.5em;
                color: #222;
            }

            h2 {
                font-size: .9em;
            }

            h3 {
                font-size: 1.2em;
                font-weight: 300;
                line-height: 2em;
            }

            p {
                font-size: .7em;
                color: #666;
                line-height: 1.2em;
            }

            #top,
            #mid,
            #bot {
                border-bottom: 1px solid #EEE;
            }

            #top {
                height: 105px;
            }

            #mid {
                min-height: 80px;
            }

            #bot {
                min-height: 50px;
            }

            #top .logo {
                /* //float: left; */
                height: 60px;
                width: 60px;
                background: url(' . base_url('assets/img/logo-black-white.png') . ') no-repeat;
                background-size: 60px 60px;
            }

            .clientlogo {
                float: left;
                height: 60px;
                width: 60px;
                background: (' . base_url('assets/img/logo-black-white.png') . ') no-repeat;
                background-size: 60px 60px;
                border-radius: 50px;
            }

            .info {
                display: block;
                /* float: left; */
                margin-left: 0;
            }

            .title {
                float: right;
            }

            .title p {
                text-align: right;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            td {
                /* //padding: 5px 0 5px 15px;
                //border: 1px solid #EEE */
            }

            .tabletitle {
                /* //padding: 5px; */
                font-size: .5em;
                background: #EEE;
            }

            .service {
                border-bottom: 1px solid #EEE;
            }

            .item {
                width: 24mm;
            }

            .itemtext {
                font-size: .5em;
            }

            #legalcopy {
                margin-top: 5mm;
            }
                    </style>
                    <div id="invoice-POS">

                        <center id="top">
                            <img style=" height: 60px; width: 60px;" src="' . base_url('assets/img/logo-black-white.png') . '" alt="">
                            <div class="info">
                                <h2 style="margin-bottom: 0 !important">SIGUNTANG</h2>
                                <h5 style="margin-top: 0 !important">Cafe & Resto</h5>
                            </div>

                        </center>
                        <div>
                            <center>
                                <h6 style="margin: 2;"> Untuk pemesanan silahkan scan barcode dibawah </h6>
                                <img style=" height: 120px; width: 120px;" src="' . base_url('uploads/qrcode/') . str_replace('-', '', (explode(' ', $dataContent['waktu'])[0])) . '-' . $dataContent['token'] . '.png' . '" alt="">
                            </center>
                        </div>
                        <div>
                            <center>
                                <h6 style="margin: 2;"> Atau masuk kealamat berikut : </h6>
                                <h5 style="margin: 2;">' . base_url('') . '<br>order/' . $dataContent['token']  . '</h5>
                                <!--End Info-->
                            </center>
                        </div>
                    </div>';
        $options = new Options();
        // $options->set('defaultFont', 'Courier');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlScript);
        $dompdf->setPaper(array(0, 0, 204, 400));
        $dompdf->render();

        // // Output the generated PDF (1 = download and 0 = preview)
        $dompdf->stream("qrcode.pdf", array("Attachment" => 0));
    }
    public function cetak($id_ses)
    {
        $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses])[$id_ses];
        if ($pesanan_anda['ses_status'] == 1) {
            $data = [
                'page' => '/kasir/cetak',
                'dataContent' => [
                    'dataSes' => $pesanan_anda
                ]
            ];
            $this->load->view('/kasir/cetak', $data);
        } else {
            $data = [
                'page' => '/pages/error',
                'dataContent' => [
                    'message' => "Pesanan ini belum dibayar",
                    'button' => '<a href=' . base_url('kasir') . ' class="book-now text-center"><i class="icofont-double-left"></i>Kembali</a>'
                ]
            ];
            $this->load->view('template_user/index', $data);
        }
    }

    public function cetak_pdf($id_ses)
    {
        $pesanan_anda =   $this->GeneralModel->getAllPesanan(['id_ses' =>  $id_ses])[$id_ses];
        if ($pesanan_anda['ses_status'] == 1) {
            $dataContent['dataSes'] = $pesanan_anda;
            // $data = [
            //     'page' => '/kasir/cetak',
            //     'dataContent' => [
            //         'dataSes' => $pesanan_anda
            //     ]
            // ];
            // $this->load->view('/kasir/cetak', $data);
        } else {
            // $data = [
            //     'page' => '/pages/error',
            //     'dataContent' => [
            //         'message' => "Pesanan ini belum dibayar",
            //         'button' => '<a href=' . base_url('kasir') . ' class="book-now text-center"><i class="icofont-double-left"></i>Kembali</a>'
            //     ]
            // ];
            // $this->load->view('template_user/index', $data);
        }
        $tbl =    '';

        $total = 0;
        foreach ($dataContent['dataSes']['children'] as $d) {
            if ($d['status_pesanan'] != '3') {
                $total = ($d['qyt'] * $d['harga_pesanan']) + $total;

                $tbl .=    '<tr class="service"><td class="tableitem">
                                <p class="itemtext">' . $d['nama_pesanan'] . '</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">' . $d['qyt '] . '</p>
                            </td>
                            <td class="tableitem" style="text-align: right;">
                                <p class="itemtext" style="margin-right: 5px;">' . (number_format($d['qyt'] * $d['harga_pesanan'])) . '</p>
                            </td>
                        </tr>';
            } else {
                $tbl .=  '  <tr class="service">
                            <td class="tableitem">
                                <del style="text-decoration-style: double;">
                                    <p class="itemtext">' . $d['nama_pesanan'] . '</p>
                                </del>
                            </td>
                            <td class="tableitem">
                                <del style="text-decoration-style: double;">
                                    <p class="itemtext">' . $d['qyt'] . '</p>
                                </del>
                            </td>
                            <td class="tableitem" style="text-align: right;">
                                <del style="text-decoration-style: double;">
                                    <p class="itemtext" style="margin-right: 5px;">' . number_format($d['qyt'] * $d['harga_pesanan']) . '</p>
                                </del>
                            </td>
                        </tr>';
            }
        }

        $htmlScript = '
        
        <style>
                                    #invoice-POS {
                                        box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
                                        padding: 2mm;
                                        margin: 0 auto;
                                        width: 44mm;
                                        background: #FFF;
                                    }

                                    ::selection {
                                        background: #f31544;
                                        color: #FFF;
                                    }

                                    ::moz-selection {
                                        background: #f31544;
                                        color: #FFF;
                                    }

                                    h1 {
                                        font-size: 1.5em;
                                        color: #222;
                                    }

                                    h2 {
                                        font-size: .9em;
                                    }

                                    h3 {
                                        font-size: 1.2em;
                                        font-weight: 300;
                                        line-height: 2em;
                                    }

                                    p {
                                        font-size: .7em;
                                        color: #666;
                                        line-height: 1.2em;
                                    }

                                    #top,
                                    #mid,
                                    #bot {
                                        border-bottom: 1px solid #EEE;
                                    }

                                    #top {
                                        height: 105px;
                                    }

                                    #mid {
                                        min-height: 80px;
                                    }

                                    #bot {
                                        min-height: 50px;
                                    }

                                    #top .logo {
                                        /* //float: left; */
                                        height: 60px;
                                        width: 60px;
                                        background: url(' . base_url('assets/img/logo-black-white.png') . ') no-repeat;
                                        background-size: 60px 60px;
                                    }

                                    .clientlogo {
                                        float: left;
                                        height: 60px;
                                        width: 60px;
                                        background: (' . base_url('assets/img/logo-black-white.png') . ') no-repeat;
                                        background-size: 60px 60px;
                                        border-radius: 50px;
                                    }

                                    .info {
                                        display: block;
                                        /* float: left; */
                                        margin-left: 0;
                                    }

                                    .title {
                                        float: right;
                                    }

                                    .title p {
                                        text-align: right;
                                    }

                                    table {
                                        width: 100%;
                                        border-collapse: collapse;
                                    }

                                    td {
                                        /* //padding: 5px 0 5px 15px;
                                        //border: 1px solid #EEE */
                                    }

                                    .tabletitle {
                                        /* //padding: 5px; */
                                        font-size: .5em;
                                        background: #EEE;
                                    }

                                    .service {
                                        border-bottom: 1px solid #EEE;
                                    }

                                    .item {
                                        width: 24mm;
                                    }

                                    .itemtext {
                                        font-size: .5em;
                                    }

                                    #legalcopy {
                                        margin-top: 5mm;
                                    }
                                </style>
                                <div style="margin: 0; padding: 0" id="invoice-POS">

                                    <center id="top">
                                        <img style=" height: 60px; width: 60px;" src="' . base_url('assets/img/logo-black-white.png') . '" alt="">
                                        <div class="info">
                                            <h2 style="margin-bottom: 0 !important">SIGUNTANG</h2>
                                            <h5 style="margin-top: 0 !important">Cafe & Resto</h5>
                                        </div>
                                    </center>


                                    <div id="bot">

                                        <div id="table">
                                            <table>
                                                <tr class="tabletitle">
                                                    <td class="item">
                                                        <h2>Item</h2>
                                                    </td>
                                                    <td class="Hours">
                                                        <h2>Qty</h2>
                                                    </td>
                                                    <td class="Rate">
                                                        <h2>Jumlah</h2>
                                                    </td>
                                                </tr>
                                            
                                ' . $tbl . '
                                                <tr class="tabletitle">
                                                    <td></td>
                                                    <td class="Rate">
                                                        <h2>Sub Total</h2>
                                                    </td>
                                                    <td class="payment" style="text-align: right;">
                                                        <h2 style="margin-right: 5px;">' . number_format($dataContent['dataSes']['sub_total']) . '</h2>
                                                    </td>
                                                </tr>
                                                <tr class="tabletitle">
                                                    <td></td>
                                                    <td class="Rate">
                                                        <h2>Pajak 10%</h2>
                                                    </td>
                                                    <td class="payment" style="text-align: right;">
                                                        <h2 style="margin-right: 5px;">' . number_format($dataContent['dataSes']['pajak']) . '</h2>
                                                    </td>
                                                </tr>
                                                <tr class="tabletitle">
                                                    <td></td>
                                                    <td class="Rate">
                                                        <h2>Total</h2>
                                                    </td>
                                                    <td class="payment" style="text-align: right;">
                                                        <h2 style="margin-right: 5px;">' . number_format($dataContent['dataSes']['total_tagihan']) . '</h2>
                                                    </td>
                                                </tr>
                                                <tr class="tabletitle">
                                                    <td></td>
                                                    <td class="Rate">
                                                        <h2>Dibayar</h2>
                                                    </td>
                                                    <td class="payment" style="text-align: right;">
                                                        <h2 style="margin-right: 5px;">' . number_format($dataContent['dataSes']['uang_diterima']) . '</h2>
                                                    </td>
                                                </tr>
                                                <tr class="tabletitle">
                                                    <td></td>
                                                    <td class="Rate">
                                                        <h2>Kembalian</h2>
                                                    </td>
                                                    <td class="payment" style="text-align: right;">
                                                        <h2 style="margin-right: 5px;">' . number_format($dataContent['dataSes']['uang_diterima'] - $dataContent['dataSes']['total_tagihan']) . '</h2>
                                                    </td>
                                                </tr>



                                            </table>
                                        </div>

                                        <div id="legalcopy">
                                            <p class="legal"><strong>Terimakasih sudah berkunjung!</strong> .
                                            </p>
                                        </div>

                                    </div>
                                </div>';
        $options = new Options();
        // $options->set('defaultFont', 'Courier');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('debugKeepTemp', TRUE);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlScript);
        $dompdf->setPaper(array(0, 0, 204, 400));
        $dompdf->render();

        // // Output the generated PDF (1 = download and 0 = preview)
        $dompdf->stream("qrcode.pdf", array("Attachment" => 0));
    }

    public function konfirmasi_bayar()
    {
        try {

            $data = $this->input->post();
            $data['id_penerima'] = $this->session->userdata('login')['id_user'];
            $data['penerima'] = $this->session->userdata('login')['nama'];
            $data['ses_status'] = "1";
            $data['total_tagihan'] = preg_replace("/[^0-9]/", "", $data['total_tagihan']);
            $data['uang_diterima'] = preg_replace("/[^0-9]/", "", $data['uang_diterima']);
            $data['sub_total'] = preg_replace("/[^0-9]/", "", $data['sub_total']);
            $data['pajak'] = preg_replace("/[^0-9]/", "", $data['pajak']);
            $data['waktu_pembayaran'] = date("Y-m-d H:i:s");
            $this->KasirModel->konfirmasiBayar($data);
            echo json_encode(['error' => false, 'data' => $data]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
