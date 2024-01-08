let tableUsers;

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
    tableUsers = $('#tableUsers').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/Users/getUsers",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idusuario"},
            {"data":"nombres"},
            {"data":"email_user"},
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
   Roles();
   searchReniec();
   
},false);

function guardarUsuario(){
    let formUser = document.querySelector("#formUser");
        event.preventDefault();
   
        let identificacion = document.querySelector("#identificacion").value;
        let nombreUser = document.querySelector("#nombres").value;
        let apellidos = document.querySelector("#apellidos").value;
        let telefono = document.querySelector("#telefono").value;
        let email = document.querySelector("#email_user").value;
        let contraseña = document.querySelector("#password").value;


        if(identificacion == '' || nombreUser == '' || apellidos == '' || telefono == '' || email == '' ){
            Swal.fire("Atencion", "Todos los campos son obligatorios", "error");
            return false;
        }
        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Users/setUser';
        let formData = new FormData(formUser);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    formUser.reset();
                    Swal.fire("Usuario",objData.msg,"success"); 
                    window.location.reload();

                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
    }

}

function cancelar(){
    let formUser = document.querySelector("#formUser");
    formUser.reset();
}


function fntEditUsuario(idusuario){

    let persona = idusuario;

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Users/getUser/'+persona;

    
    request.open("GET",ajaxUrl,true);
    request.send();


    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
    
         
            if(objData.status)
            {
            // console.log(objData)
            document.querySelector('#idusuario').value = objData.data.idusuario;
            document.querySelector('#identificacion').value = objData.data.identificacion;
            document.querySelector('#nombres').value = objData.data.nombres;
            document.querySelector('#apellidos').value = objData.data.apellidos;
            document.querySelector('#telefono').value = objData.data.telefono;
            document.querySelector('#email_user').value = objData.data.email_user;
            document.querySelector('#roles').value = objData.data.idrol;
            $('#modalUsers').modal('show');
    
            }else{
                Swal.fire("Atencion",objData.msg,"error");
            }
        }
    }
    

}

function fntViewUsuario(idusuario)
{

    var idusuario = idusuario;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Users/getUser/'+idusuario;
    request.open("GET",ajaxUrl,true);
    request.send();


    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){

        var objData = JSON.parse(request.responseText);

        if(objData.status)
        {   
            document.querySelector("#identificacion").innerHTML = objData.data.identificacion;
            document.querySelector("#nombres").innerHTML = objData.data.nombres;
            document.querySelector("#apellidos").innerHTML = objData.data.apellidos;
            document.querySelector("#telefono").innerHTML = objData.data.telefono;
            document.querySelector("#email_user").innerHTML = objData.data.email_user;
         
       
        }else{
            Swal.fire("Error",objData.msg, "error");
        }
        }
    }
}



function deleteUser(idusuario){
    
    var idusuario = idusuario;
    Swal.fire({
        title: 'Eliminar Usuario',
        text: "¿Desea eliminar los usuarios?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {
        if(willDelete.isConfirmed){
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Users/deleteUser';
            var strData = "idusuario="+idusuario;
    
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
    
            request.onreadystatechange = function() {
               
                if(request.readyState == 4 && request.status == 200) 
                {
                    var objData =  JSON.parse(request.responseText);
    
                    if(objData.status){
                        Swal.fire("Usuario",objData.msg,"success");
                        tableUsers.api().ajax.reload();
                    }else{
                        Swal.fire("Atencion",objData.msg,"error");
                    }
                }
                 
            }
        }
        
      })

}

function openCreate(){
   
    window.location.href = base_url+"/users/create";
    
}

function Roles(){
    let ajaxUrl = base_url+'/Rol/getSelectRoles';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#roles').innerHTML = request.responseText;
            document.querySelector('#roles').value = 1;
        }
    }
}


function searchReniec() {
    let identificacion = document.querySelector("#identificacion").value;
    if (identificacion.length == 8) {
        $.post('https://clientapi.sistemausqay.com/dni.php?documento='+ identificacion, function(data){
            let objData = JSON.parse(data);
            if(objData){
                 document.querySelector("#nombres").value = objData.nombres;
                 document.querySelector("#apellidos").value = objData.apellidos;
                 document.querySelector("#direccion").value = objData.direccion;
             }
        })
    }
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

