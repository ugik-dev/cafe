<form opd="form" id="menu_form" onsubmit="return false;" type="multipart" autocomplete="off">
    <div class="hero-section">
        <div class="bubble">
            <img src="<?= base_url('assets') ?>/img/bubble.png" alt="bubble-images " class="w-100 img-fluid" />
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="hero-sec-content">
                        <h1>Menu <?= $dataContent['dataSes']['nama_meja'] ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="service-sectiond fixed-bottom" style="background-color: #ff702a;    padding: 10px 10px; ">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <select id="filter_menu" class="form-control">
                        <option value="" selected>Semua Menu</option>
                        <option value="rekomendasi">Rekomendasi</option>
                        <option value="promo">Promo</option>
                        <?PHP foreach ($dataContent['kategori'] as $k) {
                            echo "<option value='" . strtolower(preg_replace('/[0-9\&\.\;\/\" "]+/', '', $k['nama_kategori'])) . "'>" . $k['nama_kategori'] . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="col-sm-6">
                    <button class="c1-submit-btn my-1 mr-sm-2 btn-block" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Selesai</strong></button>
                </div>
            </div>
            <!-- <div class="row"></div>
<ul class="nav nav-pills custom-nav mb-3" id="pills-tab" role="tablist">
    <li id="select-all-kategori" class="nav-item" role="presentation">
        <a class="nav-link show custom-nav-link active" data-toggle="pill" aria-selected="true">Semua </a>
    </li>
    <li id="select-menu-utama" class="nav-item" role="presentation">
        <a class="nav-link custom-nav-link" data-toggle="pill" aria-selected="false">Menu Utama</a>
    </li>
    <li id="select-junk-food" class="nav-item" role="presentation">
        <a class="nav-link custom-nav-link" data-toggle="pill" aria-selected="false">Junk Food</a>
    </li>
    <li id="select-minuman" class="nav-item" role="presentation">
        <a class="nav-link custom-nav-link" data-toggle="pill" aria-selected="false">Minuman</a>
    </li>
    <li id="select-beer" class="nav-item" role="presentation">
        <a class="nav-link custom-nav-link" data-toggle="pill" aria-selected="false">Beer</a>
    </li>
</ul> -->
            <!-- <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
        <div id="select-all-kategori" class="image-box clearfix d-flex align-items-center">
            <div class="box-image float-left">
                <img src="<?= base_url('assets') ?>/img/honney.png" alt="" />
            </div>
            <div class="image-text float-left">
                <h2>Semua</h2>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
        <div id="select-junk-food" class="image-box clearfix d-flex align-items-center">
            <div class="box-image float-left">
                <img src="<?= base_url('assets') ?>/img/honney.png" alt="" />
            </div>
            <div class="image-text float-left">
                <h2>Junk Food</h2>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
        <div id="select-menu-utama" class="image-box clearfix d-flex align-items-center">
            <div class="box-image float-left">
                <img src="<?= base_url('assets') ?>/img/macaron.png" alt="" />
            </div>
            <div class="image-text float-left">
                <h2>Menu Utama</h2>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
        <div id="select-minuman" class="image-box clearfix d-flex align-items-center">
            <div class="box-image float-left">
                <img src="<?= base_url('assets') ?>/img/dinner.png" alt="" />
            </div>
            <div class="image-text float-left">
                <h2 class="">Minuman</h2>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mb-2">
        <div id="select-beer" class="image-box clearfix d-flex align-items-center">
            <div class="box-image float-left">
                <img src="<?= base_url('assets') ?>/img/dinner.png" alt="" />
            </div>
            <div class="image-text float-left">
                <h2 class="">Beer</h2>
            </div>
        </div>
    </div>
</div> -->
        </div>
    </div>
    <div class="blog-section">
        <div class="container">
            <input type="hidden" name="id_ses" value="<?= $dataContent['dataSes']['id_ses'] ?>">
            <div class="row" id="row_menu">
                <!-- tesst -->
                <!-- <div class="food-informaion">
            <div class="row align-items-center">
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="food-info text-left">
                        <h2>Vegetable Roll</h2>
                        <h3><span>Rp </span>18.00</h3>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control" id="menu_224" name="menu_224" placeholder="0" value="0" aria-label="Recipient's username with two button addons">
                            <button class="btn btn-outline-secondary min" type="button" data-id="224">-</button>
                            <a class="btn btn-outline-secondary plus" data-id='224'>+</a>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                    <img src="http://localhost:85/apri_cafe/uploads/menu/56079065420e5a37d9dc8a9c50876b73.jpg" style="height : 100px !important;width : 150px !important ; border-radius: 2%" class="img-fluid" alt="">
                </div>
            </div>
        </div> -->
                <!-- end test -->
            </div>

        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $.when(getAllMenu()).then((e) => {
            Swal.close();
        }).fail((e) => {
            console.log(e)
        });
        var swalSaveConfigure = {
            title: "Konfirmasi",
            text: "Yakin akan melakukan pesanan ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Pesan!",
        };

        layout = $('#row_menu');

        function resetFilter() {
            <?PHP foreach ($dataContent['kategori'] as $k) {
                echo "$('." . strtolower(preg_replace('/[0-9\&\.\;\/\" "]+/', '', $k['nama_kategori'])) . "').hide();";
            } ?>
        }

        function showAll() {
            <?PHP foreach ($dataContent['kategori'] as $k) {
                echo "$('." . strtolower(preg_replace('/[0-9\&\.\;\/\" "]+/', '', $k['nama_kategori'])) . "').show();";
            } ?>
        }

        filter_menu = $('#filter_menu');
        filter_menu.on('change', function() {
            //    console.log(filter_menu.val());
            resetFilter()
            if (filter_menu.val() == '') {
                showAll();
                //    } else if (filter_menu.val() == 'rekomendasi') {
                //        $('.' + filter_menu.val()).show()
                //    } else if (filter_menu.val() == 'promo') {
                //        showAll();
            } else {
                $('.' + filter_menu.val()).show()
            }

        });

        menu_form = $('#menu_form');
        menu_form.submit(function(event) {
            event.preventDefault();
            var url = "<?= site_url('Home/order_process_two') ?>";


            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                //    Swal.fire({
                //        title: 'Loading!',
                //        html: 'Harap tunggu  <b></b> beberapa saat.',
                //        allowOutsideClick: false
                //    })
                //    Swal.showLoading();
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: menu_form.serialize(),
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }

                        Swal.fire({
                            title: 'Berhasil!',
                            html: 'Pesanan berhasil diorder.',
                            icon: 'success',
                        })
                        location.href = '<?= base_url('cart') ?>';
                        //    renderUser(dataUser);
                        //    UserModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });


        function getAllMenu() {
            return $.ajax({
                url: `<?php echo site_url('General/getAllMenu/') ?>`,
                'type': 'post',
                data: {
                    'sort': 'Y',
                    'res_array': 'Y'
                },
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataUser = json['data'];
                    renderMenu(dataUser);
                    console.log(dataUser);
                },
                error: function(e) {}
            });
        }

        function render(d) {
            html = `
            <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="blog mb-4">
                <div class="blog-img">
                    <img src="<?= base_url('uploads/menu/') ?>${d['gambar']}" style="height : 215px !important;width : 370px !important ; border-radius: 2%" class="img-fluid" alt="" />
                </div>
                <div class="blog-content">
                    <div class="date">
                        <a  class="publish-btn">Rp ${d['harga']},-</a>
                    </div>
                    <h2>
                            ${d['nama_menu']}
                    </h2>
                    <div class="input-group">
                        <input type="number" min="0" class="form-control" id="menu_${d['id_menu']}"  name="menu_${d['id_menu']}" placeholder="0" value="0" aria-label="Recipient's username with two button addons">
                        <button class="btn btn-outline-secondary min" type="button" data-id="${d['id_menu']}">-</button>
                        <a class="btn btn-outline-secondary plus" data-id='${d['id_menu']}'>+</a>
                    </div>
                </div>
            </div>
            </div>`;

            html2 = ` 
    <div class="${d['nama_kategori'].replace(/[^a-zA-Z]/g, '').toLowerCase()} ${d['rekomendasi'] == 'Y' ? 'rekomendasi': ''} ${d['promo'] == 'Y' ? 'promo': ''} food-menu text-center mr-1 ml-1">
            <div class="row align-items-center">
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="food-info text-left">
                        <small> ${d['nama_kategori']}</small>
                        <h4> ${d['rekomendasi'] == 'Y' ? '<i class="icofont-like icofont-2x" style="color: #ff702a"></i>': ''}
                        ${d['nama_menu']}</h4>
                        <h3><span>Rp </span>${d['promo'] == 'Y' && d['diskon'] > 0 ?  '<small><del style="text-decoration-style: single;">'+convertToRupiah(d['harga'])+'</del></small> ' + convertToRupiah(d['harga']-d['diskon']): convertToRupiah(d['harga']) }</h3>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control" id="menu_${d['id_menu']}" name="menu_${d['id_menu']}" placeholder="0" value="0" aria-label="Recipient's username with two button addons">
                            <button class="btn btn-outline-secondary min" type="button" data-id="${d['id_menu']}">-</button>
                            <a class="btn btn-outline-secondary plus" data-id='${d['id_menu']}'>+</a>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                    <img src="<?= base_url('uploads/menu/') ?>${d['gambar']}" style="height : 100px !important;width : 150px !important ; border-radius: 12%" class="img-fluid" alt="">
                </div>
            </div>
        </div>`
            layout.append(html2);
        }

        function renderMenu(data) {
            Object.values(data).forEach((d) => {
                //    if (d['nama_menu'].toLowerCase().match(/^.*go.*/)) {
                render(d)
                //    }

            });



            $('.plus').on('click', function() {
                var currentData = $(this).data('id');
                $('#menu_' + currentData).val(parseInt($('#menu_' + currentData).val()) + 1);
                console.log(currentData);
            })
            $('.min').on('click', function() {
                var currentData = $(this).data('id');
                $('#menu_' + currentData).val(parseInt($('#menu_' + currentData).val()) - 1);
                if (parseInt($('#menu_' + currentData).val()) < 0) {
                    $('#menu_' + currentData).val(0);
                }
                //    console.log(currentData);
            })
        }
    })
</script>