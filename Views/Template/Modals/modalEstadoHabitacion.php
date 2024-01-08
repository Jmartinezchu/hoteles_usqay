<div class="modal fade" id="modalEstadoHabitacion" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar estado habitacion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form id="formHabitacion" name="formHabitacion">
                    <input type="hidden" id="idhabitacion" name="idhabitacion" value="">
                   
                    <div class="form-group mb-0">
                        <label for="nombre" class="form-control-label">Nombre :</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre"/>
                    </div>
                    <br>
                    <div class="form-group mb-0">
                        <label for="estado" class="form-control-label">Estado:</label>
                        <select  class="form-control" id="estado" name="estado" > 
                            <option value="Disponible">Disponible</option>
                            <option value="Mantenimiento">En mantenimiento</option>
                            <!-- <option value="Ocupada">Ocupada</option> -->
                        </select>  
                     </div>
                    <br> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarEstadoHabitacion()">Guardar</button>
                    </div>
                </form>
            </div>
       
        </div>
    </div>
</div>
