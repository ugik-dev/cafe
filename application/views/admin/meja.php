<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox ssection-container">
        <div class="ibox-content">
            <form class="form-inline" id="toolbar_form" onsubmit="return false;">
                <!-- <input type="hidden" id="is_not_self" name="is_not_self" value="1"> -->
                <select class="form-control mr-sm-2" name="id_role" id="id_role"></select>
                <button type="button" class="btn btn-success my-1 mr-sm-2" id="new_btn" disabled="disabled"><i class="fal fa-plus"></i> Tambah Meja</button>
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
                                    <!-- <th style="width: 24%; text-align:center!important">Mejaname</th> -->
                                    <th style="width: 24%; text-align:center!important">Nama</th>
                                    <!-- <th style="width: 16%; text-align:center!important">Code</th>
                                    <th style="width: 16%; text-align:center!important">url</th> -->
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
                <!-- <h4 class="modal-title">Kelola Meja</h4> -->
                <span class="info"></span>
            </div>
            <div class="modal-body" id="modal-body">
                <form opd="form" id="user_form" onsubmit="return false;" type="multipart" autocomplete="off">
                    <input type="hidden" id="id_meja" name="id_meja">
                    <div class="form-group">
                        <label for="nama_meja">Nama</label>
                        <input type="text" placeholder="Nama" class="form-control" id="nama_meja" name="nama_meja" required="required">
                    </div>
                    <!-- <div class="form-group">
                        <label for="code">Generate Code</label>
                        <input type="text" placeholder="Kosong akan melakukan generate otomatis" class="form-control" id="code" name="code">
                    </div> -->

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control mr-sm-2" name="status" id="status" required="required">
                            <option value="1">Active</option>
                            <option value="2">Non Active</option>
                        </select>
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

        var MejaModal = {
            'self': $('#user_modal'),
            'info': $('#user_modal').find('.info'),
            'form': $('#user_modal').find('#user_form'),
            'addBtn': $('#user_modal').find('#add_btn'),
            'saveEditBtn': $('#user_modal').find('#save_edit_btn'),
            'idMeja': $('#user_modal').find('#id_meja'),
            'nama_meja': $('#user_modal').find('#nama_meja'),
            // 'code': $('#user_modal').find('#code'),
            'status': $('#user_modal').find('#status'),
        }

        var dataRole = {}
        var dataMeja = {}

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
        $.when(getAllMeja()).then((e) => {
            toolbar.newBtn.prop('disabled', false);
            Swal.close();
        }).fail((e) => {
            console.log(e)
        });

        // toolbar.id_role.on('change', (e) => {
        //     MejaModal.id_role.attr('readonly', !empty(toolbar.id_role.val()));
        //     getAllMeja();
        // });

        function getAllMeja() {
            return $.ajax({
                url: `<?php echo site_url('General/getAllMeja/') ?>`,
                'type': 'POST',
                data: toolbar.form.serialize(),
                success: function(data) {
                    var json = JSON.parse(data);
                    if (json['error']) {
                        return;
                    }
                    dataMeja = json['data'];
                    renderMeja(dataMeja);
                },
                error: function(e) {}
            });
        }

        function renderMeja(data) {
            if (data == null || typeof data != "object") {
                console.log("Meja::UNKNOWN DATA");
                return;
            }
            var i = 0;

            var renderData = [];
            Object.values(data).forEach((user) => {
                var editButton = `
                                    <a class="edit dropdown-item" data-id='${user['id_meja']}'><i class='fa fa-pencil'></i> Edit Meja</a>
                                `;
                // var deleteButton = `
                //                     <a class="delete dropdown-item" data-id='${user['id_meja']}'><i class='fa fa-trash'></i> Hapus Meja</a>
                //                 `;
                var button = `
                                    <div class="btn-group" opd="group">
                                    <button id="action" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-bars'></i></button>
                                    <div class="dropdown-menu" aria-labelledby="action">
                                        ${editButton}
                                       
                                    </div>
                                    </div>
                                `;
                renderData.push([user['id_meja'], user['nama_meja'], user['status'] == 1 ? 'Active' : 'Non Active', button]);
            });
            FDataTable.clear().rows.add(renderData).draw('full-hold');
        }

        function resetMejaModal() {
            MejaModal.form.trigger('reset');
        }

        toolbar.newBtn.on('click', (e) => {
            resetMejaModal();
            MejaModal.self.modal('show');
            MejaModal.addBtn.show();
            MejaModal.saveEditBtn.hide();
        });

        FDataTable.on('click', '.edit', function() {
            resetMejaModal();
            MejaModal.self.modal('show');
            MejaModal.addBtn.hide();
            MejaModal.saveEditBtn.show();


            var currentData = dataMeja[$(this).data('id')];
            MejaModal.idMeja.val(currentData['id_meja']);
            MejaModal.nama_meja.val(currentData['nama_meja']);
            MejaModal.code.val(currentData['code']);
            MejaModal.status.val(currentData['status']);
        });

        MejaModal.form.submit(function(event) {
            event.preventDefault();
            var isAdd = MejaModal.addBtn.is(':visible');
            var url = "<?= site_url('Admin/') ?>";
            url += isAdd ? "addMeja" : "editMeja";
            var button = isAdd ? MejaModal.addBtn : MejaModal.saveEditBtn;
            Swal.fire({
                title: 'Loading!',
                html: 'Harap tunggu  <b></b> beberapa saat.',
            })
            // Swal.showLoading();

            Swal.fire(swalSaveConfigure).then((result) => {
                if (!result.value) {
                    return;
                }
                buttonLoading(button);
                $.ajax({
                    url: url,
                    'type': 'POST',
                    data: MejaModal.form.serialize(),
                    success: function(data) {
                        buttonIdle(button);
                        var json = JSON.parse(data);
                        if (json['error']) {
                            swal("Simpan Gagal", json['message'], "error");
                            return;
                        }
                        var user = json['data']
                        dataMeja[user['id_meja']] = user;
                        Swal.fire({
                            title: 'Berhasil!',
                            html: 'Data berhasil disimpan.',
                            icon: 'success',
                        })
                        renderMeja(dataMeja);
                        MejaModal.self.modal('hide');
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
            //         url: "<?= site_url('MejaController/deleteMeja') ?>",
            //         'type': 'POST',
            //         data: {
            //             'id_meja': id
            //         },
            //         success: function(data) {
            //             var json = JSON.parse(data);
            //             if (json['error']) {
            //                 swal("Delete Gagal", json['message'], "error");
            //                 return;
            //             }
            //             delete dataMeja[id];
            //             swal("Delete Berhasil", "", "success");
            //             renderMeja(dataMeja);
            //         },
            //         error: function(e) {}
            //     });
            // });
        });
    });
</script>