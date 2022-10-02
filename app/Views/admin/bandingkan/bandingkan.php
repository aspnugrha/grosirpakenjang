<div class="card card-default">
    <div class="card-header">
        <h2>Bandingkan Barang</h2>
    </div>
    <div class="card-body">

        <form id="form-filter">
            <?= csrf_field() ?>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-1 col-form-label">
                    <i class="h4 mdi mdi-filter-outline"></i>
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="filter_tgl" id="filter_tgl" onselect="cek_bandingkan()">
                </div>
            </div>
        </form>

        <div class="mt-5 mb-5 row" id="div-pembandingan">
            <div class="col-lg-5 col-md-5">
                <div class="form-group">
                    <label for="jenis_barang1">Jenis Barang 1</label>
                    <select name="jenis_barang1" id="jenis_barang1" class="form-control" onchange="load_jenis_barang2()">
                        <option value="">Select Jenis Barang</option>
                    </select>
                </div>

                <div class="mt-3" id="div-detail-jb1"></div>
            </div>
            <div class="col-lg-2 col-md-2">
                <h1 style="margin-top: 60px;">
                    <center>VS</center>
                </h1>
            </div>
            <div class="col-lg-5 col-md-5">
                <div class="form-group">
                    <label for="jenis_barang2">Jenis Barang 2</label>
                    <select name="jenis_barang2" id="jenis_barang2" class="form-control" onchange="bandingkan()">
                        <option value="">Select Jenis Barang</option>
                    </select>
                    <!-- <span class="mt-2 d-block">We'll never share your email with anyone else.</span> -->
                </div>

                <div class="mt-3" id="div-detail-jb2">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <center>
                    <div id="div-loading"></div>
                </center>
            </div>
        </div>
    </div>

</div>