<script>
    $(document).ready(function() {
        // $('#filter_tgl').daterangepicker();

        $('#tbl-barang').DataTable({
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
            "searching": false,
            "pageLength": 25,
            'serverMethod': 'post',

            "ajax": {
                "url": base_url + '/a/data_master/ajax/load_barang',
                "type": "POST",
                dataType: 'json',
                "data": function(data) {
                    // data.tgl = $('#filter_tgl').val();
                    data.urutan = $('#filter_urutan').val();
                    data.jenis = $('#filter_jenis').val();
                    data.search = $('#filter_search').val();
                },

            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],

        });

        $('#jenis').select2({
            ajax: {
                url: base_url + '/Admin/Data_master_jenis_barang/load_select2',
                type: "post",
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    // CSRF Hash
                    var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                    return {
                        searchTerm: params.term, // search term
                        [csrfName]: csrfHash // CSRF Token
                    };
                },
                processResults: function(response) {

                    // Update CSRF Token
                    $('.txt_csrfname').val(response.token);

                    return {
                        results: response.data
                    };
                },
                cache: true
            }
        });
        $('#filter_jenis').select2({
            ajax: {
                url: base_url + '/Admin/Data_master_jenis_barang/load_select2',
                type: "post",
                dataType: 'json',
                delay: 100,
                data: function(params) {
                    // CSRF Hash
                    var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                    var csrfHash = $('.txt_csrfname').val(); // CSRF hash

                    return {
                        searchTerm: params.term, // search term
                        [csrfName]: csrfHash // CSRF Token
                    };
                },
                processResults: function(response) {

                    // Update CSRF Token
                    $('.txt_csrfname').val(response.token);

                    return {
                        results: response.data
                    };
                },
                cache: true
            }
        });
    });

    function load_barang() {
        $('#tbl-barang').DataTable().ajax.reload();
    }

    function clear_form() {
        $('#id').val('');
        $('#nama').val('');
        $('#jenis').val('').change();
        $('#stok').val('');
        $('#harga').val('');
        $('#foto').val('');
        $('#if-nama-barang').html("");
        document.getElementById('nama').classList.remove('is-invalid');
        document.getElementById('jenis').classList.remove('is-invalid');
        document.getElementById('stok').classList.remove('is-invalid');
        document.getElementById('harga').classList.remove('is-invalid');
        $('#label-foto').text('');
    }

    function tambah() {
        clear_form();
        $('#title-modal').text('Tambah Barang');
        $('#modal').modal('show');
    }

    function cek_file_foto(id) {
        var cek = validasi_img_return(id);
        if (cek == 'format_salah') {
            $('#foto').val('');
            show_toastr('Format yang diperbolehkan hanya .jpg, .jpeg dan .png!', 'error', 'top-right');
            $('#if-foto').html('Format yang diperbolehkan hanya .jpg, .jpeg dan .png!');
            document.getElementById('foto').classList.add('is-invalid');
        } else if (cek == 'ukuran_file') {
            $('#foto').val('');
            show_toastr('Ukuran file terlalu besar! Maksimal 2MB.', 'error', 'top-right');
            $('#if-foto').html('Ukuran file terlalu besar! Maksimal 2MB.');
            document.getElementById('foto').classList.add('is-invalid');
        } else {
            $('#if-foto').html('');
            document.getElementById('foto').classList.remove('is-invalid');
        }
    }

    function cek_simpan() {
        var nama = $('#nama').val();
        var jenis = $('#jenis').val();
        var stok = $('#stok').val();
        var harga = $('#harga').val();

        if (nama != '' && jenis != '' && stok != '' && harga != '') {
            simpan();
        } else {
            if (nama == '') {
                $('#if-nama-barang').html("Nama Barang can't be null.");
                document.getElementById('nama').classList.add('is-invalid');
            } else {
                $('#if-nama-barang').html("");
                document.getElementById('nama').classList.remove('is-invalid');
            }
            if (jenis == '') {
                document.getElementById('jenis').classList.add('is-invalid');
            } else {
                document.getElementById('jenis').classList.remove('is-invalid');
            }
            if (stok == '') {
                document.getElementById('stok').classList.add('is-invalid');
            } else {
                document.getElementById('stok').classList.remove('is-invalid');
            }
            if (harga == '') {
                document.getElementById('harga').classList.add('is-invalid');
            } else {
                document.getElementById('harga').classList.remove('is-invalid');
            }
        }
    }

    function simpan() {
        var id = $('#id').val();
        var postData = new FormData($('#form-modal')[0]);

        $.ajax({
            type: "POST",
            url: base_url + '/Admin/Data_master_barang/simpan_barang',
            data: postData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                $('#btn-simpan').attr('disabled', true);
                $('#btn-simpan').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function(res) {
                if (res == 'success') {
                    load_barang();
                    $('#modal').modal('hide');
                    clear_form();

                    if (id != '') {
                        show_toastr('Barang berhasil diupdate!', 'success', 'top-right');
                    } else {
                        show_toastr('Barang berhasil disimpan!', 'success', 'top-right');
                    }
                } else {
                    show_toastr('Barang tersebut sudah ada!', 'error', 'top-right');
                    $('#if-nama-barang').html("Nama Barang sudah ada.");
                    document.getElementById('nama').classList.add('is-invalid');
                }
            },
            complete: function() {
                $('#btn-simpan').attr('disabled', false);
                $('#btn-simpan').html('Simpan');
            }
        });
    }

    function edit(id) {
        $.ajax({
            type: "GET",
            url: base_url + '/Admin/Data_master_barang/edit_barang/' + id,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                clear_form();

                $('#id').val(res.barang['id']);
                $('#nama').val(res.barang['nama_barang']);
                $("#jenis").select2("trigger", "select", {
                    data: {
                        id: res.jenis['id'],
                        text: res.jenis['jenis']
                    }
                });
                $('#jenis').val(res.barang['id_jenis_barang']).trigger('change');
                $('#stok').val(res.barang['stok']);
                $('#harga').val(res.barang['harga']);
                if (res.barang['foto_barang'] != null) {
                    $('#label-foto').text(res.barang['foto_barang']);
                }

                $('#title-modal').text('Edit Barang');
                $('#modal').modal('show');
            },
        });
    }

    function hapus(id) {
        Swal.fire({
            title: "Apakah anda yakin ingin menghapus barang?",
            text: "Data yang dihapus tidak dapat dipulihkan kembali",
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
                    url: base_url + '/Admin/Data_master_barang/hapus_barang/' + id,
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(res) {
                        swal.close();
                        load_barang();
                        show_toastr('Barang berhasil dihapus!', 'success', 'top-right');
                    },
                });
            } else if (result.isDenied) {
                swal.close();
                load_barang();
            }
        })

    }
</script>


<div class="modal fade" id="modal" role=" dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal">Form Jenis Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form-modal" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nama">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="">
                        <div class="invalid-feedback" id="if-nama-barang"></div>
                    </div>
                    <div class="form-group">
                        <label for="jenis">Jenis Barang <span class="text-danger">*</span></label>
                        <!-- CSRF token -->
                        <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <select name="jenis" id="jenis" class="form-control " style="width: 100%;">
                            <option value="">Select jenis Barang</option>
                        </select>
                        <div class="invalid-feedback">Jenis Barang can't be null.</div>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="stok" id="stok" min="1" max="1000" minlength="1" maxlength="4" value="1">
                        <div class="invalid-feedback">Stok can't be null.</div>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga <span class="text-danger">*</span></label>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp</div>
                            </div>
                            <input type="number" class="form-control" name="harga" id="harga" placeholder="">
                            <div class="invalid-feedback">Harga can't be null.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Barang</label>
                        <input type="file" class="form-control" name="foto" id="foto" accept="image/jpg,image/jpeg,image/png" onchange="cek_file_foto('foto')">
                        <div class="invalid-feedback" id="if-foto"></div>
                        <small id="label-foto"></small>
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