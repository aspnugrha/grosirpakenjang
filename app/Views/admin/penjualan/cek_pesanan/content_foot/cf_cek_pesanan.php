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

        $('#filter_tgl').on('apply.daterangepicker', (e, picker) => {
            load_pesanan();
        });

        $('#tbl-pesanan').DataTable({
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
            "pageLength": 10,
            'serverMethod': 'post',

            "ajax": {
                "url": base_url + '/Admin/Pesanan/load_pesanan',
                "type": "POST",
                dataType: 'json',
                "data": function(data) {
                    data.tgl = $('#filter_tgl').val();
                    data.urutan = $('#filter_urutan').val();
                },

            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],

        });


    });

    function load_pesanan() {
        $('#tbl-pesanan').DataTable().ajax.reload();
    }

    function clear_form() {
        $('#id').val('');
        $('#if-nama-barang').html("");
        document.getElementById('nama').classList.remove('is-invalid');
    }

    function lihat_pesanan(id_akun) {
        $.ajax({
            type: "GET",
            url: base_url + '/Login/get_user/' + id_akun,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                if (res['profile'] != null) {
                    $('#div-profile').html('<img src="/assets/upload/admin/profile/' + res['profile'] + '" class="mr-3 img-fluid rounded" style="width: 150px;">');
                } else {
                    $('#div-profile').html('<i class="mdi mdi-account-circle-outline" style="padding: 0px 10px 0px 10px;font-size: 120px;"></i>');
                }

                $('#id-akun').val(id_akun);
                $('#nama-lengkap').text(res['nama_lengkap']);
                $('#email').text(res['email']);
                if (res['hp'] != null) {
                    $('#hp').text(res['hp']);
                } else {
                    $('#hp').text('-');
                }

                load_list_pesanan(id_akun);

                $('#modal').modal('show');
            },
        });

    }

    function load_list_pesanan(id_akun) {

        $('#tbl-list-pesanan').DataTable().destroy();

        $('#tbl-list-pesanan').DataTable({
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
            "pageLength": 10,
            'serverMethod': 'post',

            "ajax": {
                "url": base_url + '/Admin/Pesanan/load_list_pesanan',
                "type": "POST",
                "data": function(data) {
                    // data.tgl = $('#filter_tgl').val();
                    data.id_akun = id_akun;
                },
            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],
            // initComplete: function(res) {
            //     $('#total-harga').text('Total Harga : ' + res.json.total_harga);
            // },
        });

        cek_total_harga(id_akun);
    }

    function cek_total_harga(id_akun) {
        $.ajax({
            type: "GET",
            url: base_url + '/Admin/Pesanan/cek_total_harga/' + id_akun,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                console.log(res);
                $('#td-total-harga').html('<h3 class="text-right">Total : ' + res + '</h3>');
            },
        });
    }

    function konfirmasi_pesanan() {
        var id_akun = $('#id-akun').val();

        Swal.fire({
            title: "Apakah anda yakin ingin mengkonfirmasi pesanan?",
            text: "Setelah pesanan dikonfirmasi harap segera mengemas dan mempersiapkan barang",
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Ya Konfirmasi',
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
                    url: base_url + '/Admin/Pesanan/konfirmasi_pesanan/' + id_akun,
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                        $('#btn-konfirmasi-pesanan').attr('disabled', true);
                        $('#btn-konfirmasi-pesanan').html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
                    },
                    success: function(res) {
                        swal.close();
                        $('#modal').modal('hide');
                        load_pesanan();
                        show_toastr('Pesanan dikonfirmasi!', 'success', 'top-right');
                    },
                    complete: function() {
                        $('#btn-konfirmasi-pesanan').attr('disabled', false);
                        $('#btn-konfirmasi-pesanan').html('Konfirmasi Pesanan');
                    }
                });
            } else if (result.isDenied) {
                swal.close();
                load_list_pesanan(id_akun);
            }
        })

    }
</script>


<div class="modal fade" id="modal" role=" dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal">List Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card card-default p-4">
                    <div class="media">
                        <div id="div-profile"></div>

                        <div class="media-body">
                            <input type="hidden" name="id-akun" id="id-akun">
                            <h5 class="mt-0 mb-2 text-dark" id="nama-lengkap" style="font-size: 35px;font-weight: bold;"></h5>
                            <ul class="list-unstyled text-smoke text-smoke">
                                <li class="d-flex">
                                    <i class="mdi mdi-email-outline"></i>&nbsp;
                                    <span class="mr-4" id="email"></span>
                                </li>
                                <li class="d-flex">
                                    <i class="mdi mdi-phone"></i>&nbsp;
                                    <span id="hp"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <b class="my-2">Pesanan</b>
                    <table id="tbl-list-pesanan" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Barang</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot id="tfooter">
                            <tr>
                                <td colspan="5" id="td-total-harga"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-pill" id="btn-konfirmasi-pesanan" onclick="konfirmasi_pesanan()">Konfirmasi Pesanan</button>
            </div>
        </div>
    </div>
</div>