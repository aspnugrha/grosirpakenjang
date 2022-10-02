<script>
    var ekstensiIMG = /(\.jpg|\.jpeg|\.png)$/i;
    var ekstensiPDF = /(\.pdf)$/i;
    var ekstensiExcel = /(\.csv|\.xls|\.xlsx)$/i;

    function validasi_img_return(nama_file) {
        const foto = document.querySelector('#' + nama_file);

        if (!ekstensiIMG.exec(foto.value)) {
            var hasil = 'format_salah';
            return hasil;
        } else {
            if (foto.files && foto.files[0]) {
                if (foto.files[0].size < 2097152) {
                    var hasil = 'berhasil';
                    return hasil;
                } else {
                    var hasil = 'ukuran_file';
                    return hasil;
                }
            }
        }
    }

    function validasi_excel_return(nama_file) {
        const excel = document.querySelector('#' + nama_file);

        if (!ekstensiExcel.exec(excel.value)) {
            var hasil = 'format_salah';
            return hasil;
        } else {
            if (excel.files && excel.files[0]) {
                if (excel.files[0].size < 4194304) {
                    var hasil = 'berhasil';
                    return hasil;
                } else {
                    var hasil = 'ukuran_file';
                    return hasil;
                }
            }
        }
    }
</script>