<div class="modal fade" id="modalEditReservations" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar reservacion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form id="formReserva" name="formReserva">
                    <input type="hidden" id="idreservacion" name="idreservacion">
                    <!-- <input type="hidden" id="tiempo" name="tiempo"> -->
                    <input type="hidden" id="huesped" name="huesped">
                    <input type="hidden" id="idhabitacion" name="idhabitacion">
                    <input type="hidden" id="total_reserva" name="total_reserva">
                    <input type="hidden" id="idTarifasjajaja" name="idTarifasjajaja">
                    <div class="form-group mb-0">
                        <label for="nombre" class="form-control-label">Desde:</label>
                        <input type="datetime-local" class="form-control" id="ingreso" name="ingreso"/>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nombre" class="form-control-label">Hasta:</label>
                        <input type="datetime-local" class="form-control" id="salida" name="salida"/>
                    </div>
                    <div class="form-group mb-0">
                    <label for="example-select" class="form-label">Origen:</label>
                            <select class="form-select"  data-live-search="true" id="origen_reserva" name="origen_reserva">
                            </select>
                     </div>
                    <div class="form-group mb-0">
                    <label for="example-select" class="form-label">Estado:</label>
                            <select class="form-select"  data-live-search="true" id="estados_reservaciones" name="estados_reservaciones">
                            </select>
                     </div>
                    <br> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="updateReservacion()">Guardar</button>
                    </div>
                </form>
            </div>
       
        </div>
    </div>
</div>
