<div class="card card-default">
    <div class="card-header">
        <h2>Data User</h2>
    </div>
    <div class="card-body">

        <form id="form-filter">
            <?= csrf_field() ?>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-1 col-form-label">
                    <i class="h4 mdi mdi-filter-outline"></i>
                </label>
                <!-- <div class="col-sm-3">
                    <input type="text" class="form-control" name="filter_tgl" id="filter_tgl">
                </div> -->
                <!-- <div class="col-sm-3">
                    <select name="filter_urutan" id="filter_urutan" class="form-control">
                        <option value="">Select Order</option>
                        <option value="a-z">A-Z</option>
                        <option value="a-z">Z-A</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="filter_search" id="filter_search" placeholder="Search">
                </div> -->
                <div class="col-sm-3">
                    <select name="filter_role" id="filter_role" class="form-control" onchange="load_user()">
                        <option value="">Select Role</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="filter_search" id="filter_search" placeholder="Search Email" onkeyup="load_user()">
                </div>
            </div>
            <div class="form-group row">
            </div>
        </form>

        <table id="tbl-user" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>