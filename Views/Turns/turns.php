<?php headerAdmin($data);
getModal("modalEditTurns",$data);
?>
<div class="wrapper">
<div class="content-page">

    <?php require_once("Libraries/Core/Open.php") ?>
    <!-- content -->
    <div class="content">
    <div class="container-fluid">
        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                                            <li class="breadcrumb-item active">Configurar</li>
                                            <li class="breadcrumb-item active">Turnos</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Turnos</h4>
                                </div>
                            </div>
        </div>     
        <!-- end page title -->

        <div class="row">

                            <div class="col-12">
                                
                                <div class="card">
                                    
                                
                                    <div class="card-body">
                                    
                                    <div class="card-header">
                                    <button onclick="openCreate();" type="submit" class="btn btn-primary mb-2">Crear</button>
                                        <div class="tab-content">
                                        
                                            <div class="table-responsive">
                                                <table id="tableTurns" class="table dt-responsive nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Nombre</th>
                                                            <th>Inicio</th>
                                                            <th>Fin</th>
                                                            <th>Opciones</th>
                                                        </tr>
                                                    </thead>
                                                
                                                    <tbody >
                                                    </tbody>
                                                </table>                                           
                                            </div> <!-- end preview-->
                                        
                                        </div> <!-- end tab-content-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
        </div>
    </div>
    </div>
        <!-- content -->
</div>
</div>  




<?php footerAdmin($data); ?>