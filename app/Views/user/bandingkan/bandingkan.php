<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="heading text-center text-capitalize font-weight-bold py-5">
                <h2 class="py-2">Bandingkan Dua Jenis Barang</h2>
            </div>
        </div>
        <div class="col-lg-12">
            <form class="pb-4" id="form-filter">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-1 col-form-label">
                        <i class="h4 mdi mdi-filter-outline"></i>
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="filter_tgl" id="filter_tgl" placeholder="Filter range Tanggal" onselect="cek_bandingkan()">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-5 col-sm-5">

            <div class="form-group">
                <h4 for="jenis_barang1">
                    <center>Jenis Barang 1</center>
                </h4>
                <select name="jenis_barang1" id="jenis_barang1" class="form-control w-100 my-2" onchange="load_jenis_barang2()">
                    <option value="">Select Jenis Barang</option>
                    <?php foreach ($jenis_barang as $jb) { ?>
                        <option value="<?= $jb['id'] ?>"><?= $jb['jenis'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mt-3" id="div-detail-jb1">

            </div>

        </div>
        <div class="col-lg-2 col-sm-2">
            <h1 class="pt-5">
                <center>VS</center>
            </h1>
        </div>
        <div class="col-lg-5 col-sm-5">

            <div class="form-group">
                <h4 for="jenis_barang2">
                    <center>Jenis Barang 2</center>
                </h4>
                <select name="jenis_barang2" id="jenis_barang2" class="form-control w-100 my-2" onchange="bandingkan()">
                    <option value="">Select Jenis Barang</option>

                </select>
                <!-- <span class="mt-2 d-block">We'll never share your email with anyone else.</span> -->
            </div>

            <div class="mt-3" id="div-detail-jb2">

            </div>

        </div>

    </div>
    <br><br><br>
</div>