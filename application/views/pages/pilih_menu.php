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
               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                   <div class="image-box clearfix border-right-dashed d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/honney.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2>Junk Food</h2>
                           <!-- <p>
                               It is a long establed fact will distracted readable looking at
                               layou.
                           </p> -->
                       </div>
                   </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                   <div class="image-box clearfix border-right-dashed d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/macaron.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2>Menu Utama</h2>
                       </div>
                   </div>
               </div>

               <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                   <div class="image-box clearfix d-flex align-items-center">
                       <div class="box-image float-left">
                           <img src="<?= base_url('assets') ?>/img/dinner.png" alt="" />
                       </div>
                       <div class="image-text float-left">
                           <h2 class="">Minuman</h2>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="blog-section">
       <div class="container">
           <form opd="form" id="menu_form" onsubmit="return false;" type="multipart" autocomplete="off">
               <input name="id_ses" value="<?= $dataContent['dataSes']['id_ses'] ?>">
               <div class="row" id="row_menu">
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
               layout.append(html);
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