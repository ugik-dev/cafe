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
    <div>
        <center>
            <h6 style="margin: 2;"> Untuk pemesanan silahkan scan barcode dibawah </h6>
            <img style=" height: 120px; width: 120px;" src="<?= base_url('uploads/qrcode/') . str_replace('-', '', (explode(' ', $dataContent['waktu'])[0])) . '-' . $dataContent['token'] . '.png' ?>" alt="">
        </center>
    </div>
    <div>
        <center>
            <h6 style="margin: 2;"> Atau masuk kealamat berikut : </h6>
            <h5 style="margin: 2;"><?= base_url('') . '<br>order/' . $dataContent['token']  ?></h5>
            <!--End Info-->
        </center>
    </div>
</div>
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