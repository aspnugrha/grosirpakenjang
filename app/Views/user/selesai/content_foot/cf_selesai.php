<script>
    $(document).ready(function() {

        // mainTable = [{
        //     data: "total-harga",
        //     visible: true,
        //     title: "Total Harga",
        // }, ];

        // mainTable.forEach((element) => {
        //     if (element.visible) {
        //         $('#tfooter tr').append('<td class="text-right" colspan="6"><h3 id="' + element.data + '" ></h3></td>')
        //     }
        // })

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
                "url": base_url + '/User/Selesai/load_pesanan_selesai',
                "type": "POST",
                dataType: 'json',

            },

            "columnDefs": [{
                "targets": [-1],
                "orderable": true,
            }, ],

            // initComplete: function(res) {
            //     // console.log(res.json.total_harga);
            //     $('#total-harga').text('Total Harga : ' + res.json.total_harga);
            // },
        });
    });

    function load_pesanan() {
        $('#tbl-pesanan').DataTable().ajax.reload();
    }

    function lihat_pesanan(id) {
        load_list_pesanan_selesai(id);
        $('#modal').modal('show');
    }

    function load_list_pesanan_selesai(id) {

        $('#tbl-list-pesanan-selesai').DataTable().destroy();

        $('#tbl-list-pesanan-selesai').DataTable({
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
                "url": base_url + '/User/Selesai/load_list_pesanan_selesai',
                "type": "POST",
                "data": function(data) {
                    // data.tgl = $('#filter_tgl').val();
                    data.id_pesanan = id;
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

        cek_total_harga(id);
    }

    function cek_total_harga(id) {
        $.ajax({
            type: "GET",
            url: base_url + '/User/Selesai/cek_total_harga_selesai/' + id,
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

                <div class="table-responsive">
                    <b class="my-2">Pesanan</b>
                    <table id="tbl-list-pesanan-selesai" class="table table-striped" style="width:100%">
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
                <!-- <button type="button" class="btn btn-primary btn-pill" id="btn-konfirmasi-pesanan" onclick="konfirmasi_pesanan()">Konfirmasi Pesanan</button> -->
            </div>
        </div>
    </div>
</div>