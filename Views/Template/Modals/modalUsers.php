<div class="modal fade" id="modalUsers" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Usuarios</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form id="formUser" name="formUser">
                    <input type="hidden" id="idusuario" name="idusuario">
                    <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Identificacion:</label>
                                            <input onkeyup='searchReniec()' type="text" id="identificacion" class="form-control" placeholder="Numero de documento"
                                            name="identificacion">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre:</label>
                                            <input type="text" id="nombres" class="form-control" placeholder="Nombres"
                                            name="nombres">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Apellidos:</label>
                                            <input type="text" id="apellidos" class="form-control" placeholder="Apellidos"
                                            name="apellidos">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Telefono:</label>
                                            <input type="text" id="telefono" class="form-control" placeholder="Telefono"
                                            name="telefono">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Email:</label>
                                            <input type="text" id="email_user" class="form-control" placeholder="Email"
                                            name="email_user">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Contraseña:</label>
                                            <input type="password" id="password" class="form-control" placeholder="Contraseña"
                                            name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-select" class="form-label">Roles:</label>
                                            <select class="form-select" data-live-search="true" id="roles" name="roles">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                    <br> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarUsuario()">Guardar</button>
                    </div>
                </form>
            </div>
       
        </div>
    </div>
</div>
