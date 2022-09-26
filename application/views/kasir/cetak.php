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
        /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
    }

    #top {
        min-height: 100px;
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
        background: url(<?= base_url('assets/img/logo-black-white.png') ?>) no-repeat;
        background-size: 60px 60px;
    }

    .clientlogo {
        float: left;
        height: 60px;
        width: 60px;
        background: (<?= base_url('assets/img/logo-black-white.png') ?>) no-repeat;
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
        <img style=" height: 60px; width: 60px;" src="<?= base_url('assets/img/logo-black-white.png') ?>" alt="">
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
                <?php
                $total = 0;
                foreach ($dataContent['dataSes']['children'] as $d) {
                    if ($d['status_pesanan'] != '3') {
                        $total = ($d['qyt'] * $d['harga_pesanan']) + $total
                ?>
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext"><?= $d['nama_pesanan'] ?></p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext"><?= $d['qyt'] ?></p>
                            </td>
                            <td class="tableitem" style="text-align: right;">
                                <p class="itemtext" style="margin-right: 5px;"> <?= number_format($d['qyt'] * $d['harga_pesanan']) ?></p>
                            </td>
                        </tr>
                    <?php } else {
                    ?>
                        <tr class="service">
                            <td class="tableitem">
                                <del style="text-decoration-style: double;">
                                    <p class="itemtext"><?= $d['nama_pesanan'] ?></p>
                                </del>
                            </td>
                            <td class="tableitem">
                                <del style="text-decoration-style: double;">
                                    <p class="itemtext"><?= $d['qyt'] ?></p>
                                </del>
                            </td>
                            <td class="tableitem" style="text-align: right;">
                                <del style="text-decoration-style: double;">
                                    <p class="itemtext" style="margin-right: 5px;"><?= number_format($d['qyt'] * $d['harga_pesanan']) ?></p>
                                </del>
                            </td>
                        </tr>
                <?php
                    }
                } ?>

                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate">
                        <h2>Sub Total</h2>
                    </td>
                    <td class="payment" style="text-align: right;">
                        <h2 style="margin-right: 5px;"><?= number_format($dataContent['dataSes']['sub_total']) ?></h2>
                    </td>
                </tr>
                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate">
                        <h2>Pajak 10%</h2>
                    </td>
                    <td class="payment" style="text-align: right;">
                        <h2 style="margin-right: 5px;"><?= number_format($dataContent['dataSes']['pajak']) ?></h2>
                    </td>
                </tr>
                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate">
                        <h2>Total</h2>
                    </td>
                    <td class="payment" style="text-align: right;">
                        <h2 style="margin-right: 5px;"><?= number_format($dataContent['dataSes']['total_tagihan']) ?></h2>
                    </td>
                </tr>
                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate">
                        <h2>Dibayar</h2>
                    </td>
                    <td class="payment" style="text-align: right;">
                        <h2 style="margin-right: 5px;"><?= number_format($dataContent['dataSes']['uang_diterima']) ?></h2>
                    </td>
                </tr>
                <tr class="tabletitle">
                    <td></td>
                    <td class="Rate">
                        <h2>Kembalian</h2>
                    </td>
                    <td class="payment" style="text-align: right;">
                        <h2 style="margin-right: 5px;"><?= number_format($dataContent['dataSes']['uang_diterima'] - $dataContent['dataSes']['total_tagihan']) ?></h2>
                    </td>
                </tr>



            </table>
        </div>

        <div id="legalcopy">
            <p class="legal"><strong>Terimakasih sudah berkunjung!</strong> .
            </p>
        </div>

    </div>
</div>
<!--End Invoice-->

<script type="text/javascript">
    setTimeout(function() {
        window.print();
    }, 500);
    window.onfocus = function() {
        setTimeout(function() {
            window.close();
        }, 10);
    }
</script>