let tableMovimiento;
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
      })
      Swal.showLoading()
    tableMovimiento = $('#tableMovimiento').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/StoreHouseMovement/getStoreHouseMovement",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idmovimiento_almacen"},
            {"data":"tipo_movimiento"},
            {"data":"nombre_almacen"},
            {"data":"descripcion"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
         
        ],
        
        "resonsieve":"true",
        "bDestroy":true,
        "iDisplayLength": 10,
        "order": [[0,"desc"]]
    });


}, false);


window.addEventListener('load', () => {
    Almacenes();
 },false);
 
 function guardarStoreHouseMovement(){
    let formMovimiento =  document.querySelector("#formMovimiento");
        event.preventDefault();

        let tipo_movimiento = document.querySelector("#tipo_movimiento").value;
        let almacenes = document.querySelector("#almacenes").value;
        let descripcion = document.querySelector("#descripcion").value;

        if(tipo_movimiento == '' || almacenes == '' || descripcion == ''){
            Swal.fire("Atencion","Todos los campos son obligatorios","error");
            return false;
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/StoreHouseMovement/setStoreHouseMovement';
        let formData = new FormData(formMovimiento);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    formMovimiento.reset();
                    Swal.fire("Movimiento de almacen",objData.msg,"success");
                    window.location.reload();

                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
    }
    
 }

 function cancelar(){
    let formMovimiento =  document.querySelector("#formMovimiento");
    formMovimiento.reset();
 }

 function Almacenes(){
    let ajaxUrl = base_url+'/Almacen/getSelectAlmacenes';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#almacenes').innerHTML = request.responseText;
            document.querySelector('#almacenes').value = 1;
        }
    }
}


function deleteStoreHouseMovement(idmovimiento_almacen){
   var idmovimiento_almacen = idmovimiento_almacen;
   Swal.fire({
    title: 'Eliminar Movimiento de Almacen',
    text: "¿Desea eliminar el movimiento de almacen?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!'
}).then((willDelete) => {

    if(willDelete.isConfirmed){
        var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl=base_url+'/StoreHouseMovement/delStoreHouseMovement';
        var strData="idmovimiento_almacen="+idmovimiento_almacen;

        request.open("POST",ajaxUrl,true);
        request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        request.send(strData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status==200 )
            {
                var objData=JSON.parse(request.responseText);
                
                if(objData.status)
                {
                    Swal.fire("Movimiento de almacen",objData.msg,"success");
                    tableMovimiento.api().ajax.reload();
                }
                else
                {
                    Swal.fire("Atencion",objData.msg,"error");
                }
            }
        }

    }
});
}


