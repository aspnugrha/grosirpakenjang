<script>
    $(document).ready(function() {

        $('#tbl-jenis-barang').DataTable({
            drawCallback: function() {
                $('.example-popover').popover({
                    html: true,
                    sanitize: false,
                })
            },
            "language": {
                "emptyTable": "Data tidak tersedia",
                "processing": '<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>',
                "search": "Pencarian",
                "lengthMenu": "Tampil _MENU_ Baris",
                "oPaginate": {
                    "sFirst": "&laquo;",
                    "sLast": "&raquo;",
                    "sNext": "&rsaquo;",
                    "sPrevious": "&lsaquo;"
                },
            },
            "processing": true,
            "paging": true,
            "bInfo": false,
            "searching": true,
            "pageLength": 25,
            'serverMethod': 'post',

            "ajax": {
                "url": base_url + '/Admin/Data_master_jenis_barang/load_jenis_barang',
                "type": "POST",
                dataType: 'json',
            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],

        });
    });

    function load_jenis_barang() {
        $('#tbl-jenis-barang').DataTable().ajax.reload();
    }

    function clear_modal() {
        $('#id').val('');
        $('#jenis').val('');
        document.getElementById('jenis').classList.remove('is-invalid');
    }

    function tambah() {
        clear_modal();
        $('#title-modal').text('Tambah Jenis Barang');
        $('#modal').modal('show');
    }

    function cek_simpan() {
        var jenis = $('#jenis').val();

        if (jenis != '') {
            document.getElementById('jenis').classList.remove('is-invalid');
            simpan();
        } else {
            document.getElementById('jenis').classList.add('is-invalid');
        }
    }

    function simpan() {
        var id = $('#id').val();
        var jenis = $('#jenis').val();

        $.ajax({
            type: "POST",
            url: base_url + '/Admin/Data_master_jenis_barang/simpan_jenis_barang',
            data: {
                id: id,
                jenis: jenis,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                if (res == 'success') {
                    clear_modal();
                    $('#modal').modal('hide');
                    load_jenis_barang();

                    if (id != '') {
                        show_toastr('Jenis barang berhasil diupdate!', 'success', 'top-right');
                    } else {
                        show_toastr('Jenis barang berhasil disimpan!', 'success', 'top-right');
                    }
                } else {
                    document.getElementById('jenis').classList.add('is-invalid');
                    show_toastr('Jenis barang sudah ada!', 'error', 'top-right');
                }
            },
        });
    }

    function edit(id) {
        $.ajax({
            type: "GET",
            url: base_url + '/Admin/Data_master_jenis_barang/edit_jenis_barang/' + id,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                clear_modal();

                $('#id').val(res['id']);
                $('#jenis').val(res['jenis']);

                $('#title-modal').text('Edit Jenis Barang');
                $('#modal').modal('show');
            },
        });
    }

    function hapus(id) {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus jenis barang?",
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
                denyButton: 'order-3',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: base_url + '/Admin/Data_master_jenis_barang/hapus_jenis_barang/' + id,
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(res) {
                        swal.close();
                        load_jenis_barang();
                        show_toastr('Jenis Barang berhasil dihapus!', 'success', 'top-right');
                    },
                });
            } else if (result.isDenied) {
                swal.close();
                load_jenis_barang();
            }
        })

    }
</script>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal">Form Jenis Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-modal">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Jenis Barang</label>
                        <input type="email" class="form-control" name="jenis" id="jenis" placeholder="">
                        <div class="invalid-feedback">Jenis Barang can't be null.</div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-pill" id="btn-simpan" onclick="cek_simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>