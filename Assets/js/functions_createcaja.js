
let tableCajas;

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
    tableCajas = $('#tableCajas').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/CashRegister/getCajas",
            "dataSrc": ""
        },
        "columns": [
            {"data":"id_caja"},
            {"data":"nombre_caja"},
            {"data":"ubicacion"},
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

function guardarCaja(){
    let formCaja = document.querySelector("#formCaja");
        event.preventDefault();

        let nombre_caja = document.querySelector("#nombre_caja").value;
        let ubicacion = document.querySelector("#ubicacion").value;
        let descripcion = document.querySelector("#descripcion").value;


        if(nombre_caja  == '' ||  ubicacion == '' || descripcion == '' ) {
            Swal.fire("Atencion","Todos los campos son obligatorios","error");
            return false;
        }nombre_caja

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/CashRegister/setCreate';
        let formData = new FormData(formCaja);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    formCaja.reset();
                    Swal.fire("Caja",objData.msg,"success");
                    window.location.reload();

                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
        }
}
function cancelar(){
    let formCaja = document.querySelector("#formCaja");
    formCaja.reset();
}
function openCreate(){
    window.location.href = base_url+"/cashregister/create";
}

function fntDeleteCaja(id_caja){
    var id_caja = id_caja;
    Swal.fire({
        title: 'Eliminar caja',
        text: "¿Desea eliminar la caja?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {

        if(willDelete.isConfirmed){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/CashRegister/deleteCashRegister';
            var strData="id_caja="+id_caja;

            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                   
                    if(objData.status)
                    {
                        Swal.fire("Caja",objData.msg,"success");
                        tableCajas.api().ajax.reload();
                        
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



function fntUpdateCaja(idCaja){
    var idCaja =  idCaja;

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/CashRegister/getCashRegisterId/'+idCaja;

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
            if(objData.status)
            {
                // console.log(objData);
                document.querySelector('#idCaja').value = objData.data.id_caja;
                document.querySelector('#nombre_caja').value = objData.data.nombre_caja;
                document.querySelector('#ubicacion').value = objData.data.ubicacion;
                document.querySelector('#descripcion').value = objData.data.descripcion;
                $('#modalUpdateCaja').modal('show');
                 
            }else {
                Swal.fire({
                    title : 'Error',
                    text : objData.msg,
                    timer: 700,
                    icon : 'error',
                    allowOutsideClick : false,
                    allowEscapeKey : false
                  })
                  Swal.showLoading()
            }
        }
    }

}