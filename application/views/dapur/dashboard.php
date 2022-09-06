<div class="blog-section">
    <div class="container">
        <div class="ibox ssection-container">
            <div class="ibox-content">
                <h2>Dapur</h2>
                <br>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="ibox ssection-container">
            <div class="ibox-content">
                <!-- <form class="form-inline" id="toolbar_form" onsubmit="return false;"> -->
                <div class="col-lg-6 col-sm-12">

                    <div class="form-group row">
                        <label for="c1">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control mr-sm-2" name="c1" id="c1">
                                <option value="">Semua</option>
                                <option value="waiting_dibuat" selected>Waiting list & Sedang dibuat</option>
                                <option value="waiting">Waiting list</option>
                                <option value="selesai">Selesai</option>
                                <option value="dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- </form> -->
            </div>
        </div>
        <div class="table-responsive">
            <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                <thead>
                    <tr>
                        <!-- <th style="width: 7%; text-align:center!important">ID</th> -->
                        <!-- <th style="width: 24%; text-align:center!important">Username</th> -->
                        <th style="width: 22%; text-align:center!important">Waktu</th>
                        <th style="width: 16%; text-align:center!important">Status</th>
                        <th style="width: 16%; text-align:center!important">Meja</th>
                        <th style="width: 16%; text-align:center!important">Nama Pemesan</th>
                        <th style="width: 16%; text-align:center!important">QYT</th>
                        <th style="width: 16%; text-align:center!important">Total</th>
                        <th style="width: 16%; text-align:center!important">Action</th>
                        <!-- <th style="width: 16%; text-align:center!important">Status</th>
                           <th style="width: 5%; text-align:center!important">Action</th> -->
                    </tr>
                </thead>
                <tbody></tbody>
                <!-- <thead>
                    <tr>
                        <th colspan="4">Total</th>
                        <th colspan="1" id="total_harga"></th>
                    </tr>
                </thead> -->
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var total_harga = $('#total_harga');
        var c1 = $('#c1');
        var dataPesanan;

        var FDataTable = $('#FDataTable').DataTable({
            //    '': [],
            deferRender: true,
            // 'order': false,
            //    'order': false,
            autoFill: true,
            // columnDefs: [{
            //     targets: [3, 4],
            //     className: 'dt-body-right'
            // }],
            // "dom": ''
            //    "order": [
            //        [0, "desc"]
            //    ]
        });
        getListPesanan()

        c1.on('change', () => {
            getListPesanan()
        })
        setInterval(function() {
            getListPesanan()
        }, 3000)

        function getListPesanan() {
            return $.ajax({
                url: `<?php echo site_url('Dapur/getListPesanan/') ?>`,
                'type': 'get',
                data: {
                    today: true,
                    'c1': c1.val()
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataPesanan = json['data'];
                    renderPesanan(dataPesanan);
                },
                error: function(e) {}
            });
        }

        function renderPesanan(data) {
            console.log(data)
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            total = 0;
            Object.values(data).forEach((user) => {
                var terima = `
                                <a class="terima dropdown-item" data-id='${user['id_pesanan']}'><i class='fa fa-pencil'></i>Terima</a>
                            `;
                var selesai = `
                                <a class="selesai dropdown-item"  data-id='${user['id_pesanan']}'><i class='fa fa-trash'></i>Selesai</a>
                            `;
                var batalkan = `
                                <a class="batalkan dropdown-item"  data-id='${user['id_pesanan']}'><i class='fa fa-trash'></i>Batalkan</a>
                            `;
                var button = `
                                <div class="btn-group" opd="group">
                                <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont-hand"></i>Action</button>
                                <div class="dropdown-menu" aria-labelledby="action">
                                    ${terima}
                                    ${selesai}
                                    ${batalkan}
                                </div>
                                </div>
                            `;
                renderData.push([user['waktu_pesanan'], statusPesanan(user['status_pesanan']), user['nama_meja'], user['nama_pemesan'], user['nama_pesanan'], user['qyt'], button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
            total_harga.html(convertToRupiah(total));

        }

        FDataTable.on('click', '.terima', function() {
            var currentData = $(this).data('id');
            console.log(currentData)
            // Swal.fire({
            //     title: 'Loading!',
            //     html: 'Harap tunggu  <b></b> beberapa saat.',
            // })
            // Swal.showLoading();
            return $.ajax({
                url: `<?php echo site_url('Dapur/terima/') ?>`,
                'type': 'get',
                data: {
                    'id_pesanan': currentData
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: json['message'],
                        });
                        return;
                    }
                    dataPesanan[json['data']['id_pesanan']] = json['data'];
                    renderPesanan(dataPesanan);
                },
                error: function(e) {}
            });
        });


        FDataTable.on('click', '.selesai', function() {
            var currentData = $(this).data('id');
            console.log(currentData)
            // Swal.fire({
            //     title: 'Loading!',
            //     html: 'Harap tunggu  <b></b> beberapa saat.',
            // })
            // Swal.showLoading();
            return $.ajax({
                url: `<?php echo site_url('Dapur/selesai/') ?>`,
                'type': 'get',
                data: {
                    'id_pesanan': currentData
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: json['message'],
                        });
                        return;
                    }
                    dataPesanan[json['data']['id_pesanan']] = json['data'];
                    renderPesanan(dataPesanan);
                },
                error: function(e) {}
            });
        });


        FDataTable.on('click', '.batalkan', function() {
            var currentData = $(this).data('id');
            console.log(currentData)
            // Swal.fire({
            //     title: 'Loading!',
            //     html: 'Harap tunggu  <b></b> beberapa saat.',
            // })
            // Swal.showLoading();
            return $.ajax({
                url: `<?php echo site_url('Dapur/batalkan/') ?>`,
                'type': 'get',
                data: {
                    'id_pesanan': currentData
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            html: json['message'],
                        })
                        return;

                    }
                    dataPesanan[json['data']['id_pesanan']] = json['data'];
                    renderPesanan(dataPesanan);
                },
                error: function(e) {}
            });
        });
    })
</script>