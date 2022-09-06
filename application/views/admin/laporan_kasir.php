<div class="blog-section">
    <div class="container">
        <h2>Kasir</h2>
        <div class="table-responsive">
            <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                <thead>
                    <tr>
                        <!-- <th style="width: 7%; text-align:center!important">ID</th> -->
                        <!-- <th style="width: 24%; text-align:center!important">Username</th> -->
                        <th style="width: 24%; text-align:center!important">Waktu</th>
                        <th style="width: 16%; text-align:center!important">Status</th>
                        <th style="width: 16%; text-align:center!important">Meja</th>
                        <th style="width: 16%; text-align:center!important">Nama Pemesan</th>
                        <th style="width: 16%; text-align:center!important">Nama Kasir</th>
                        <th style="width: 16%; text-align:center!important">Total</th>
                        <th style="width: 16%; text-align:center!important">Action</th>
                        <!-- <th style="width: 16%; text-align:center!important">Status</th>
                           <th style="width: 5%; text-align:center!important">Action</th> -->
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var total_harga = $('#total_harga');
        var FDataTable = $('#FDataTable').DataTable({
            dom: 'Bfrtip',
            deferRender: true,
            autoFill: true,
            columnDefs: [{
                targets: [3, 4],
                className: 'dt-body-right'
            }],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
            // "dom": ''
            //    "order": [
            //        [0, "desc"]
            //    ]
        });
        getListPesanan()

        function getListPesanan() {
            return $.ajax({
                url: `<?php echo site_url('Kasir/getListPesanan/') ?>`,
                'type': 'POST',
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    data = json['data'];
                    renderPesanan(data);
                },
                error: function(e) {}
            });
        }

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
                                <a class="btn btn-success" href='<?= base_url('admin/cart/') ?>${user['id_ses']}'><i class='fa fa-trash'></i>Open</a>
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
                renderData.push([user['waktu'], statusPembayaran(user['ses_status']), user['nama_meja'], user['nama_pemesan'], user['penerima'], convertToRupiah(user['total_harga']), openDetail]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
            total_harga.html(convertToRupiah(total));

        }
    })
</script>