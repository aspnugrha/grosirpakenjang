<!-- Footer -->
<footer class="footer mt-auto">
    <div class="copyright bg-white">
        <p>
            &copy; <span id="copy-year"></span> Copyright Mono Dashboard Bootstrap Template by <a class="text-primary" href="http://www.iamabdus.com/" target="_blank">Abdus</a>.
        </p>
    </div>
    <script>
        var d = new Date();
        var year = d.getFullYear();
        document.getElementById("copy-year").innerHTML = year;
    </script>
</footer>

</div>
</div>


<script src="/assets/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/assets/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/template/admin/plugins/simplebar/simplebar.min.js"></script>
<script src="/assets/template/admin/https://unpkg.com/hotkeys-js/dist/hotkeys.min.js"></script>



<script src="/assets/template/admin/plugins/apexcharts/apexcharts.js"></script>



<script src="/assets/template/admin/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>



<script src="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script src="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
<script src="/assets/template/admin/plugins/jvectormap/jquery-jvectormap-us-aea.js"></script>



<script src="/assets/template/admin/plugins/daterangepicker/moment.min.js"></script>
<script src="/assets/template/admin/plugins/daterangepicker/daterangepicker.js"></script>
<script>
    var base_url = '<?= base_url() ?>';

    jQuery(document).ready(function() {
        jQuery('input[name="dateRange"]').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        jQuery('input[name="dateRange"]').on('apply.daterangepicker', function(ev, picker) {
            jQuery(this).val(picker.startDate.format('MM/DD/YYYY'));
        });
        jQuery('input[name="dateRange"]').on('cancel.daterangepicker', function(ev, picker) {
            jQuery(this).val('');
        });
    });
</script>



<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script src="/assets/template/admin/plugins/toaster/toastr.min.js"></script>
<script src="/assets/template/admin/plugins/select2/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.35/sweetalert2.min.js"></script>

<script src="/assets/template/admin/js/mono.js"></script>
<script src="/assets/template/admin/js/chart.js"></script>
<script src="/assets/template/admin/js/map.js"></script>
<script src="/assets/template/admin/js/custom.js"></script>

<?php
if (count($content_foot) > 0) {
    foreach ($content_foot as $cf) {
        echo view($cf);
    }
}
?>


</body>

</html>