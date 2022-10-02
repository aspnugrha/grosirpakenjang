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

                    res.jb1.forEach(jb1 => {

                        ul1 += '<li>' +
                            '<div class="row">' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb1['barang']['nama_barang'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb1['terjual'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb1['nominal_terjual'] + '</div>' +
                            '</div>' +
                            '</li>';
                    });

                    html1 += '<div class="category-block">' +
                        '<div class="header">' +
                        '<h4>Electronics</h4>' +
                        '</div>' +
                        '<ul class="category-list">' +
                        '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>Barang</b>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>Terjual</b>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>Nominal</b>' +
                        '</div>' +
                        '</div>' +
                        '</li>' +
                        ul1 +
                        '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<p class="text-right"><b>Total : </b></p>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4"><b>' + res.total_terjual_jb1 + '</b></div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>' + res.total_nominal_jb1 + '</b>' +
                        '</div>' +
                        '</div>' +
                        '</li>' +
                        '</ul>' +
                        '</div>';

                }
                if (res.hitung_jb2 > 0) {

                    res.jb2.forEach(jb2 => {

                        ul2 += '<li>' +
                            '<div class="row">' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb2['barang']['nama_barang'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb2['terjual'] + '</div>' +
                            '<div class="col-lg-4 col-md-4 col-sm-4">' + jb2['nominal_terjual'] + '</div>' +
                            '</div>' +
                            '</li>';
                    });

                    html2 += '<div class="category-block">' +
                        '<div class="header">' +
                        '<h4>Electronics</h4>' +
                        '</div>' +
                        '<ul class="category-list">' +
                        '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>Barang</b>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>Terjual</b>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>Nominal</b>' +
                        '</div>' +
                        '</div>' +
                        '</li>' +
                        ul2 +
                        '<li>' +
                        '<div class="row">' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<p class="text-right"><b>Total : </b></p>' +
                        '</div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4"><b>' + res.total_terjual_jb2 + '</b></div>' +
                        '<div class="col-lg-4 col-md-4 col-sm-4">' +
                        '<b>' + res.total_nominal_jb2 + '</b>' +
                        '</div>' +
                        '</div>' +
                        '</li>' +
                        '</ul>' +
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
</script>