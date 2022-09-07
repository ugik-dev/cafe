   <div class="hero-section">
       <div class="bubble">
           <img src="<?= base_url('assets') ?>/img/bubble.png" alt="bubble-images " class="w-100 img-fluid" />
       </div>
       <div class="container">
           <div class="row">
               <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="hero-sec-content">
                       <h1>Menu</h1>
                       <!-- <ul>
                           <li>
                               <a href="index.html">Home</a><i class="icofont-double-right"></i>
                           </li>
                           <li>
                               <a href="blog.html"><span>Blog</span></a>
                           </li>
                       </ul> -->
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- HERO SECTION END -->

   <div class="blog-section">
       <div class="container">
           <!-- <div class="row"> -->
           <div class="col-lg-6">

               <form id="loginForm" class="m-t" role="form">
                   <!-- <h3>Masuk</h3> -->
                   <div class="form-group">
                       <input type="text" class="form-control" name="username" placeholder="Username" required="required" autocomplete="username">
                   </div>
                   <div class="form-group">
                       <input type="password" class="form-control" name="password" placeholder="Password" required="required" autocomplete="current-password">
                   </div>
                   <button type="submit" id="loginBtn" class="btn btn-primary block full-width m-b" data-loading-text="Loging In..."> <?php if (!empty($_COOKIE['lang_set']) && $_COOKIE['lang_set'] == 'en') {
                                                                                                                                            echo 'Login';
                                                                                                                                        } else {
                                                                                                                                            echo 'Masuk';
                                                                                                                                        } ?></button>
                   <a class="btn btn-default block full-width m-b" href="<?= site_url() ?>">
                       Halaman Utama</a>
               </form>
           </div>

           <!-- </div> -->
       </div>
   </div>
   <script>
       $(document).ready(function() {

           var loginForm = $('#loginForm');
           var submitBtn = loginForm.find('#loginBtn');
           loginForm.on('submit', (ev) => {
               ev.preventDefault();
               $.ajax({
                   url: "<?= site_url() . 'login-process' ?>",
                   type: "POST",
                   data: loginForm.serialize(),
                   success: (data) => {
                       json = JSON.parse(data);
                       if (json['error']) {
                           Swal.fire("Login Gagal", json['message'], "error");
                           return;
                       }
                       $(location).attr('href', '<?= base_url() ?>' + json['user']['nama_controller']);
                   },
                   error: () => {}
               });
           });

           var lang_in = $('#lang_in');
           var lang_en = $('#lang_en');
           lang_in.on('click', (ev) => {
               document.cookie = "lang_set=in";
               location.reload();
           });
           lang_en.on('click', (ev) => {
               document.cookie = "lang_set=en";
               location.reload();
           });
       });
   </script>