<?php $this->load->view('template/header'); ?>

<?php $this->load->view('template/section_header'); ?>

<?php
$this->load->view($page);
$this->load->view('template/section_footer');
$this->load->view('template/footer'); ?>