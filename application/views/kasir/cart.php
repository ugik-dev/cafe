 <div class="blog-section">
     <div class="container">
         <div class="row">

             <div class="col-lg-6">
                 <div class="row">
                     <div class="col-lg-5">
                         <h4 class="mb-1">
                             Meja
                         </h4>
                     </div>
                     <div class="col">:</div>
                     <div class="col-lg-6"><?= $dataContent['dataSes']['nama_meja'] ?></div>
                 </div>
             </div>
             <div class="col-lg-6">
                 <div class="row">
                     <div class="col-lg-5">
                         <h4 class="mb-1">
                             Nama Pemesan
                         </h4>
                     </div>
                     <div class="col">:</div>
                     <div class="col-lg-6"><?= $dataContent['dataSes']['nama_pemesan'] ?></div>
                 </div>
             </div>


             <div class="col-lg-6">
                 <div class="row">
                     <div class="col-lg-5">
                         <h4 class="mb-1">
                             Status Pembayaran
                         </h4>
                     </div>
                     <div class="col">:</div>
                     <div class="col-lg-6"><b><?= statusSession($dataContent['dataSes']['ses_status']) ?></b></div>
                 </div>
             </div>
             <div class="col-lg-6">
                 <div class="row">
                     <div class="col-lg-5">
                         <h4 class="mb-1">
                             Waktu Pemesanan
                         </h4>
                     </div>
                     <div class="col">:</div>
                     <div class="col-lg-6"><?= $dataContent['dataSes']['waktu'] ?></div>
                 </div>
             </div>
             <div class="col-lg-6">
                 <div class="row">
                     <div class="col-lg-5">
                         <h4 class="mb-1">
                             Device
                         </h4>
                     </div>
                     <div class="col">:</div>
                     <div class="col-lg-6"><?= $dataContent['dataSes']['mobile_type'] . '<br>' . $dataContent['dataSes']['ip_address'] ?></div>
                 </div>
             </div>
             <?php if ($dataContent['dataSes']['ses_status'] == 1) { ?>
                 <div class="col-lg-6">
                     <div class="row">
                         <div class="col-lg-5">
                             <h4 class="mb-1">
                                 Waktu Pembayaran
                             </h4>
                         </div>
                         <div class="col">:</div>
                         <div class="col-lg-6"><?= $dataContent['dataSes']['waktu_pembayaran'] ?></div>
                     </div>
                 </div>
                 <div class="col-lg-6">
                     <div class="row">
                         <div class="col-lg-5">
                             <h4 class="mb-1">
                                 Kasir
                             </h4>
                         </div>
                         <div class="col">:</div>
                         <div class="col-lg-6"><?= $dataContent['dataSes']['penerima'] ?></div>
                     </div>
                 </div>
             <?php } ?>
         </div>
         <button type="button" class="btn submit-btn" id="btn_bayar">Terima Tembayaran</button>
         <br>
         <div class="table-responsive">
             <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                 <thead>
                     <tr>
                         <!-- <th style="width: 7%; text-align:center!important">ID</th> -->
                         <!-- <th style="width: 24%; text-align:center!important">Username</th> -->
                         <th style="width: 24%; text-align:center!important">Menu</th>
                         <th style="width: 16%; text-align:center!important">Status</th>
                         <th style="width: 16%; text-align:center!important">Jumlah</th>
                         <th style="width: 16%; text-align:center!important">Harga</th>
                         <th style="width: 16%; text-align:center!important">Total</th>
                         <!-- <th style="width: 16%; text-align:center!important">Status</th>
                           <th style="width: 5%; text-align:center!important">Action</th> -->
                     </tr>
                 </thead>
                 <tbody></tbody>
                 <thead>
                     <tr>
                         <th colspan="4">Total</th>
                         <th colspan="1" style="text-align: right" id="total_harga"></th>
                     </tr>
                     <?php if ($dataContent['dataSes']['ses_status'] == 1) { ?>
                         <tr>
                             <th colspan="4"> Dibayar</th>
                             <th style="text-align: right"><?= number_format($dataContent['dataSes']['uang_diterima']) ?></th>
                         </tr>
                         <tr>
                             <th colspan="4">Kembalian</th>
                             <th style="text-align: right"><?= number_format($dataContent['dataSes']['uang_diterima'] - $dataContent['dataSes']['total_tagihan']) ?></th>
                         </tr>
                     <?php } ?>
                 </thead>
             </table>
         </div>
     </div>
 </div>

 <div style="background-color: rgba(0, 0, 0, 0.65);" class="modal inmodal " id="pembayaran_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg  modal-dialog-centered">
         <div class="modal-content animated fadeIn">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                 <!-- <h4 class="modal-title">Kelola Meja</h4> -->
                 <span class="info"></span>
             </div>
             <div class="modal-body" id="modal-body">
                 <form opd="form" id="pembayaran_form" onsubmit="return false;" type="multipart" autocomplete="off">
                     <input type="hidden" id="id_ses" name="id_ses" value="<?= $dataContent['dataSes']['id_ses'] ?>">
                     <div class="form-group">
                         <label for="total_tagihan">Jumlah Tagihan</label>
                         <input type="" readonly style="background-color: white;" placeholder="" class="form-control" id="total_tagihan" name="total_tagihan" required="required">
                     </div>
                     <div class="form-group">
                         <label for="code">Uang Diterima</label>
                         <input type="text" class="form-control" id="uang_diterima" name="uang_diterima">
                     </div>
                     <div class="form-group">
                         <label for="code">Kembalian</label>
                         <input type="text" readonly style="background-color: white;" class="form-control" id="kembalian" name="kembalian">
                     </div>
                     <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Selesai & Cetak</strong></button>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>

 <script>
     $(document).ready(function() {
         var total_harga = $('#total_harga');
         var total = 0;
         var btn_bayar = $('#btn_bayar');
         var PembayaranModal = {
             'self': $('#pembayaran_modal'),
             'info': $('#pembayaran_modal').find('.info'),
             'form': $('#pembayaran_modal').find('#pembayaran_form'),
             'addBtn': $('#pembayaran_modal').find('#add_btn'),
             'idMeja': $('#pembayaran_modal').find('#id_ses'),
             'uang_diterima': $('#pembayaran_modal').find('#uang_diterima'),
             'total_tagihan': $('#pembayaran_modal').find('#total_tagihan'),
             'kembalian': $('#pembayaran_modal').find('#kembalian'),
             //    'status': $('#pembayaran_modal').find('#status'),
         }

         var FDataTable = $('#FDataTable').DataTable({
             //    '': [],
             deferRender: true,
             'order': false,
             //    'order': false,
             autoFill: true,
             columnDefs: [{
                 targets: [3, 4],
                 className: 'dt-body-right'
             }],
             "dom": ''
         });
         getListPesanan()

         function getListPesanan() {
             return $.ajax({
                 url: `<?php echo site_url('Kasir/getListPesanan/') ?>`,
                 'type': 'get',
                 data: {
                     'id_ses': '<?= $dataContent['dataSes']['id_ses'] ?>'
                 },
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
             Object.values(data['children']).forEach((user) => {
                 //    var editButton = `
                 //                 <a class="edit dropdown-item" data-id='${user['id_menu']}'><i class='fa fa-pencil'></i> Edit User</a>
                 //             `;
                 //    var deleteButton = `
                 //                 <a class="delete dropdown-item" data-id='${user['id_menu']}'><i class='fa fa-trash'></i> Hapus User</a>
                 //             `;
                 //    var button = `
                 //                 <div class="btn-group" opd="group">
                 //                 <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-bars'></i></button>
                 //                 <div class="dropdown-menu" aria-labelledby="action">
                 //                     ${editButton}
                 //                     ${deleteButton}
                 //                 </div>
                 //                 </div>
                 //             `;
                 if (user['status_pesanan'] != 3)
                     total = (user['harga_pesanan'] * user['qyt']) + total;
                 renderData.push([user['nama_pesanan'], statusPesanan(user['status_pesanan']), user['qyt'], convertToRupiahStatus(user['harga_pesanan'], user['status_pesanan']), convertToRupiahStatus(user['harga_pesanan'] * user['qyt'], user['status_pesanan'])]);
             });
             FDataTable.clear().rows.add(renderData).draw('full-hold');
             total_harga.html(convertToRupiah(total));

         }

         btn_bayar.on('click', function() {
             console.log('bayar')
             PembayaranModal.self.show();
             PembayaranModal.total_tagihan.val(convertToRupiah(total));
         });

         PembayaranModal.form.on('submit', function() {
             event.preventDefault();
             var url = "<?= site_url('Kasir/konfirmasi_bayar') ?>";

             $.ajax({
                 url: url,
                 'type': 'POST',
                 data: PembayaranModal.form.serialize(),

                 success: function(data) {
                     // buttonIdle(button);
                     var json = JSON.parse(data);
                     if (json['error']) {
                         swal("Pembayaran Gagal", json['message'], "error");
                         return;
                     }
                     var user = json['data']
                     dataUser[user['id_menu']] = user;
                     Swal.fire({
                         title: 'Berhasil!',
                         html: 'Data Pembayaran Berhasil.',
                         icon: 'success',
                     })
                     //  renderUser(dataUser);
                     //  UserModal.self.modal('hide');
                 },
                 error: function(e) {}
             });
             //  });
         })
         PembayaranModal.uang_diterima.on('keyup', function() {
             console.log('ss');
             tmp_kembalian = total - PembayaranModal.uang_diterima.val();
             console.log(tmp_kembalian)
             if (tmp_kembalian < 0) {
                 PembayaranModal.kembalian.val(convertToRupiah(Math.abs(total - PembayaranModal.uang_diterima.val())));
             } else {
                 PembayaranModal.kembalian.val(0);
             }
         })
     })
 </script>