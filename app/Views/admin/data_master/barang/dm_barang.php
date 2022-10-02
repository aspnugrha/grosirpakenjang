<div class="card card-default">
    <div class="card-header">
        <h2>Data Barang</h2>
    </div>
    <div class="card-body">

        <button class="btn btn-success mb-3" onclick="tambah()"><i class="mdi mdi-plus"></i> Tambah Barang</button>

        <form id="form-filter">
            <?= csrf_field() ?>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-1 col-form-label">
                    <i class="h4 mdi mdi-filter-outline"></i>
                </label>
                <!-- <div class="col-sm-3">
                    <input type="text" class="form-control" name="filter_tgl" id="filter_tgl">
                </div> -->
                <div class="col-sm-3">
                    <select name="filter_urutan" id="filter_urutan" class="form-control" onchange="load_barang()">
                        <option value="">Select Order</option>
                        <option value="a-z">Sortir dari A ke Z</option>
                        <option value="z-a">Sortir dari Z ke A</option>
                        <option value="terbaru">Sortir dari terbaru ke terlama</option>
                        <option value="terlama">Sortir dari terlama ke terbaru</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="filter_jenis" id="filter_jenis" class="form-control" onchange="load_barang()">
                        <option value="">Select Jenis Barang</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="filter_search" id="filter_search" placeholder="Search" onkeyup="load_barang()">
                </div>
            </div>
            <div class="form-group row">
            </div>
        </form>

        <table id="tbl-barang" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Barang</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>