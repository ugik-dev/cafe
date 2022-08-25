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
                           <th colspan="1" id="total_harga"></th>
                       </tr>
                   </thead>
               </table>
           </div>
       </div>
       <script>
           $(document).ready(function() {
               var total_harga = $('#total_harga');
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
                   total_harga.html(convertToRupiah(total));

               }
           })
       </script>