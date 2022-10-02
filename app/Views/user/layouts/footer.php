<footer class="footer section section-sm">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7 offset-md-1 offset-lg-0 mb-4 mb-lg-0">
                <!-- About -->
                <div class="block about">
                    <!-- footer logo -->
                    <!-- <img src="images/logo-footer.png" alt="logo"> -->
                    <!-- description -->
                    <p class="alt-color">
                        Web <b>Grosir Pak Enjang</b> adalah tempat untuk memesan sembako ataupun kebutuhan sehari-hari secara online. Web ini hadir untuk mempermudah mitra kerja ataupun langganan dari Grosir Pak Enjang agar dapat bertransaksi dengan mudah dan cepat. Bergabung bersama kami dan rasakan kemudahan berbelanja dengan cepat dan efisien.
                    </p>
                </div>
            </div>
            <!-- Link list -->
            <div class="col-lg-3 offset-lg-1 col-md-3 col-6 mb-4 mb-lg-0">
                <div class="block">
                    <h4>Others Pages</h4>
                    <ul>
                        <!-- <li><a href="/about-us">About Us</a></li>
                        <li><a href="/faq">FAQ</a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Container End -->
</footer>
<!-- Footer Bottom -->
<footer class="footer-bottom">
    <!-- Container Start -->
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left mb-3 mb-lg-0">
                <!-- Copyright -->
                <div class="copyright">
                    <p>Copyright &copy; <script>
                            var CurrentYear = new Date().getFullYear()
                            document.write(CurrentYear)
                        </script>. Designed & Developed by <a class="text-white" href="https://themefisher.com">Themefisher</a></p>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Social Icons -->
                <ul class="social-media-icons text-center text-lg-right">
                    <li><a class="fa fa-facebook" href="https://www.facebook.com/themefisher"></a></li>
                    <li><a class="fa fa-twitter" href="https://www.twitter.com/themefisher"></a></li>
                    <li><a class="fa fa-pinterest-p" href="https://www.pinterest.com/themefisher"></a></li>
                    <li><a class="fa fa-github-alt" href="https://www.github.com/themefisher"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Container End -->
    <!-- To Top -->
    <div class="scroll-top-to">
        <i class="fa fa-angle-up"></i>
    </div>
</footer>

<script src="/assets/template/user/plugins/jquery/jquery.min.js"></script>
<script src="/assets/template/user/plugins/bootstrap/popper.min.js"></script>
<script src="/assets/template/user/plugins/bootstrap/bootstrap.min.js"></script>
<script src="/assets/template/user/plugins/bootstrap/bootstrap-slider.js"></script>
<script src="/assets/template/user/plugins/tether/js/tether.min.js"></script>
<script src="/assets/template/user/plugins/raty/jquery.raty-fa.js"></script>
<script src="/assets/template/user/plugins/slick/slick.min.js"></script>
<script src="/assets/template/user/plugins/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<!-- google map -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
<script src="/assets/template/user/plugins/google-map/map.js" defer></script>

<!-- <script src="/assets/template/user/js/script.js"></script> -->
<script src="/assets/template/admin/plugins/toaster/toastr.min.js"></script>
<script src="/assets/template/admin/plugins/select2/js/select2.min.js"></script>
<script src="/assets/template/admin/plugins/nice-select2/js/nice-select2.min.js"></script>
<script src="/assets/template/admin/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.35/sweetalert2.min.js"></script>

<script src="/assets/template/admin/plugins/daterangepicker/moment.min.js"></script>
<script src="/assets/template/admin/plugins/daterangepicker/daterangepicker.js"></script>

<script>
    var base_url = '<?= base_url() ?>';
</script>

<?php
if (count($content_foot) > 0) {
    foreach ($content_foot as $cf) {
        echo view($cf);
    }
}
?>

</body>

</html>