<?php
  $idreservacion = $_REQUEST['id'];
?>
<div class="modal fade" id="modalDesecharConsumo" tabindex="-1" role="dialog"  aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Desechar Consumo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                <form id="formDesecharConsumo" name="formDesecharConsumo">
                    <input type="hidden" id="idreserva_desechable" name="idreserva_desechable" value="<?= $idreservacion?>">
                    <input type="hidden" id="iddetalle_desechable" name="iddetalle_desechable">
                    <input type="hidden" id="idconsumo_desechable" name="idconsumo_desechable">
                    <input type="hidden" id="cantidad_desechable" name="cantidad_desechable">
                   
                    <div class="form-group mb-0">
                        <label for="nombre" class="form-control-label">Cantidad :</label>
                        <input type="text" class="form-control" id="cantidadDesechada" name="cantidadDesechada" placeholder="Ingresar Cantidad" value="1"/>
                    </div>
                    <br>
                    <div class="form-group mb-0">
                        <label for="nombre" class="form-control-label">Motivo de desechar consumo:</label>
                        <textarea type="text" class="form-control" id="descripcion_desechable" name="descripcion_desechable" placeholder="Ingresar Motivo" required></textarea>
                    </div>
                    <br> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" onclick="desecharConsumos(<?= $idreservacion?>)">Guardar</button>
                    </div>
                </form>
            </div>
       
        </div>
    </div>
</div>

<script>
    let formDesecharConsumo = document.querySelector("#formDesecharConsumo");
    function desecharConsumos(idReservacion){
        // event.preventDefault();
        let cantidad = document.getElementById("cantidad_desechable").value;
        let ingreso = document.getElementById("cantidadDesechada").value;
        let descripcion = document.getElementById("descripcion_desechable").value;
        if(descripcion == ''){
            Swal.fire("Atención","Debe ingresar el motivo", "error");
        }else
            if(cantidad >= ingreso){
                let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+'/Reservations/desecharConsumo';
                let formData = new FormData(formDesecharConsumo);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);
                        if(objData.status){
                            Swal.fire("Desechar Consumo",objData.msg,"success");
                            window.location = base_url+'/hospedar/show?id='+idReservacion;
                        }
                    }
                }
            }else{
                Swal.fire("Atención","No puede ingresar mas cantidad de la registrada", "error");
            }   
    }
</script>
