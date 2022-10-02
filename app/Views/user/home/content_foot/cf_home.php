<script>
    $(document).ready(function() {
        load_barang();

        // $('#filter_jenis').select2({
        //     ajax: {
        //         url: base_url + '/Admin/Data_master_jenis_barang/load_select2',
        //         type: "post",
        //         dataType: 'json',
        //         delay: 100,
        //         data: function(params) {
        //             // CSRF Hash
        //             var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
        //             var csrfHash = $('.txt_csrfname').val(); // CSRF hash

        //             return {
        //                 searchTerm: params.term, // search term
        //                 [csrfName]: csrfHash // CSRF Token
        //             };
        //         },
        //         processResults: function(response) {

        //             // Update CSRF Token
        //             $('.txt_csrfname').val(response.token);

        //             return {
        //                 results: response.data
        //             };
        //         },
        //         cache: true
        //     }
        // });
    });

    function load_barang() {
        var jenis = $('#filter_jenis').val();
        var search = $('#filter_search').val();
        var urutan = $('#filter_urutan').val();

        $.ajax({
            type: "POST",
            url: base_url + '/User/Home/load_barang',
            data: {
                jenis: jenis,
                search: search,
                urutan: urutan,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                var html = '';

                if (res.hitung > 0) {
                    res.barang.forEach(b => {
                        if (b['foto_barang'] != null) {
                            var foto_barang = '<img class="card-img-top img-fluid img-tetap" src="/assets/upload/admin/foto_barang/' + b['foto_barang'] + '" >';
                        } else {
                            var foto_barang = '<img class="card-img-top img-fluid img-tetap" src="/assets/img/kosong/img-kosong.jpg" >';
                        }

                        html += '<div class="col-lg-3 col-md-4 col-sm-6">' +
                            '<div class="product-item bg-light">' +
                            '<div class="card">' +
                            '<div class="thumb-content">' +
                            foto_barang +
                            '</div>' +
                            '<div class="card-body">' +
                            '<h4 class="card-title"><a href="single.html">' + b['nama_barang'] + '</a></h4>' +
                            '<ul class="list-inline product-meta">' +
                            '<li class="list-inline-item">' +
                            '<i class="fa fa-list-ol"></i> ' + b['jenis'] +
                            '</li>' +
                            '<li class="list-inline-item">' +
                            '<i class="fa fa-archive"></i> ' + b['stok'] +
                            '</li>' +
                            '</ul>' +
                            '<h4 class="card-text">' + res.harga[b['id']] + '</h4>' +
                            '<div class="btn-group mt-3 mb-4 w-100" role="group" aria-label="Basic example">' +
                            '<button type="button" class="btn btn-outline-primary btn-sm w-100" style="padding-top: 6px;padding-bottom: 6px;" onclick="tambah_keranjang(' + b['id'] + ')"><i class="mdi mdi-cart" style="font-size: 30px;"></i></button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +

                            '</div>';
                    });
                }

                $('#div-list-barang').html(html);
                $('#total-barang').html('<b>Total</b> : ' + res.hitung + ' Items');
            },
        });
    }

    function clear_modal() {
        var id_barang = $('#id_barang').val('');
        var qty = $('#qty').val(1);
    }

    function tambah_keranjang(id) {
        $.ajax({
            type: "POST",
            url: base_url + '/Admin/Data_master_barang/edit_barang/' + id,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                clear_modal();
                $('#id_barang').val(id);

                if (res.barang['foto_barang'] != null) {
                    $('#div-foto-barang-db').html('<img src="/assets/upload/admin/foto_barang/' + res.barang['foto_barang'] + '" class="mr-3 img-fluid rounded" style="width: 150px;">');
                } else {
                    $('#div-foto-barang-db').html('<img class="mr-3 rounded img-fluid" style="width: 150px;" src="/assets/img/kosong/img-kosong.jpg" >');
                }

                $('#nama-barang-db').text(res.barang['nama_barang']);
                $('#jenis-db').text(res.jenis['jenis']);
                $('#stok-db').text(res.barang['stok']);
                $('#harga-db-input').val(res.barang['harga']);
                $('#harga-db').html(res.harga);

                cek_total_harga2();
                $('#modal').modal('show');
            },
        });
    }

    function cek_total_harga2() {
        var harga = $('#harga-db-input').val();
        var qty = $('#qty').val();

        cek_total_harga(harga, qty);
    }

    function cek_total_harga(harga, qty) {
        $.ajax({
            type: "POST",
            url: base_url + '/User/Home/cek_total_harga',
            data: {
                harga: harga,
                qty: qty,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                var total = 'Total : ';
                total += res;
                $('#total-harga').text(total);
            },
        });
    }

    function cek_keranjang() {
        var id = $('#id_barang').val();
        var qty = $('#qty').val();

        if (qty > 0) {
            keranjang();
        } else {
            alert('Jumlah harus lebih dari 0');
        }
    }

    function keranjang() {
        var id = $('#id_barang').val();
        var qty = $('#qty').val();

        $.ajax({
            type: "POST",
            url: base_url + '/User/Keranjang/tambah_keranjang',
            data: {
                id: id,
                qty: qty,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                $('#btn-keranjang').attr('disabled', true);
                $('#btn-keranjang').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function(res) {
                if (res == 'success') {
                    $('#modal').modal('hide');
                    show_toastr('Barang dimasukan ke keranjang!', 'success', 'top-right');
                } else if (res == 'stok_kurang') {
                    show_toastr('Jumlah barang melebihi stok!', 'error', 'top-right');
                } else {
                    show_toastr('Silahkan login terlebih dahulu!', 'error', 'top-right');
                    setTimeout(() => {
                        $('#modal').modal('hide');
                        window.location = base_url + '/login';
                    }, 1500);
                }
            },
            complete: function() {
                $('#btn-keranjang').attr('disabled', false);
                $('#btn-keranjang').html('Tambah Ke Keranjang');
            }
        });
    }
</script>


<div class="modal fade" id="modal" role=" dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal">Tambah Ke Keranjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card card-default p-4">
                    <div class="media">
                        <div id="div-foto-barang-db"></div>

                        <div class="media-body">
                            <h5 class="mt-0 mb-2 text-dark" id="nama-barang-db"></h5>
                            <ul class="list-unstyled text-smoke text-smoke">
                                <li class="d-flex">
                                    <i class="fa fa-list-ol"></i>
                                    <span class="mr-4" id="jenis-db"></span>
                                    <i class="fa fa-archive"></i>
                                    <span id="stok-db"></span>
                                </li>
                                <li class="d-flex">
                                </li>
                                <li class="d-flex">
                                    <input type="hidden" name="harga-db-input" id="harga-db-input">
                                    <p class="card-text h4" id="harga-db"></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <form class="mt-3" id="form-modal">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_barang" id="id_barang">
                    <div class="form-group">
                        <label for="stok">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="qty" id="qty" value="1" min="1" max="1000" minlength="1" maxlength="4" oninput="cek_total_harga2()">
                        <div class="invalid-feedback">Jumlah can't be null.</div>
                    </div>
                    <div class="form-group text-right">
                        <h4 id="total-harga">Total : </h4>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-pill" id="btn-keranjang" onclick="cek_keranjang()">Tambah Ke Keranjang</button>
            </div>
        </div>
    </div>
</div>