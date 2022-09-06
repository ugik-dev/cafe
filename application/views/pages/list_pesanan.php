   <div class="hero-section">
       <div class="bubble">
           <img src="<?= base_url('assets') ?>/img/bubble.png" alt="bubble-images " class="w-100 img-fluid" />
       </div>
       <div class="container">
           <div class="row">
               <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="hero-sec-content">
                       <h1>Daftar Pesanan <?= $dataContent['dataSes']['nama_meja'] ?></h1>
                   </div>
               </div>
           </div>
       </div>
   </div>

   <div class="blog-section">
       <div class="container">
           <div class="table-responsive">
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
               </div> <a type="submit" class="btn submit-btn" href="<?= base_url('order') ?>"><i class="icofont-plus "></i> Tambah Pesanan</a>
               <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                   <thead>
                       <tr>
                           <!-- <th style="width: 7%; text-align:center!important">ID</th> -->
                           <!-- <th style="width: 24%; text-align:center!important">Username</th> -->
                           <th style="width: 24%; text-align:center!important">Menu</th>
                           <th style="width: 16%; text-align:center!important">Status</th>
                           <th style="width: 16%; text-align:center!important">Jumlah</th>
                           <th style="width: 16%; text-align:center!important">Harga</th>
                           <th style="width: 16%; text-align:center!important">Jumlah</th>
                           <!-- <th style="width: 16%; text-align:center!important">Status</th>
                           <th style="width: 5%; text-align:center!important">Action</th> -->
                       </tr>
                   </thead>
                   <tbody></tbody>
                   <thead>
                       <tr>
                           <th colspan="4" style=" text-align:right">Sub Total</th>
                           <th colspan="1" id="sub_total"></th>
                       </tr>
                       <tr>
                           <th colspan="4" style=" text-align:right">Pajak 10%</th>
                           <th colspan="1" id="pajak"></th>
                       </tr>
                       <tr>
                           <th colspan="4" style=" text-align:right">Total</th>
                           <th colspan="1" id="total_harga"></th>
                       </tr>
                   </thead>
               </table>
           </div>
       </div>
       <script>
           $(document).ready(function() {
               var total_harga = $('#total_harga');
               var sub_total = $('#sub_total');
               var pajak = $('#pajak');

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
                   //    "order": [
                   //        [0, "desc"]
                   //    ]
               });
               getListPesanan()

               function getListPesanan() {
                   return $.ajax({
                       url: `<?php echo site_url('Home/getListPesanan/') ?>`,
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
                       total = (user['harga_pesanan'] * user['qyt']) + total;
                       renderData.push([user['nama_pesanan'], statusPesanan(user['status_pesanan']), user['qyt'], convertToRupiah(user['harga_pesanan']), convertToRupiah(user['harga_pesanan'] * user['qyt'])]);
                   });
                   FDataTable.clear().rows.add(renderData).draw('full-hold');
                   sub_total.html(convertToRupiah(total));
                   pjk = 0.1 * total;
                   pajak.html(convertToRupiah(pjk));
                   total_harga.html(convertToRupiah(total + pjk));

               }
           })
       </script>