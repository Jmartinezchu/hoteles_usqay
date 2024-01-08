<?php
   headerAdmin($data);
 ?>
<main>
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
                                    <li class="breadcrumb-item active">Usuarios</li>
                                    <li class="breadcrumb-item active">Crear</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Crear Usuarios</h4>
                        </div>
                    </div>
                </div>     
                <!-- end page title -->

                <div class="row">
                        <div class="card">
                            <div class="card-body">
                            <form id="formUser" name="formUser">
                            <input type="hidden" id="idusuario" name="idusuario">
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Identificacion:</label>
                                            <input onkeyup="this.value=numeros(this.value); searchReniec()" type="text" id="identificacion" class="form-control" placeholder="Numero de documento"
                                            name="identificacion">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Nombres:</label>
                                            <input type="text" id="nombres" class="form-control" placeholder="Ingresar Nombres"
                                            name="nombres">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Apellidos:</label>
                                            <input type="text" id="apellidos" class="form-control" placeholder="Ingresar Apellidos"
                                            name="apellidos">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Telefono:</label>
                                            <input onkeyup="this.value=numeros(this.value)" type="text" id="telefono" class="form-control" placeholder="Ingresar Telefono"
                                            name="telefono">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Email:</label>
                                            <input type="text" id="email_user" class="form-control" placeholder="Ingresar Email"
                                            name="email_user">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Password:</label>
                                            <input type="password" id="password" class="form-control" placeholder="Ingresar Password"
                                            name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Rol:</label>
                                            <select class="form-select" data-live-search="true" id="roles" name="roles">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button id="btnActionForm" type="button" class="btn btn-primary" onclick="guardarUsuario()" ><span id="btnText">Guardar</span></button>&nbsp;
                                    <button type="button" id="btnCancelar" class="btn btn-light" onclick="cancelar()">Cancelar</button>
                                </div>
                            </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<?php footerAdmin($data); ?>