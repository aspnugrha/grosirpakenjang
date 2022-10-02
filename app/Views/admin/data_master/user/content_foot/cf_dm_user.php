<script>
    $(document).ready(function() {
        // $('#filter_tgl').daterangepicker();

        $('#tbl-user').DataTable({
            drawCallback: function() {
                $('.example-popover').popover({
                    html: true,
                    sanitize: false,
                    // content: function() {
                    //     var content = $(this).attr("data-popover-content");
                    //     return $(content).children(".popover-body").html();
                    // },
                    // title: function() {
                    //     var title = $(this).attr("data-popover-content");
                    //     return $(title).children(".popover-heading").html();
                    // }
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
                "url": base_url + '/a/data_master/ajax/load_user',
                "type": "POST",
                dataType: 'json',
                "data": function(data) {
                    data.role = $('#filter_role').val();
                    data.search = $('#filter_search').val();
                },

            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],

        });
    });

    function load_user() {
        $('#tbl-user').DataTable().ajax.reload();
    }

    function ubah_role(id, no) {
        Swal.fire({
            title: "Apakah anda yakin ingin mengubah role?",
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
                var role = $('#role_' + no).val();

                $.ajax({
                    type: "POST",
                    url: base_url + '/a/data_master/ajax/ubah_role',
                    data: {
                        id: id,
                        role: role,
                    },
                    beforeSend: function(e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function(res) {
                        swal.close();
                        load_user();
                        show_toastr('Role berhasil diupdate!', 'success', 'top-right');
                    },
                });
            } else if (result.isDenied) {
                swal.close();
                load_user();
            }
        })

    }

    function ubah_aktif(id, val) {
        $.ajax({
            type: "GET",
            url: base_url + '/a/data_master/ajax/ubah_aktif/' + id,
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(res) {
                load_user();
                if (val == 'on') {
                    show_toastr('Akun Nonaktif!', 'success', 'top-right');
                } else {
                    show_toastr('Akun Aktif!', 'success', 'top-right');
                }
            },
        });
    }
</script>