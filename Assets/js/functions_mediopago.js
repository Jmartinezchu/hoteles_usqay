let tableMedioPago;

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
    tableMedioPago = $('#tableMedioPago').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/MedioPago/getMedio",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idmediopago"},
            {"data":"nombre"},
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

    //nuevo Medio
})

function guardarMedioPago(){
    let formMedioPago = document.querySelector("#formMedioPago");
        event.preventDefault();

        // let idcategoria=document.querySelector("#idcategoria").value;

        let nombre = document.querySelector("#nombre").value;

        if(nombre  == '') {
            Swal.fire("Atencion","El campo es obligatorio","error");
            return false;
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');


        let ajaxUrl = base_url+'/MedioPago/setMedio';

        let formData = new FormData(formMedioPago);

        request.open("POST",ajaxUrl,true);
        request.send(formData);
    
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                // console.log(JSON.parse(request.responseText));
                let objData = JSON.parse(request.responseText);
                
                if(objData.status){
                    
                    Swal.fire("Medio Pago",objData.msg,"success");
                    tableMedioPago.api().ajax.reload();
                    formMedioPago.reset();

                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
                
            }
           
        }
    
}

function cancelar(){
    let formMedioPago = document.querySelector("#formMedioPago");
    formMedioPago.reset();
}

function editarMedio(idmediopago){


    
    //obtener el atributo rl del controlador para editar

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/MedioPago/getMedio2/'+idmediopago; //url
    // console.log(idmediopago);
    request.open("POST",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
            
            // console.log(objData);
            
           
            document.querySelector('#idmediopago').value = objData.data.idmediopago;

            document.querySelector('#nombre').value = objData.data.nombre;

            tableMedioPago.api().ajax.reload();
        }
 }
}

function eliminarMedio(idmediopago){

    var idmediopago = idmediopago;
    Swal.fire({
        title: 'Eliminar Medio de Pago',
        text: "¿Desea eliminar el Medio de Pago?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {

        if(willDelete.isConfirmed){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/MedioPago/deleteMedio';
            var strData="idmediopago="+idmediopago;

            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                   
                    if(objData.status)
                    {
                        Swal.fire("MEDIO - PAGO",objData.msg,"success");
                        tableMedioPago.api().ajax.reload();
                        
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


$('#tableMedioPago').dataTable();        

        