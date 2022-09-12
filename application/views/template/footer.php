<!--FOOTER BOTTOM END-->

<!-- jQuery File-->
<script src="<?= base_url('assets') ?>/js/jquery-3.5.1.min.js"></script>
<!-- Popper JS -->
<script src="<?= base_url('assets') ?>/js/popper.min.js"></script>
<!-- Slick JS -->
<script src="<?= base_url('assets') ?>/js/slick.min.js"></script>
<!-- Bootstrap JS -->
<script src="<?= base_url('assets') ?>/js/bootstrap.min.js"></script>
<!-- Venobox JS -->
<script src="<?= base_url('assets') ?>/js/venobox.min.js"></script>
<!-- main.js -->
<script src="<?= base_url('assets') ?>/js/main.js"></script>
<script type="text/javascript" src="<?= base_url('assets') ?>/plugins/DataTables/datatables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/plugins/input-mask/jquery.mask.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="<?= base_url('assets') ?>/js/custom.js?v=0.0.1"></script>
<script>
    $(".testimonial-slider").slick({
        autoplay: true,
        autoplaySpreed: 7000,
        arrows: true,
        prevArrow: '<i class="icofont-arrow-left"></i>',
        nextArrow: '<i class="icofont-arrow-right"></i>',
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
</script>
</body>

</html>