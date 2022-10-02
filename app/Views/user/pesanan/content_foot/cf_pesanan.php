<script>
    $(document).ready(function() {

        cek_progres_pesanan();

        mainTable = [{
            data: "total-harga",
            visible: true,
            title: "Total Harga",
        }, ];

        mainTable.forEach((element) => {
            if (element.visible) {
                $('#tfooter tr').append('<td class="text-right" colspan="6"><h3 id="' + element.data + '" ></h3></td>')
            }
        })

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
            "searching": false,
            "pageLength": 25,
            'serverMethod': 'post',

            "ajax": {
                "url": base_url + '/User/Pesanan/load_pesanan',
                "type": "POST",
                dataType: 'json',

            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],

            initComplete: function(res) {
                console.log(res.json.total_harga);
                $('#total-harga').text('Total Harga : ' + res.json.total_harga);
            },
        });
    });

    function load_pesanan() {
        $('#tbl-pesanan').DataTable().ajax.reload();
    }

    function ubah_qty(id, no) {
        setTimeout(() => {
            var qty = $('#qty-keranjang-' + no).val();

            $.ajax({
                type: "POST",
                url: base_url + '/User/Keranjang/ubah_qty',
                data: {
                    id: id,
                    qty: qty,
                },
                beforeSend: function(e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function(res) {
                    load_pesanan();
                },
            });
        }, 500);
    }

    function hapus(id) {
        $.ajax({
            type: "GET",
            url: base_url + '/User/Keranjang/hapus_keranjang/' + id,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                $('#tbl-barang').DataTable().ajax.reload();
            },
        });
    }

    function pesan() {
        Swal.fire({
            title: "Apakah anda yakin ingin memesan?",
            text: "Pesanan anda akan diajukan ke admin, jika admin menyetujui maka pesanan akan segera diproses.",
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Ya, pesan',
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
                    url: base_url + '/User/Keranjang/pesan',
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(res) {
                        if (res == 'success') {
                            show_toastr('Pesanan andan telah diajukan!', 'success', 'top-right');
                            setTimeout(() => {
                                swal.close();
                                window.location = base_url + '/order';
                            }, 500);
                        } else if (res == 'pesanan_ada') {
                            show_toastr('Pesanan andan gagal diajukan! Anda masih memiliki pesanan yang belum selesai.', 'error', 'top-right');
                        } else if (res == 'keranjang_kosong') {
                            show_toastr('Anda belum memiliki barang dikeranjang!', 'error', 'top-right');
                        }
                    },
                });
            } else if (result.isDenied) {
                swal.close();
                load_pesanan();
            }
        })

    }

    function cek_progres_pesanan() {
        $.ajax({
            type: "GET",
            url: base_url + '/User/Pesanan/cek_progres_pesanan',
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                var progres = ['dipesan', 'dibatalkan', 'dikonfirmasi', 'dikemas', 'siap_diambil'];

                var html = '';

                // if (res.status == 'success') {
                var no = 0;

                progres.forEach(prog => {
                    if (res.status == 'success') {
                        var index = progres.indexOf(res.progres);

                        if (prog == 'dipesan') {
                            var tgl = res.tgl_dipesan;
                        } else if (prog == 'dibatalkan') {
                            var tgl = res.tgl_dibatalkan;
                        } else if (prog == 'dikonfirmasi') {
                            var tgl = res.tgl_dikonfirmasi;
                        } else if (prog == 'dikemas') {
                            var tgl = res.tgl_dikemas;
                        } else if (prog == 'siap_diambil') {
                            var tgl = res.tgl_siap_diambil;
                        }

                        if (prog == 'siap_diambil') {
                            var prog = 'siap diambil';
                        }

                        if (no <= index) {
                            if (index > 1) {
                                if (no == 1) {
                                    html += '<li style="font-size: 20px;">' +
                                        'Pesanan ' + prog +
                                        '</li>';
                                } else {
                                    html += '<li class="text-success font-weight-bold" style="font-size: 20px;list-style: disc;">' +
                                        'Pesanan  ' + prog + '<i class="fa fa-check-circle" style="font-size: 25px;"></i><br>' +
                                        '<small class="mb-2 text-muted" id="tgl-dipesan">' + tgl + '</small>' +
                                        '</li>';
                                }
                            } else {
                                html += '<li class="text-success font-weight-bold" style="font-size: 20px;list-style: disc;">' +
                                    'Pesanan  ' + prog + '<i class="fa fa-check-circle" style="font-size: 25px;"></i><br>' +
                                    '<small class="mb-2 text-muted" id="tgl-dipesan">' + tgl + '</small>' +
                                    '</li>';

                            }
                        } else {
                            html += '<li style="font-size: 20px;">' +
                                'Pesanan ' + prog +
                                '</li>';
                        }

                        if (index == 4) {
                            if (prog == 'siap diambil') {
                                html += '<br><div class="category-block" style="width: 500px;"><p style="font-size: 25px;font-weight: bold;">Kode Transaksi : ' + res.kode_transaksi + '</p></div> <br><label class="my-2" style="font-size: 18px;">Silahkan datang ke <b style="font-size: 20px;">Grosir Pak Enjang</b> lalu menuju ke <u><i>Pengambilan</i></u> dan tunjukan <u><i>Kode Transaksi</i></u> diatas ke bagain pengambilan.</label><br><br><br>';
                            }
                        }
                    }
                    no++;
                });
                $('#div-progres-pesanan').html(html);
                // }

                if (res.status == 'success') {
                    if (res.progres == 'dipesan') {
                        var html2 = '<button class="btn btn-danger" id="btn-batalkan-pesanan" onclick="batalkan_pesanan()"><i class="fa fa-close"></i> Batalkan Pesanan</button>';
                        $('#div-btn-aksi').html(html2);
                    }
                }

            },


        });
    }

    function batalkan_pesanan() {
        Swal.fire({
            title: "Apakah anda yakin ingin membatalkan pesanan?",
            text: "Pesanan dapat dibatalkan selama admin belum mengkonfirmasi pesanan.",
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Ya, batalkan pesanan',
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
                    url: base_url + '/User/Pesanan/batalkan_pesanan',
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(res) {
                        swal.close();
                        load_pesanan();
                        show_toastr('Pesanan dibatalkan!', 'success', 'top-right');
                    },
                });
            } else if (result.isDenied) {
                swal.close();
                load_pesanan();
            }
        })
    }
</script>