<section class="hero-area bg-1 text-center overly">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Header Contetnt -->
                <div class="content-block">
                    <h1>Web Pemesanan Belanja <br> Online!</h1>
                    <p>Lakukan pemesanan online datang ke tempat, tinggal bayar dan ambil!</p>

                </div>
                <!-- Advance Search -->
                <div class="advance-search">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12 col-md-12 align-content-center">
                                <form id="form-filter">
                                    <?= csrf_field() ?>
                                    <div class="form-row">
                                        <div class="form-group col-lg-5 col-md-6">
                                            <select class="w-100 form-control mt-lg-1 mt-md-2" name="filter_jenis" id="filter_jenis" onchange="load_barang()">
                                                <option value="">Select Jenis Barang</option>
                                                <?php foreach ($jenis_barang as $jb) { ?>
                                                    <option value="<?= $jb['id'] ?>"><?= $jb['jenis'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-xl-5 col-lg-5 col-md-6">
                                            <input type="text" class="form-control my-2 my-lg-1" name="filter_search" id="filter_search" placeholder="Cari Barang" onkeyup="load_barang()">
                                        </div>
                                        <div class="form-group col-xl-2 col-lg-2 col-md-6 align-self-center">
                                            <a class="btn btn-primary active w-100" id="btn-search" onclick="load_barang()"><i class="mdi mdi-magnify"></i> Cari</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container End -->
</section>


<section class="popular-deals section bg-gray" style="padding: 50px;">
</section>

<div class="container mb-5">
    <div class="row">
        <div class="col-lg-12 col-md-12 ">
            <div class="category-search-filter bg-white">
                <div class="row">
                    <div class="col-md-6 text-center text-md-left">
                        <strong>Short</strong>
                        <select name="filter_urutan" id="filter_urutan" onchange="load_barang()">
                            <option>Most Recent</option>
                            <!-- <option value="">Select Order</option> -->
                            <option value="a-z">Sortir dari A ke Z</option>
                            <option value="z-a">Sortir dari Z ke A</option>
                            <option value="terbaru">Sortir dari terbaru ke terlama</option>
                            <option value="terlama">Sortir dari terlama ke terbaru</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-center text-md-right mt-2 mt-md-0">
                        <div class="view">
                            <small id="total-barang"></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-grid-list">
                <div class="row mt-30" id="div-list-barang">
                </div>
            </div>
        </div>
    </div>
</div>