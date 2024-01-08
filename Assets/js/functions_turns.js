let tableTurns;

document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
      })
      Swal.showLoading()
    tableTurns = $('#tableTurns').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/Turns/getTurns",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idturno"},
            {"data":"nombre_turno"},
            {"data":"inicio_turno"},
            {"data":"fin_turno"},
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

   
    // let btnCancelar =  document.querySelector("#btnCancelar");
    // btnCancelar.addEventListener('click', () => {
    //     formTurns.reset();
    // } )
   
   


    
}, false);


function guardarTurno(){
    let formTurns =  document.querySelector("#formTurns");
        event.preventDefault();
        
        let nombre_turno = document.querySelector("#nombre_turno").value;
        let hora_inicio = document.querySelector("#hora_inicio").value;
        let hora_fin = document.querySelector("#hora_fin").value;

        if(nombre_turno == '' || hora_inicio == '' || hora_fin == ''){
            Swal.fire("Atencion","Todos los campos son obligatorios","error");
            return false;
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Turns/setTurn';
        let formData = new FormData(formTurns);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData =  JSON.parse(request.responseText);

                if(objData.status){
                    formTurns.reset();
                    Swal.fire("Turno",objData.msg,"success");
                    window.location.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
    }
}

function cancelar(){
    let formTurns =  document.querySelector("#formTurns");
    formTurns.reset();
}
function openCreate(){
   
    window.location.href = base_url+"/turns/create";
    
}

function editTurns(idturno){
    var idturno =  idturno;

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Turns/getTurnsId/'+idturno;

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
            if(objData.status)
            {
                // console.log(objData);
                document.querySelector('#idturno').value = objData.data.idturno;
                document.querySelector('#nombre_turno').value = objData.data.nombre_turno;
                document.querySelector('#hora_inicio').value = objData.data.inicio_turno;
                document.querySelector('#hora_fin').value = objData.data.fin_turno;
                $('#modalUpdateTurns').modal('show');
                 
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

function deleteTurns(idturno){
    
    var idturno = idturno;
    Swal.fire({
        title: 'Eliminar el Turno',
        text: "¿Desea eliminar el Turno?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {
    
        if(willDelete.isConfirmed){
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Turns/deletTurns';
            var strData = "idturno="+idturno;
    
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
    
            request.onreadystatechange = function() {
               
                if(request.readyState == 4 && request.status == 200) 
                {
                    var objData =  JSON.parse(request.responseText);
    
                    if(objData.status){
                        Swal.fire("Turno",objData.msg,"success");
                        tableTurns.api().ajax.reload();
                    }else{
                        Swal.fire("Atencion",objData.msg,"error");
                    }
                }
                 
            }
        }
        
      })

}