   <div class="hero-section">
       <div class="bubble">
           <img src="<?= base_url('assets') ?>/img/bubble.png" alt="bubble-images " class="w-100 img-fluid" />
       </div>
       <div class="container">
           <div class="row">
               <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="hero-sec-content">
                       <h1>Menu <?= $dataContent['dataSes']['nama_meja'] ?></h1>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="service-section">
       <div class="container">
           <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                   <div id="select-all-kategori" class="image-box clearfix d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/honney.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2>Semua</h2>
                       </div>
                   </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                   <div id="select-junk-food" class="image-box clearfix d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/honney.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2>Junk Food</h2>
                       </div>
                   </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                   <div id="select-menu-utama" class="image-box clearfix d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/macaron.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2>Menu Utama</h2>
                       </div>
                   </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                   <div id="select-minuman" class="image-box clearfix d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/dinner.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2 class="">Minuman</h2>
                       </div>
                   </div>
               </div>
               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
                   <div id="select-beer" class="image-box clearfix d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/dinner.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2 class="">Beer</h2>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="blog-section">
       <div class="container">
           <form opd="form" id="menu_form" onsubmit="return false;" type="multipart" autocomplete="off">
               <input type="hidden" name="id_ses" value="<?= $dataContent['dataSes']['id_ses'] ?>">
               <div class="row" id="row_menu">
                   <!-- tesst -->
                   <!-- <div class="food-informaion">
                       <div class="row align-items-center">
                           <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                               <div class="food-info text-left">
                                   <h2>Vegetable Roll</h2>
                                   <h3><span>Rp </span>18.00</h3>
                                   <div class="input-group">
                                       <input type="number" min="0" class="form-control" id="menu_224" name="menu_224" placeholder="0" value="0" aria-label="Recipient's username with two button addons">
                                       <button class="btn btn-outline-secondary min" type="button" data-id="224">-</button>
                                       <a class="btn btn-outline-secondary plus" data-id='224'>+</a>
                                   </div>
                               </div>
                           </div>
                           <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                               <img src="http://localhost:85/apri_cafe/uploads/menu/56079065420e5a37d9dc8a9c50876b73.jpg" style="height : 100px !important;width : 150px !important ; border-radius: 2%" class="img-fluid" alt="">
                           </div>
                       </div>
                   </div> -->
                   <!-- end test -->
               </div>
               <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Selesai</strong></button>

           </form>
       </div>
   </div>

   <script>
       $(document).ready(function() {
           $.when(getAllMenu()).then((e) => {
               Swal.close();
           }).fail((e) => {
               console.log(e)
           });
           var swalSaveConfigure = {
               title: "Konfirmasi",
               text: "Yakin akan melakukan pesanan ini?",
               type: "info",
               showCancelButton: true,
               confirmButtonColor: "#18a689",
               confirmButtonText: "Ya, Pesan!",
           };

           layout = $('#row_menu');
           s_menu_utama = $('#select-menu-utama');
           s_all = $('#select-all-kategori');
           s_junk_food = $('#select-junk-food');
           s_minuman = $('#select-minuman');
           s_beer = $('#select-beer');
           s_all.on('click', function() {
               $('.junk-food').show();
               $('.minuman').show();
               $('.menu-utama').show();
               $('.beer').show();
           });

           s_menu_utama.on('click', function() {
               $('.junk-food').hide();
               $('.minuman').hide();
               $('.menu-utama').show();
               $('.beer').hide();
           });
           s_minuman.on('click', function() {
               $('.junk-food').hide();
               $('.minuman').show();
               $('.beer').hide();
               $('.menu-utama').hide();
           });
           s_junk_food.on('click', function() {
               $('.junk-food').show();
               $('.minuman').hide();
               $('.beer').hide();
               $('.menu-utama').hide();
           });
           s_beer.on('click', function() {
               $('.junk-food').hide();
               $('.minuman').hide();
               $('.beer').show();
               $('.menu-utama').hide();
           });
           menu_form = $('#menu_form');
           menu_form.submit(function(event) {
               event.preventDefault();
               //    var isAdd = UserModal.addBtn.is(':visible');
               var url = "<?= site_url('Home/order_process_two') ?>";


               Swal.fire(swalSaveConfigure).then((result) => {
                   if (!result.value) {
                       return;
                   }
                   //    Swal.fire({
                   //        title: 'Loading!',
                   //        html: 'Harap tunggu  <b></b> beberapa saat.',
                   //        allowOutsideClick: false
                   //    })
                   //    Swal.showLoading();
                   $.ajax({
                       url: url,
                       'type': 'POST',
                       data: menu_form.serialize(),
                       success: function(data) {
                           // buttonIdle(button);
                           var json = JSON.parse(data);
                           if (json['error']) {
                               swal("Simpan Gagal", json['message'], "error");
                               return;
                           }

                           Swal.fire({
                               title: 'Berhasil!',
                               html: 'Pesanan berhasil diorder.',
                               icon: 'success',
                           })
                           location.href = '<?= base_url('cart') ?>';
                           //    renderUser(dataUser);
                           //    UserModal.self.modal('hide');
                       },
                       error: function(e) {}
                   });
               });
           });


           function getAllMenu() {
               return $.ajax({
                   url: `<?php echo site_url('General/getAllMenu/') ?>`,
                   'type': 'post',
                   success: function(data) {
                       var json = JSON.parse(data);
                       if (json['error']) {
                           return;
                       }
                       dataUser = json['data'];
                       renderMenu(dataUser);
                       console.log(dataUser);
                   },
                   error: function(e) {}
               });
           }

           function render(d) {
               html = `
                      <div class="col-sm-12 col-md-6 col-lg-4">
                       <div class="blog mb-4">
                           <div class="blog-img">
                               <img src="<?= base_url('uploads/menu/') ?>${d['gambar']}" style="height : 215px !important;width : 370px !important ; border-radius: 2%" class="img-fluid" alt="" />
                           </div>
                           <div class="blog-content">
                               <div class="date">
                                   <a  class="publish-btn">Rp ${d['harga']},-</a>
                               </div>
                               <h2>
                                       ${d['nama_menu']}
                               </h2>
                               <div class="input-group">
                                   <input type="number" min="0" class="form-control" id="menu_${d['id_menu']}"  name="menu_${d['id_menu']}" placeholder="0" value="0" aria-label="Recipient's username with two button addons">
                                   <button class="btn btn-outline-secondary min" type="button" data-id="${d['id_menu']}">-</button>
                                   <a class="btn btn-outline-secondary plus" data-id='${d['id_menu']}'>+</a>
                               </div>
                           </div>
                       </div>
                     </div>`;

               html2 = ` 
               <div class="${d['nama_kategori'].replace(/\s+/g, '-').toLowerCase()}  food-menu text-center mr-1 ml-1">
                        <div class="row align-items-center">
                           <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                               <div class="food-info text-left">
                                   <h4> ${d['nama_menu']}</h4>
                                   <h3><span>Rp </span>${ convertToRupiah(d['harga'])}</h3>
                                   <div class="input-group">
                                       <input type="number" min="0" class="form-control" id="menu_${d['id_menu']}" name="menu_${d['id_menu']}" placeholder="0" value="0" aria-label="Recipient's username with two button addons">
                                       <button class="btn btn-outline-secondary min" type="button" data-id="${d['id_menu']}">-</button>
                                       <a class="btn btn-outline-secondary plus" data-id='${d['id_menu']}'>+</a>
                                   </div>
                               </div>
                           </div>
                           <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                <img src="<?= base_url('uploads/menu/') ?>${d['gambar']}" style="height : 100px !important;width : 150px !important ; border-radius: 12%" class="img-fluid" alt="">
                           </div>
                       </div>
                   </div>`
               layout.append(html2);
           }

           function renderMenu(data) {
               Object.values(data).forEach((d) => {
                   //    if (d['nama_menu'].toLowerCase().match(/^.*go.*/)) {
                   render(d)
                   //    }

               });



               $('.plus').on('click', function() {
                   var currentData = $(this).data('id');
                   $('#menu_' + currentData).val(parseInt($('#menu_' + currentData).val()) + 1);
                   console.log(currentData);
               })
               $('.min').on('click', function() {
                   var currentData = $(this).data('id');
                   $('#menu_' + currentData).val(parseInt($('#menu_' + currentData).val()) - 1);
                   if (parseInt($('#menu_' + currentData).val()) < 0) {
                       $('#menu_' + currentData).val(0);
                   }
                   //    console.log(currentData);
               })
           }
       })
   </script>