<div class="modal fade" id="modalOpenBox" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Datos de Apertura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formOpenBox" name="formOpenBox">
                    <input type="hidden" id="idOpenBox" name="idOpenBox">
                    <div class="row">
                        <div class= "col-lg 6">
                            <div class="mb-3">
                                <label for="example-select" class="form-label">Caja:</label>
                                <select class="form-select"  data-live-search="true" id="cajas" name="cajas">
                                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class= "col-lg 6">
                            <div class="mb-3">
                            <label for="example-placeholder" class="form-label">Monto:</label>
                                <input type="text" id="monto_inicial" class="form-control" placeholder="Ingresar Monto"
                                name="monto_inicial" value="0">
                            </div>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary"onclick="guardarOpenBox()">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
