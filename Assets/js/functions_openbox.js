

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



function guardarOpenBox(){
    event.preventDefault();
    let formOpenBox = document.querySelector("#formOpenBox");
    let cajas = document.querySelector("#cajas").value;
    let monto_inicial = document.querySelector("#monto_inicial").value;

    if(cajas == '' ||  monto_inicial == ''){
        swal("Atencion","Todos los campos son obligatorios","error");
        return false;
    }
    let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/OpenBox/setOpenBox';
    let formData = new FormData(formOpenBox);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status){
                formOpenBox.reset();
                location.href = base_url+'/dashboard';

            }else{
                Swal.fire("Error",objData.msg,"error");
            }
        }
    }
}

function aperturar(){
    $('#modalOpenBox').modal('show');
}

function cancelar(){
  location.href = base_url+'/dashboard';
}

window.addEventListener('load', () => {
    Cajas();
    Turnos();
 },false);
 
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


// function Turnos(){
//     let ajaxUrl = base_url+'/Turns/getSelectTurns';
//     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//     request.open("GET",ajaxUrl,true);
//     request.send();

//     request.onreadystatechange = function(){
//         if(request  .readyState == 4 && request.status == 200){
//             document.querySelector('#turnos').innerHTML = request.responseText;
//             document.querySelector('#turnos').value = 1;
//         }
//     }
// }