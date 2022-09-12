<!--FOOTER TOP SECTION START-->
<div class="footer-top" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div class="footer-top-content">
                    <div class="logo">
                        <img src="<?= base_url('assets') ?>/img/logo2.png" style="width: 200px" alt="" />
                    </div>
                    <!-- <p>
                        If you are going to use a passage of need to be sure there isn't
                        anything hidden in the middle text.
                    </p>
                    <span>If you are going to use a passage of need to be sure there
                        isn't</span>
                    <ul class="social-icon-list">
                        <li>
                            <a href="#"><i class="icofont-facebook"></i></a>
                        </li>
                        <li class="social-icon custom-icon-pinterest">
                            <a href="#"><i class="icofont-pinterest"></i></a>
                        </li>
                        <li class="social-icon custom-icon-dribbble">
                            <a href="#"><i class="icofont-dribbble"></i></a>
                        </li>
                        <li class="social-icon custom-icon-twitter">
                            <a href="#"><i class="icofont-twitter"></i></a>
                        </li>
                    </ul> -->
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="contact-content">
                    <h3>Contact Us</h3>
                    <img src="<?= base_url('assets') ?>/img/border.png" alt="" />
                    <div class="contact-info d-flex align-items-center">
                        <div class="icon"><i class="icofont-whatsapp"></i></div>
                        <div class="info">
                            <a target="_blank" href="https://wa.me/6281291831994">+62 812 9183 1994</a>
                        </div>
                    </div>
                    <div class="contact-info d-flex align-items-center">
                        <div class="icon"><i class="icofont-instagram"></i></div>
                        <div class="info">
                            <a target="_blank" href="https://instagram.com/siguntang_cafferesto">@siguntang_cafferesto</a>
                        </div>
                    </div>
                    <div class="contact-info d-flex align-items-center">
                        <div class="icon"><i class="icofont-google-map"></i></div>
                        <div class="info">
                            <a target="_blank" href="https://goo.gl/maps/tDvCMZNEEBViEy2o8">Jl. Bharata Blok J No.2, <br>
                                Perumnas Bumi Telukjambe Ds. Sukalayu Kec. Telukjambe Timur, Kab. Kawarang</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5">
                <div class="opening-hours">
                    <div class="opening-content">
                        <h3>Opening Hours:</h3>
                        <div class="row mt-4">
                            <?php
                            $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum`at', 'Sabtu', 'Minggu'];
                            $jam = JamBuka();
                            $span = 'custom-date-span';
                            foreach ($jam as $j) {
                                echo ' <div class="col-4 mt-2">
                                <span class="' . ($j['hari'] == date('N') ? 'custom-date-span' : '') . '">' . $hari[$j['hari'] - 1] . '</span>
                            </div>
                            <div class="col-4 mt-2">
                                <img src="' . base_url('assets') . '/img' . ($j['hari'] == date('N') ? '/line3' : '/line2') . '.png" alt="" />
                            </div>
                            <div class="col-4 mt-2">
                                <span class="' . ($j['hari'] == date('N') ? 'custom-date-span' : '') . '">' . substr($j['jam_start'], 0, 5) . ' - ' . substr($j['jam_end'], 0, 5) . ' </span>
                            </div>
                            ';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--FOOTER TOP SECTION END-->

<!--FOOTER BOTTOM START-->
<div class="footer-bootom">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-xl-7">
                <div class="copyright-txt">
                    <p>Copyright 2022 @ Siguntang Cafe & Resto.</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 col-xl-5">
                <div class="terms">
                    <span><a href="#">Terms & Conditions</a> |
                        <a href="#">Privacy Policy</a></span>
                </div>
            </div>
        </div>
    </div>
</div>