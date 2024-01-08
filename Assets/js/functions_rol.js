
let tableRoles;

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

    tableRoles = $('#tableRoles').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/Rol/getRoles",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idrol"},
            {"data":"nombre_rol"},
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

})

$('#tableRoles').DataTable();

function guardarRol(){
    let formRol = document.querySelector("#formRol");
        event.preventDefault();

        let nombrerol = document.querySelector("#nombrerol").value;
        if(nombrerol  == '') {
            Swal.fire("Atencion","El campo es obligatorio","error");
            return false;
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Rol/setRol';
        let formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    formRol.reset();
                    Swal.fire("Rol",objData.msg,"success");
                    tableRoles.api().ajax.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
    }
    
}
function cancelar(){
    let formRol = document.querySelector("#formRol");
    formRol.reset();
}
function fntEditRol(idrol){
    var idrol = idrol;
    
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Rol/getRol/'+idrol;

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
            if(objData.status){
                document.querySelector('#idrol').value = objData.data.idrol;
               document.querySelector('#nombrerol').value = objData.data.nombre_rol; 
               tableRoles.api().ajax.reload();
            
            }else{
                Swal.fire("Atencion",objData.msg,"error");
            }
        }
    }

}




function fntPermisos(idrol){
    var idrol = idrol;
    var request =  (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/getPermisos/'+idrol;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector("#contentAjax").innerHTML = request.responseText;
            $('#modalPermisos').modal('show');
        }
    }
   
}


function fntSavePermisos(){
    event.preventDefault();
    var request =  (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Permisos/setPermisos';
    var formElement =  document.querySelector("#formPermisos");
    var formData = new FormData(formElement);
    request.open("POST",ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            var objData = JSON.parse(request.responseText);

            if(objData.status){
                Swal.fire("Permisos de usuario",objData.msg,"success");
                window.location.reload();
            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        }
    }

}
    

function fntEliminarRol(idrol){
    
    var idrol = idrol;
    Swal.fire({
        title: 'Eliminar Rol',
            text: "¿Desea eliminar el Rol?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {

        if(willDelete.isConfirmed){
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Rol/delRol';
            var strData = "idrol="+idrol;
    
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
    
            request.onreadystatechange = function() {
               
                if(request.readyState == 4 && request.status == 200) 
                {
                    var objData =  JSON.parse(request.responseText);
    
                    if(objData.status){
                        Swal.fire("Roles",objData.msg,"success");
                        tableRoles.api().ajax.reload();
                    }else{
                        Swal.fire("Atencion",objData.msg,"error");
                    }
                }
                 
            }
        }
        
      })

}