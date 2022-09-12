<!--HEADER PART START-->
<header>
    <div class="header py-1">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light px-0 py-0">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <div class="logo">
                        <img src="<?= base_url('assets') ?>/img/logo2.png" class="w-100 img-fluid" alt="" />
                    </div>
                </a>
                <div class="open-time">
                    <?php
                    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum`at', 'Sabtu', 'Minggu'];
                    $cur_jam = JamBuka(true);
                    if (!empty($cur_jam)) {
                        $cur_jam = $cur_jam[0];
                    ?>
                        <h6><i class="icofont-clock-time"></i> Open Now</h6>
                        <span><?= substr($cur_jam['jam_start'], 0, 5) . ' - ' . substr($cur_jam['jam_end'], 0, 5) ?></span>

                    <?php
                    } else {
                        echo '<h6><i class="icofont-clock-time"></i> Close Now</h6>';
                    }
                    ?>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="icofont-navigation-menu"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav navbar-custom">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= base_url() ?>">Home </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('#about') ?>l">About</a>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pages
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="blog.html">Blog</a>
                                <a class="dropdown-item" href="singlepost.html">Single Post</a>
                                <a class="dropdown-item" href="error.html">404_Error</a>
                            </div>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                        <?php if (!empty($this->session->userdata()['pemesanan'])) { ?>
                            <li class="nav-item">
                                <span class="nav-link"><a href="<?= base_url('order') ?>"> <i class='icofont-restaurant'> </i>Pilih Menu</a></span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link"><a href="<?= base_url('cart') ?>"> <i class='icofont-cart'> </i>Cart</a></span>
                            </li>
                        <?php } else { ?>
                        <?php } ?>
                        <li class="nav-item last-menu-bg">
                            <span class="nav-link"><a href="https://wa.me/6281291831994"> <i class="icofont-whatsapp"></i> +6281291831994</a></span>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
<!--HEADER PART END-->