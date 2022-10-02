<script>
    $(document).ready(function() {

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

        $('#tbl-keranjang').DataTable({
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
                "url": base_url + '/User/Keranjang/load_keranjang',
                "type": "POST",

            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],
            initComplete: function(res) {
                $('#total-harga').text('Total Harga : ' + res.json.total_harga);
            },
        });
    });

    function load_keranjang() {
        $('#tbl-keranjang').DataTable().ajax.reload();
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
                    load_keranjang();
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
                load_keranjang();
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
                load_keranjang();
            }
        })

    }
</script>