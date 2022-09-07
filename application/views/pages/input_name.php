 <div class="home-main-section">
     <div class="bubble">
         <img src="<?= base_url('assets') ?>/img/bubble.png" alt="bubble-images " class="w-100 img-fluid" />
     </div>
 </div>

 <div class="home-input-name-section">
     <div class="container">
         <div class="home-services">


             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                 <div class="image-box clearfix">
                     <div class="box-image float-left">
                         <img src="<?= base_url('assets') ?>/img/macaron.png" alt="" />
                     </div>
                     <div class="image-text float-left" style="width: 80% ">
                         <!-- <h2>Meja Nomor</h2> -->
                         <!-- <p> -->
                         <form action="<?= base_url('order') ?>" method="post">
                             <div class="mb-1">
                                 <label for="" class="form-label">
                                     <h4> Nama Pemesan </h4>
                                 </label>
                                 <input required type="text" placeholder="Masukkan nama anda" class="form-control" id="nama_pemesan" name="nama_pemesan" aria-describedby="">
                                 <input required type="hidden" class="form-control" id="token" name="token" value="<?= $dataContent['dataSes']['token'] ?>">
                             </div>
                             <div class="mb-1">
                                 <label for="exampleInputEmail1" class="form-label">
                                     <h4> Meja </h4>
                                 </label>
                                 <select required style="width:100% " class=" form-control " placeholder="Pilih Meja" id="id_meja" name="id_meja">
                                     <option value=""></option>
                                     <?php foreach ($dataContent['dataMeja'] as $m) {
                                            echo "<option value='" . $m['id_meja'] . "'>" . $m['nama_meja'] . "</option>";
                                        } ?>
                                 </select>
                             </div>
                             <!-- <button type="submit" class="btn submit-btn">Mulai Pemesanan</button> -->
                             <button type="submit" class="btn c1-submit-btn" value="Submit">Mulai Pemesanan</button>
                             <!-- <a href="<?= base_url('home/pilih_menu') ?>" class="btn c1-submit-btn">Mulai Pemesanan</a> -->
                         </form>
                         <!-- </p> -->
                     </div>
                 </div>
             </div>
             <!-- </div> -->
         </div>
     </div>
 </div>