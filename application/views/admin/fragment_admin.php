               <ul class="navbar-nav navbar-custom">
                   <li class="nav-item" id="mn_dashboard">
                       <a class="nav-link" href="<?= base_url('admin') ?>">Dashboard </a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="<?= base_url('admin/laporan') ?>" id="mn_laporan">Laporan</a>
                   </li>
                   <li class="nav-item dropdown">
                       <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           Pengaturan
                       </a>
                       <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <a class="dropdown-item" href="<?= base_url('admin/menu') ?>">Menu</a>
                           <a class="dropdown-item" href="<?= base_url('admin/meja') ?>">Meja</a>
                           <a class="dropdown-item" href="<?= base_url('admin/pengguna') ?>">Pengguna</a>
                       </div>
                   </li>
                   <!-- <li class="nav-item">
                       <a class="nav-link" href="contact.html">Contact</a>
                   </li> -->

                   <li class="nav-item last-menu-bg">
                       <span class="nav-link"><a href="<?= base_url('logout') ?>">LOGOUT</a></span>
                   </li>
               </ul>