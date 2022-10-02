<script>
    $(document).ready(function() {
        $('#filter_tgl').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            },
        });

        $('#filter_tgl').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('#filter_tgl').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        // $('#filter_tgl').daterangepicker();
        $('#filter_tgl').on('apply.daterangepicker', (e, picker) => {
            cek_bandingkan();
        });


        load_jenis_barang1();
        $('#jenis_barang2').select2();

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


    function load_jenis_barang1() {
        $('#jenis_barang1').select2({
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
    }

    function load_jenis_barang2() {
        var jb1 = $('#jenis_barang1').val();

        $('#jenis_barang2').select2({
            ajax: {
                url: base_url + '/Admin/Data_master_jenis_barang/load_select22/' + jb1,
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
    }

    function cek_bandingkan() {
        var jb1 = $('#jenis_barang1').val();
        var jb2 = $('#jenis_barang2').val();

        if (jb1 != '' && jb2 != '') {
            bandingkan();
        }
    }

    function bandingkan() {
        var filter_tgl = $('#filter_tgl').val();
        var jb1 = $('#jenis_barang1').val();
        var jb2 = $('#jenis_barang2').val();

        $.ajax({
            type: "POST",
            url: base_url + '/Admin/Bandingkan/bandingkan',
            data: {
                filter_tgl: filter_tgl,
                jb1: jb1,
                jb2: jb2,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                $('#div-loading').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function(res) {
                var html1 = '';
                var html2 = '';
                var ul1 = '';
                var ul2 = '';

                if (res.hitung_jb1 > 0) {

                    var li1 = '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 py-2">' +
                        '<h5 class="text-right">Total : </h5>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 py-2 text-danger" style="font-size: 18px;font-weight: bold;">' + res.total_terjual_jb1 + '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 py-2 text-danger" style="font-size: 18px;font-weight: bold;">' + res.total_nominal_jb1 + '</div>' +
                        '</div>' +
                        '</li>';

                    res.jb1.forEach(jb1 => {

                        ul1 += '<li>' +
                            '<div class="row">' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb1['barang']['nama_barang'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb1['terjual'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb1['nominal_terjual'] + '</div>' +
                            '</div>' +
                            '</li>';
                    });

                    html1 += '<div class="card">' +
                        '<div class="card-body">' +
                        '<h5 class="my-2">Data Barang</h5>' +
                        '<ul>' +
                        '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 my-2"><p class="text-dark" style="font-size: 17px;">Barang</p></div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 my-2"><p class="text-dark" style="font-size: 17px;">Terjual</p></div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 my-2"><p class="text-dark" style="font-size: 17px;">Total</p></div>' +
                        '</div>' +
                        '</li>' +
                        ul1 +
                        li1 +
                        '</ul>' +
                        '</div>' +
                        '</div>';

                }
                if (res.hitung_jb2 > 0) {

                    var li2 = '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 py-2">' +
                        '<h5 class="text-right">Total : </h5>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 py-2 text-danger" style="font-size: 18px;font-weight: bold;">' + res.total_terjual_jb2 + '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 py-2 text-danger" style="font-size: 18px;font-weight: bold;">' + res.total_nominal_jb2 + '</div>' +
                        '</div>' +
                        '</li>';

                    res.jb2.forEach(jb2 => {

                        ul2 += '<li>' +
                            '<div class="row">' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb2['barang']['nama_barang'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb2['terjual'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb2['nominal_terjual'] + '</div>' +
                            '</div>' +
                            '</li>';
                    });

                    html2 += '<div class="card">' +
                        '<div class="card-body">' +
                        '<h5 class="my-2">Data Barang</h5>' +
                        '<ul>' +
                        '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 my-2"><p class="text-dark" style="font-size: 17px;">Barang</p></div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 my-2"><p class="text-dark" style="font-size: 17px;">Terjual</p></div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4 my-2"><p class="text-dark" style="font-size: 17px;">Total</p></div>' +
                        '</div>' +
                        '</li>' +
                        ul2 +
                        li2 +
                        '</ul>' +
                        '</div>' +
                        '</div>';

                }

                $('#div-detail-jb1').html(html1);
                $('#div-detail-jb2').html(html2);
                console.log(res);
            },
            complete: function() {
                $('#div-loading').html('');
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
                    <input type="text" name="id" id="id">
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