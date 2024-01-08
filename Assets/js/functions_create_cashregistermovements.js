
document.addEventListener('DOMContentLoaded',() => {
    Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
      })
      Swal.showLoading()
    
}, false)

window.addEventListener('load', () => {
    cajas();
    tipoMovimientoCaja();
    monedas();
    mediosPago();
},false);

function guardarMovimiento(){
    let formMovementCash = document.querySelector("#formMovementCash");
        event.preventDefault();

        let monto = document.querySelector("#monto").value;
        let descripcion = document.querySelector("#descripcion").value;

        if(monto == '' || descripcion == ''){
            Swal.fire("Atencion","Los campos son obligatorios","error");
            return false;
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/CashRegisterMovements/setCashRegisterMovement';
        let formData = new FormData(formMovementCash);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    formMovementCash.reset();
                    Swal.fire("Ingreso movimiento de caja",objData.msg,"success");
                  
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
        }
    }

    function cancelar(){
        let formMovementCash = document.querySelector("#formMovementCash");
        formMovementCash.reset();
    }

function cajas(){
    let ajaxUrl = base_url+'/CashRegister/getSelectCash';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#cajas').innerHTML = request.responseText;
            document.querySelector('#cajas').value = 1;
        }
    }
}   


function tipoMovimientoCaja(){
    let ajaxUrl = base_url+'/CashRegisterMovements/getSelectTipoMovimiento';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#tipo_movimiento').innerHTML = request.responseText;
            document.querySelector('#tipo_movimiento').value = 11;
        }
    }
}


function monedas(){
    let ajaxUrl = base_url+'/CashRegisterMovements/getSelectMonedas';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#moneda').innerHTML = request.responseText;
            document.querySelector('#moneda').value = 1;
        }
    }
}

function mediosPago(){
    let ajaxUrl = base_url+'/CashRegisterMovements/getSelectMediosPago';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#metodo_pago').innerHTML = request.responseText;
            document.querySelector('#metodo_pago').value = 1;
        }
    }
}
function numeros(string){//Solo numeros
    var out = '';
    var filtro = '1234567890.';//Caracteres validos
    
    //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos 
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
             //Se añaden a la salida los caracteres validos
         out += string.charAt(i);
    
    //Retornar valor filtrado
    return out;
} 
     
