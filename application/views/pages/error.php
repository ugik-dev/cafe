   <div class="home-main-section">
       <div class="bubble">
           <img src="<?= base_url('assets') ?>/img/bubble.png" alt="bubble-images " class="w-100 img-fluid" />
       </div>
   </div>
   <div class="error-section">
       <div class="container">
           <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                   <div class="error text-center">
                       <div class="error-img">
                           <img src="<?= base_url('assets') ?>/img/404_Error.png" class="w-100 img-fluid" alt="" />
                       </div>
                       <div class="error-content">
                           <h3><span>Sorry, </span><br>
                               <?php if (empty($dataContent['message'])) {
                                    echo "halaman ini tidak ditemukan.";
                                } else {
                                    echo $dataContent['message'];
                                } ?>

                           </h3>
                           <!-- <p>
                               There are many variations of passages of Lorem Ipsum available
                               but majority have suffered alteration injected humour
                           </p> -->
                           <?php if (empty($dataContent['button'])) { ?>
                               <a href="<?= base_url() ?>" class="book-now text-center"><i class="icofont-double-left"></i>Book To Home</a>
                           <?php } else {
                                echo $dataContent['button'];
                            } ?>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>