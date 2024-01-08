let tableAlmacen;

document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
      })
      Swal.showLoading()
    tableAlmacen = $('#tableAlmacen').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/Almacen/getAlmacenes",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idalmacen"},
            {"data":"nombre_almacen"},
            {"data":"ubicacion_almacen"},
            {"data":"descripcion_almacen"},
            {"data":"estado"},
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

function guardarAlmacen() {
    let formAlmacen = document.querySelector("#formAlmacen");
        let nombre = document.querySelector("#nombre").value;
        let ubicacion = document.querySelector("#ubicacion").value;
        let descripcion = document.querySelector("#descripcion").value;
        if(nombre  == '' || ubicacion == '' || descripcion == '') {
            Swal.fire("Atencion","Los campos son obligatorios","error");
            return false;
        }
        
    
        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Almacen/setAlmacen';
        let formData = new FormData(formAlmacen);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
    
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status){
                    formAlmacen.reset();
                    Swal.fire("Almacen",objData.msg,"success");
                    tableAlmacen.api().ajax.reload(function() {});
                    window.location.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
       }

    
}
function cancelar(){
    let formAlmacen = document.querySelector("#formAlmacen");
    formAlmacen.reset();
}
function eliminarAlmacen(idalmacen){
    var idalmacen=idalmacen;
    event.preventDefault();
    Swal.fire({
        title: 'Eliminar Almacen',
        text: "¿Desea eliminar el almacen?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {

        if(willDelete.isConfirmed){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/Almacen/delAlmacen';
            var strData="idalmacen="+idalmacen;

            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                    
                    if(objData.status)
                    {
                        Swal.fire("Almacen",objData.msg,"success");
                        tableAlmacen.api().ajax.reload();
                    }
                    else
                    {
                        Swal.fire("Atencion",objData.msg,"error");
                    }
                }
            }

        }
    })
}
function editarAlmacen(idalmacen){
    event.preventDefault();
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Almacen/getAlmacen/'+idalmacen; //url

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){

            var objData =  JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector('#idAlmacen').value = objData.data.idalmacen;
                document.querySelector('#nombre').value = objData.data.nombre_almacen;
                document.querySelector('#ubicacion').value = objData.data.ubicacion_almacen;
                document.querySelector('#descripcion').value = objData.data.descripcion_almacen;
            }else{
                Swal.fire("Atencion",objData.msg,"error");
            }
                
        }
    }
}
$('#tableAlmacen').dataTable();