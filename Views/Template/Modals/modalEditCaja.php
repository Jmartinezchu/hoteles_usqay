<div class="modal fade" id="modalUpdateCaja" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Caja</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form id="formCaja" name="formCaja">
         <input type="hidden" id="idCaja" name="idCaja">
                    <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                        <label for="example-placeholder" class="form-label">Nombre:</label>
                                            <input type="text" id="nombre_caja" class="form-control" placeholder="Nombre de caja"
                                            name="nombre_caja">
                                        </div>
                                    </div>
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Ubicación:</label>
                                            <input type="text" id="ubicacion" class="form-control" placeholder="Ubicación de caja"
                                            name="ubicacion">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                    <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Descripción:</label>
                                            <input type="text" id="descripcion" class="form-control" placeholder="Descripción de caja"
                                            name="descripcion">
                                        </div>
                                    </div>
                                </div>
                    <br> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarCaja()">Guardar</button>
                    </div>
                </form>
            </div>
       
        </div>
    </div>
</div>
