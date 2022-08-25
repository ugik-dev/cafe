<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox ssection-container">
        <div class="ibox-content">
            <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                <!-- <input type="hidden" id="is_not_self" name="is_not_self" value="1"> -->
                <select class="form-control mr-sm-2" name="id_role" id="id_role"></select>
                <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fal fa-plus"></i> Tambah Menu Baru</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="FDataTable" class="table table-bordered table-hover" style="padding:0px">
                            <thead>
                                <tr>
                                    <th style="width: 7%; text-align:center!important">ID</th>
                                    <!-- <th style="width: 24%; text-align:center!important">Username</th> -->
                                    <th style="width: 24%; text-align:center!important">Nama</th>
                                    <th style="width: 16%; text-align:center!important">Harga</th>
                                    <th style="width: 16%; text-align:center!important">Gambar</th>
                                    <th style="width: 16%; text-align:center!important">Status</th>
                                    <th style="width: 5%; text-align:center!important">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal" id="user_modal" tabindex="-1" opd="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <!-- <h4 class="modal-title">Kelola Menu</h4> -->
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_menu" name="id_menu">
                    <div class="form-group">
                        <label for="nama_menu">Nama</label>
                        <input type="text" placeholder="Nama" class="form-control" id="nama_menu" name="nama_menu" required="required">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" placeholder="" class="form-control mask" id="harga" name="harga">
                    </div>
                    <div class="form-group">
                        <label for="status">Kategori</label>
                        <select class="form-control mr-sm-2" name="id_kategori" id="id_kategori" required="required">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control mr-sm-2" name="status" id="status" required="required">
                            <option value="1">Active</option>
                            <option value="2">Non Active</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokumen_buyer">Upload Gambar</label>
                        <input class="form-control" type="file" id="file_gambar" name="file_gambar">

                        <!-- <p class="no-margins"><span id="gambar">-</span></p> -->
                    </div>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="add_btn" data-loading-text="Loading..."><strong>Tambah Data</strong></button>
                    <button class="btn btn-success my-1 mr-sm-2" type="submit" id="save_edit_btn" data-loading-text="Loading..."><strong>Simpan Perubahan</strong></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#kelola_user').addClass('active');
        // $('.mask').mask('000.000.000', {
        //     reverse: true
        // });
        var toolbar = {
            'form': $('#toolbar_form'),
            'id_role': $('#toolbar_form').find('#id_role'),
            'newBtn': $('#new_btn'),
        }

        var FDataTable = $('#FDataTable').DataTable({
            'columnDefs': [],
            deferRender: true,
            "order": [
                [0, "desc"]
            ]
        });

        var UserModal = {
            'self': $('#user_modal'),
            'info': $('#user_modal').find('.info'),
            'form': $('#user_modal').find('#user_form'),
            'addBtn': $('#user_modal').find('#add_btn'),
            'saveEditBtn': $('#user_modal').find('#save_edit_btn'),
            'idMenu': $('#user_modal').find('#id_menu'),
            'nama_menu': $('#user_modal').find('#nama_menu'),
            'id_kategori': $('#user_modal').find('#id_kategori'),
            'harga': $('#user_modal').find('#harga'),
            'status': $('#user_modal').find('#status'),
            // 'gambar': new FileUploader($('#user_modal').find('#gambar'), "", "gambar", ".png , .jpg , .jpeg", false, true),

        }

        var dataRole = {}
        var dataUser = {}

        var swalSaveConfigure = {
            title: "Konfirmasi simpan",
            text: "Yakin akan menyimpan data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#18a689",
            confirmButtonText: "Ya, Simpan!",
        };

        var swalDeleteConfigure = {
            title: "Konfirmasi hapus",
            text: "Yakin akan menghapus data ini?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
        };
        Swal.fire({
            title: 'Loading!',
            html: 'Harap tunggu  <b></b> beberapa saat.',
        })
        Swal.showLoading();
        $.when(getAllKategori(), getAllMenu()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
            Swal.close();
        }).fail((e) => {
            console.log(e)
        });


        function getAllMenu() {
            return $.ajax({
                url: `<?php echo site_url('General/getAllMenu/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataUser = json['data'];
                    renderUser(dataUser);
                },
                error: function(e) {}
            });
        }

        function getAllKategori() {
            return $.ajax({
                url: `<?php echo site_url('General/getAllKategori/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    data = json['data'];
                    // renderFilterKategori(dataUser);
                    renderSelectionKategori(data);
                },
                error: function(e) {}
            });
        }

        function renderSelectionKategori(data) {
            UserModal.id_kategori.empty();
            UserModal.id_kategori.append($('<option>', {
                value: "",
                text: "-- Pilih Kategori --"
            }));
            Object.values(data).forEach((d) => {
                UserModal.id_kategori.append($('<option>', {
                    value: d['id_kategori'],
                    text: d['id_kategori'] + ' :: ' + d['nama_kategori'],
                }));
            });
        }

        function renderFilterKategori(data) {
            Object.values(data).forEach((user) => {

            })
        }


        function renderUser(data) {
            if (data == null || typeof data != "object") {
                console.log("User::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
                                    <a class="edit dropdown-item" data-id='${user['id_menu']}'><i class='fa fa-pencil'></i> Edit User</a>
                                `;
                var deleteButton = `
                                    <a class="delete dropdown-item" data-id='${user['id_menu']}'><i class='fa fa-trash'></i> Hapus User</a>
                                `;
                var button = `
                                    <div class="btn-group" opd="group">
                                    <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-bars'></i></button>
                                    <div class="dropdown-menu" aria-labelledby="action">
                                        ${editButton}
                                        ${deleteButton}
                                    </div>
                                    </div>
                                `;
                renderData.push([user['id_menu'], user['nama_menu'], user['harga'], user['gambar'] != '' ? '<img style="width: 100px" src="<?= base_url('uploads/menu/') ?>' + user['gambar'] + '">' : '', user['status'] == 1 ? 'Active' : 'Non Active', button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function resetUserModal() {
            UserModal.form.trigger('reset');
        }

        toolbar.newBtn.on('click', (e) => {
            resetUserModal();
            UserModal.self.modal('show');
            UserModal.addBtn.show();
            UserModal.saveEditBtn.hide();
        });

        FDataTable.on('click', '.edit', function() {
            resetUserModal();
            UserModal.self.modal('show');
            UserModal.addBtn.hide();
            UserModal.saveEditBtn.show();


            var currentData = dataUser[$(this).data('id')];
            console.log(currentData)
            UserModal.idMenu.val(currentData['id_menu']);
            UserModal.nama_menu.val(currentData['nama_menu']);
            UserModal.harga.val(currentData['harga']);
            UserModal.id_kategori.val(currentData['id_kategori']);
            UserModal.status.val(currentData['status']);
        });

        // var dengan_rupiah = document.getElementById('dengan-rupiah');
        // dengan_rupiah.addEventListener('keyup', function(e) {
        //     dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
        // });

        UserModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = UserModal.addBtn.is(':visible');
            var url = "<?= site_url('Admin/') ?>";
            url += isAdd ? "addMenu" : "editMenu";
            var button = isAdd ? UserModal.addBtn : UserModal.saveEditBtn;
            Swal.fire({
                title: 'Loading!',
                html: 'Harap tunggu  <b></b> beberapa saat.',
            })

            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                // buttonLoading(button);
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: new FormData(UserModal.form[0]),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        // buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var user = json['data']
                        dataUser[user['id_menu']] = user;
                        Swal.fire({
                            title: 'Berhasil!',
                            html: 'Data berhasil disimpan.',
                            icon: 'success',
                        })
                        renderUser(dataUser);
                        UserModal.self.modal('hide');
                    },
                    error: function(e) {}
                });
            });
        });

        FDataTable.on('click', '.delete', function() {
            event.preventDefault();
            var id = $(this).data('id');
            // swal(swalDeleteConfigure).then((result) => {
            //     if (!result.value) {
            //         return;
            //     }
            //     $.ajax({
            //         url: "<?= site_url('UserController/deleteUser') ?>",
            //         'type': 'POST',
            //         data: {
            //             'id_menu': id
            //         },
            //         success: function(data) {
            //             var json = JSON.parse(data);
            //             if (json['error']) {
            //                 swal("Delete Gagal", json['message'], "error");
            //                 return;
            //             }
            //             delete dataUser[id];
            //             swal("Delete Berhasil", "", "success");
            //             renderUser(dataUser);
            //         },
            //         error: function(e) {}
            //     });
            // });
        });
    });
</script>