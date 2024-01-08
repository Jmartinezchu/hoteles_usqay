
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
     
}, false);

window.addEventListener('load', () => {
    Cajas();
    Turnos();
 },false);
 
function guardarOpening(){
    let formTurnOpening = document.querySelector("#formTurnOpening");
         event.preventDefault();
         let cajas = document.querySelector("#cajas").value;
         let turnos = document.querySelector("#turnos").value;
         let monto_inicial = document.querySelector("#monto_inicial").value;

         if(cajas == '' || turnos == '' ){
             Swal.fire("Atencion","Todos los campos son obligatorios","error");
             return false;
         }
         let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
         let ajaxUrl = base_url+'/TurnOpening/setTurnOpening';
         let formData = new FormData(formTurnOpening);
         request.open("POST",ajaxUrl,true);
         request.send(formData);
 
         request.onreadystatechange = function(){
             if(request.readyState == 4 && request.status == 200){
                 let objData = JSON.parse(request.responseText);
 
                 if(objData.status){
                    formTurnOpening.reset();
                     Swal.fire("Apertura de turno",objData.msg,"success");
 
                 }else{
                    Swal.fire("Error",objData.msg,"error");
                 }
             }
     }
}

function cancelar(){
    let formTurnOpening = document.querySelector("#formTurnOpening");
    formTurnOpening.reset();
}

function Cajas(){
    let ajaxUrl = base_url+'/CashRegister/getSelectCajas';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#cajas').innerHTML = request.responseText;
            document.querySelector('#cajas').value = 1;
            // console.log(request.responseText)
        }
    }
}


function Turnos(){
    let ajaxUrl = base_url+'/Turns/getSelectTurns';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#turnos').innerHTML = request.responseText;
            document.querySelector('#turnos').value = 1;
            // console.log(request.responseText)
        }
    }
}