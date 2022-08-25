<!--HEADER PART START-->
<header>
    <div class="header py-1">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light px-0 py-0">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <div class="logo">
                        <img src="<?= base_url('assets') ?>/img/logo.png" class="w-100 img-fluid" alt="" />
                    </div>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="icofont-navigation-menu"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <?php $this->load->view('admin/fragment_' . $this->session->userdata('login')['nama_controller']); ?>
                </div>
            </nav>
        </div>
    </div>
</header>