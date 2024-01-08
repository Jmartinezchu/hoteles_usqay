<!-- Footer Start -->
<footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center">
                                <script>document.write(new Date().getFullYear())</script> © Versión 1.1
                            </div>
                           
                        </div>
                    </div>
</footer>
<!-- end Footer -->


<script>
    const base_url = "<?= base_url(); ?>";
</script>

        <!-- SCRIPTS DE LAS PLANTILLAS -->
        <script src="<?= media();?>/js/vendor.min.js"></script>
        <script src="<?= media();?>/js/app.min.js"></script>

        <!-- third party js -->
        <script src="<?= media();?>/js/vendor/apexcharts.min.js"></script>
        <script src="<?= media();?>/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?= media();?>/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
        
        <!-- SCRIPTS DE GRAFICOS DE TABLAS -->
        <script src="<?= media();?>/js/vendor/d3.min.js"></script>
        <script src="<?= media();?>/js/vendor/britecharts.min.js"></script>



         <!-- SCRIPTS DE LAS TABLAS -->
         <script src="<?= media();?>/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?= media();?>/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?= media();?>/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?= media();?>/js/vendor/responsive.bootstrap5.min.js"></script>
        <script src="<?= media();?>/js/vendor/dataTables.buttons.min.js"></script>
        <script src="<?= media();?>/js/vendor/buttons.bootstrap5.min.js"></script>
        <script src="<?= media();?>/js/vendor/buttons.html5.min.js"></script>
        <script src="<?= media();?>/js/vendor/buttons.flash.min.js"></script>
        <script src="<?= media();?>/js/vendor/buttons.print.min.js"></script>
        <script src="<?= media();?>/js/vendor/dataTables.keyTable.min.js"></script>
        <script src="<?= media();?>/js/vendor/dataTables.select.min.js"></script>

        <!-------------------------- SCRIPTS  ANTERIORES -------------------------->



        


<!-- Datatables -->
<script src="<?= media();?>/plugins/cloudflare/jszip.min.js"></script>
<script src="<?= media();?>/plugins/cloudflare/pdfmake.min.js"></script>
<script src="<?= media();?>/plugins/cloudflare/vfs_fonts.js"></script>

<script src="<?= media();?>/plugins/highcharts/highcharts.js"></script>
<script src="<?= media();?>/plugins/highcharts/modules/exporting.js"></script>
<script src="<?= media();?>/plugins/highcharts/modules/export-data.js"></script>

<script src="<?= media();?>/plugins/highcharts/modules/heatmap.js"></script>
<script src="<?= media();?>/plugins/highcharts/modules/tilemap.js"></script>
<script src="<?= media();?>/plugins/highcharts/modules/exporting.js"></script>
<script src="<?= media();?>/plugins/highcharts/modules/export-data.js"></script>
<script src="<?= media();?>/plugins/highcharts/modules/accessibility.js"></script>

<script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>





        
        
        <!-- demo app -->
        <script src="<?= media();?>/js/pages/demo.dashboard.js"></script>
        <script src="<?= media();?>/js/pages/demo.britechart.js"></script>
        <script src="<?= media();?>/js/pages/demo.datatable-init.js"></script>
        <!-- end demo js-->

       
        <script src="<?= media();?>/plugins/fontawesome/js/fontawesome.js"></script>
        <script src="<?= media();?>/plugins/fontawesome/js/fontawesome.min.js"></script>
        <script src="<?= media();?>/plugins/fontawesome/js/fontawesome.min.js"></script>
        <script src="<?= media();?>/plugins/fontawesome/js/all.js"></script>
        <script src="<?= media();?>/plugins/fontawesome/js/all.min.js"></script>


<script>

    let list = document.querySelectorAll('.list');
    for(let i = 0; i < list.length; i++) {
        list[i].onclick = () => {
            let j = 0;
            while(j < list.length){
                list[j++].className = 'list';
            }
            list[i].className = 'list active';
        }
    }
</script>
</body>

</html>