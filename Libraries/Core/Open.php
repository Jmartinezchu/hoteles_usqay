
<?php 
     $con = new Mysql();
     $conf = "SELECT * FROM configuracion WHERE id = 1";
     $request_confg = $con->buscar($conf);
     $fecha_cierre = $request_confg["fecha_cierre"];
     $hoy = $request_confg["fecha_cierre"];
     $fecha_actual = date('Y-m-d'); ?>
<?php
 
      if($hoy != $fecha_actual):
     //  var_dump($hoy);
   ?>
    <div class="d-grid gap-2">
      <a href="<?= base_url(); ?>/OpenBox" class="btn btn-primary" type="button"><strong>No se aperturó caja! </strong><i class="dripicons-information"></i></a>
    </div>

   <?php endif; ?>
   <script>
    const base_url = "<?= base_url(); ?>";
    </script>



