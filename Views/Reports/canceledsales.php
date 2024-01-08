<?php headerAdmin($data);  ?>
<main>
<?php require_once("Libraries/Core/Open.php");
     

?>

    <div class="card">
        <div class="card-header">
           <h4>Ventas anuladas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableCanceledSales" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Comprobante</th>
                            <th>Estado</th>
                            <th>Medio Pago</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>



<?php footerAdmin($data); ?>