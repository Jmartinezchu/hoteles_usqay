let tableDetalleMovimiento;
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
    let idmovimiento = document.querySelector("#idmovimiento").value;
    // console.log(idmovimiento)
    tableDetalleMovimiento = $('#tableDetalleMovimiento').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/DetailStoreHouseMovement/getDetailStoreHouseMovement/"+idmovimiento,
            "dataSrc": ""
        },
        "columns": [
            {"data":"nombre"},
            {"data":"cantidad_retirada"},
            {"data":"descripcion"},
            {"data":"fecha"},
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

    
}, false)


window.addEventListener('load', () => {
    Productos();
},false);
 
function guardarDetailMovement(){
    let formDetalleMovimiento = document.querySelector("#formDetalleMovimiento");
        event.preventDefault();

        let cantidad = document.querySelector("#cantidad").value;

        if(cantidad == ''){
            Swal.fire("Atencion","Es obligatorio ingresar la cantidad","error");
            return false;
        }

        
        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/DetailStoreHouseMovement/setDetailStoreHouseMovement';
        let formData = new FormData(formDetalleMovimiento);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    formDetalleMovimiento.reset();
                    Swal.fire("Detalle Movimiento",objData.msg,"success");
                    tableDetalleMovimiento.api().ajax.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
        
    }
}

function cancelar(){
    let formDetalleMovimiento = document.querySelector("#formDetalleMovimiento");
    formDetalleMovimiento.reset();
}
 function Productos(){
    let ajaxUrl = base_url+'/Producto/getSelectProductos';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#productos').innerHTML = request.responseText;
            document.querySelector('#productos').value = 1;
        }
    }
}


function deleteDetalle(iddetalle_movimiento){

    var iddetalle_movimiento =  iddetalle_movimiento;
    Swal.fire({
        title: 'Eliminar Movimiento de producto',
        text: "¿Desea eliminar el movimiento de producto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {
    
        if(willDelete.isConfirmed){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/DetailStoreHouseMovement/deletDetailStoreHouseMovement';
            var strData="iddetalle_movimiento="+iddetalle_movimiento;

            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                    
                    if(objData.status)
                    {
                        Swal.fire("Movimiento producto",objData.msg,"success");
                        tableDetalleMovimiento.api().ajax.reload();
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

function numeros(string){//Solo numeros
    var out = '';
    var filtro = '1234567890';//Caracteres validos
    
    //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos 
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
             //Se añaden a la salida los caracteres validos
         out += string.charAt(i);
    
    //Retornar valor filtrado
    return out;
} 