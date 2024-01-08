<div class="modal fade" id="modalUpdateTurns" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Turno</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form id="formTurns" name="formTurns">
                    <input type="hidden" id="idturno" name="idturno">
                    <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Nombre:</label>
                                            <input type="text" id="nombre_turno" class="form-control" placeholder="Nombre del Turno"
                                            name="nombre_turno">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                                <label for="example-select" class="form-label">Hora Inicio:</label>
                                                <input type="time" id="hora_inicio" class="form-control" placeholder="Ingresar Hora Inicio"
                                                name="hora_inicio">
                                        </div>
                                        
                                    </div>
                                    <div class= "col-lg 6">
                                        <div class="mb-3">
                                            <label for="example-placeholder" class="form-label">Hora Fin:</label>
                                            <input type="time" id="hora_fin" class="form-control" placeholder="Ingresar Hora Fin"
                                            name="hora_fin">
                                        </div>
                                    </div>
                                </div>

                    <br> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarTurno()">Guardar</button>
                    </div>
                </form>
            </div>
       
        </div>
    </div>
</div>
