<?php $this->load->view('template/header');
$this->load->view('template_user/section_header'); ?>
<div class="home-main-section">
    <div class="bubble">
        <img src="<?= base_url('assets') ?>/img/bubble.png" alt="bubble-images " class="w-100 img-fluid" />
    </div>
</div>
<div class="food-menu-section" id="food-menu">
    <div class="container">
        <?php
        $this->load->view($page);
        ?>
    </div>
</div>

<?php
$this->load->view('template/section_footer');
$this->load->view('template/footer'); ?>