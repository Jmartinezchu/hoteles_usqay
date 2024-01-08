<?php headerAdmin($data); ?>

<main>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Ventas</h4>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="box-footer">
                    <div class="card-header">
                        <button id="btnActionForm" class="btn btn-primary pull-right">Nueva Venta</button>

                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tableventas" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>fecha</th>
                                <th>Total</th>
                                <th>Estado</th>

                            </tr>
                        </thead>
                        <tbody style="text-align: center;">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>

</main>


<?php footerAdmin($data); ?>