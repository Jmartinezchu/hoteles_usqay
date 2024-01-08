<div class="modal fade" id="modalUpdateHabitacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Habitacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formHabitacion" name="formHabitacion">
                    <input type="hidden" id="idhabitacion" name="idhabitacion" value="">
                    <div class="row">
                        <div class="col-lg 6">
                            <div class="mb-3">
                                <label for="example-placeholder" class="form-label">Nombre:</label>
                                <input type="text" id="nombre" class="form-control" placeholder="Nombre de la habitación" name="nombre">
                            </div>
                        </div>
                        <div class="col-lg 6">
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Categoría:</label>
                                <select class="form-select" data-live-search="true" id="categoria" name="categoria">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg 6">
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Estado:</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="Disponible">Disponible</option>
                                    <option value="Ocupada">Ocupada</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg 6">

                            <div class="mb-3">
                                <label for="example-placeholder" class="form-label">Capacidad:</label>
                                <input type="number" id="capacidad" class="form-control" placeholder="Capacidad de la habitación" name="capacidad">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg 6">
                            <div class="mb-3">
                                <label for="example-placeholder" class="form-label">Descripción:</label>
                                <input type="text" id="descripcion" class="form-control" placeholder="Descripción de la habitación" name="descripcion">
                            </div>
                        </div>
                        <div class="col-lg 6">
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Piso:</label>
                                <select class="form-select" id="piso" name="piso">
                                </select>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarHabitacion()">Guardar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>