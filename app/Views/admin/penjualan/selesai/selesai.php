<div class="card card-default">
    <div class="card-header">
        <h2>Data Pesanan</h2>
    </div>
    <div class="card-body">

        <form id="form-filter">
            <?= csrf_field() ?>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-1 col-form-label">
                    <i class="h4 mdi mdi-filter-outline"></i>
                </label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="filter_tgl" id="filter_tgl" placeholder="Filter Range Tanggal">
                </div>
                <div class="col-sm-3">
                    <select name="filter_urutan" id="filter_urutan" class="form-control" onchange="load_selesai()">
                        <option value="">Select Order</option>
                        <option value="a-z">Sortir dari A ke Z</option>
                        <option value="z-a">Sortir dari Z ke A</option>
                        <option value="terbaru">Sortir dari terbaru ke terlama</option>
                        <option value="terlama">Sortir dari terlama ke terbaru</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
            </div>
        </form>

        <table id="tbl-selesai" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Pesanan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>