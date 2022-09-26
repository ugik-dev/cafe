<div class="blog-section">
    <div class="container">
        <h2 class="mb-2 pb-2">Kasir</h2>
        <form class="form-inline mb-2" id="toolbar_form" onsubmit="return false;">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <button type="button" class="btn submit-btn mt-1 mb-1" id="add_barcode"><i class="icofont-plus "></i> Barcode Baru</button>
                    </div>
                    <div class="col-lg-4">
                        <div class=" row">
                            <label for="date_end" class=" col-form-label">Tanggal</label>
                            <div class="col-lg-6">
                                <input type="date" class="form-control" id="date" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class=" row">
                            <label for="date_end" class=" col-form-label">Status</label>
                            <div class="col-lg-6">
                                <select class="form-control" id="status">
                                    <option>Semua</option>
                                    <option value="0">Belum Bayar</option>
                                    <option value="1">Sudah Bayar</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
        <div class="table-responsive">
            <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                <thead>
                    <tr>
                        <th style="width: 24%; text-align:center!important">Waktu</th>
                        <th style="width: 16%; text-align:center!important">Status</th>
                        <th style="width: 16%; text-align:center!important">Meja</th>
                        <th style="width: 16%; text-align:center!important">Nama Pemesan</th>
                        <th style="width: 16%; text-align:center!important">QYT</th>
                        <th style="width: 16%; text-align:center!important">Total</th>
                        <th style="width: 16%; text-align:center!important">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <thead>
                    <tr>
                        <th colspan="4">Total</th>
                        <th colspan="1" id="total_harga"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var total_harga = $('#total_harga');
        var add_barcode = $('#add_barcode');
        var dataPesanan = [];
        var FDataTable = $('#FDataTable').DataTable({
            caption: 's', //    '': [],
            deferRender: true,
            // 'order': false,
            //    'order': false,
            autoFill: true,
            columnDefs: [{
                targets: [3, 4],
                className: 'dt-body-right'
            }],
        });
        var toolbar = {
            'form': $('#toolbar_form'),
            'date': $('#toolbar_form').find('#date'),
            'status': $('#toolbar_form').find('#status'),
        }
        toolbar.date.on('change', () => {
            getListPesanan()
        });
        toolbar.status.on('change', () => {
            getListPesanan()
        });

        getListPesanan()

        function getListPesanan() {
            return $.ajax({
                url: `<?php echo site_url('Kasir/getListPesanan/') ?>`,
                'type': 'get',
                data: {
                    'date': toolbar.date.val(),
                    'status': toolbar.status.val()
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
        var swalSaveConfigure = {
            title: "Buat Barcode ",
            text: "Yakin akan membuat barcode?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya!",
        };

        add_barcode.on('click', function() {
            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    console.log('cancel')
                    return;
                }
                console.log('go')
                return $.ajax({
                    url: `<?php echo base_url('Kasir/add_barcode/') ?>`,
                    'type': 'get',
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json['error']) {
                            return;
                        }
                        curData = json['data'];
                        dataPesanan[curData['id_ses']] = curData;
                        renderPesanan(dataPesanan);
                        var anchor = document.createElement('a');
                        anchor.href = '<?= base_url('kasir/qrcode/') ?>' + curData['id_ses'];
                        anchor.target = "_blank";
                        anchor.click();
                    },
                    error: function(e) {}
                });
            })
        })

        function renderPesanan(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            total = 0;
            Object.values(data).forEach((user) => {
                var konfirmasiPembayaran = `
                                <a class="konfirmasi-bayar dropdown-item" data-id='${user['id_ses']}'><i class='fa fa-pencil'></i>Konfirmasi Bayar</a>
                            `;
                var openDetail = `
                                <a class="btn btn-success" href='<?= base_url('kasir/cart/') ?>${user['id_ses']}' title="Open"><i class="icofont-ui-note mr-1"></i>Open</a>
                            `;
                var cetakQR = `
                                <a target="_blank" class="btn btn-info" href='<?= base_url('kasir/qrcode/') ?>${user['id_ses']}' title="Cetak QR Code"><i class="icofont-qr-code"></i></a>
                               <a target="_blank" class="btn btn-info" href='<?= base_url('kasir/qrcode_pdf/') ?>${user['id_ses']}' title="Cetak QR Code"><i class="icofont-file-pdf"></i></a>
                            `;
                var pesanManual = `
                                <a target="_blank" class="btn btn-info" href='<?= base_url('order/') ?>${user['token']}' title="Pesan Manual by Kasir"><i class="icofont-restaurant"></i></a>
                            `;
                var button = `
                                <div class="btn-group" opd="group">
                                <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-bars'></i></button>
                                <div class="dropdown-menu" aria-labelledby="action">
                                    ${konfirmasiPembayaran}
                                    ${openDetail}
                                </div>
                                </div>
                            `;

                renderData.push([user['waktu'], statusPembayaran(user['ses_status']), user['nama_meja'], user['nama_pemesan'], user['total_qyt'], convertToRupiah(user['total_harga']), openDetail + cetakQR + pesanManual]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
            total_harga.html(convertToRupiah(total));

        }
    })
</script>