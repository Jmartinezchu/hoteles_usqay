$(document).ready(function() {
    Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
      })
      Swal.showLoading()
    sel(1);
    
});


function guardarConfiguracion(){
    let formConfiguracion  = document.querySelector("#formConfiguracion");
        event.preventDefault();
        let idConfig = document.querySelector("#idConfig").value;
        let nombre_empresa = document.querySelector("#nombre_empresa").value;
        let ruc = document.querySelector("#ruc").value;
        let razon_social = document.querySelector("#razon_social").value;
        let telefono = document.querySelector("#telefono").value;
        let correo_electronico = document.querySelector("#correo_electronico").value;
        let serie_boleta = document.querySelector("#serie_boleta").value;
        let serie_factura = document.querySelector("#serie_factura").value;
        let token = document.querySelector("#token").value;
        let ruta = document.querySelector("#ruta").value;
        let id_detraccion = document.querySelector("#id_detraccion").value;

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Configure/setConfigure';
        let formData = new FormData(formConfiguracion);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200){
                let objData =  JSON.parse(request.responseText);
                // console.log(request.responseText)
                if(objData.status){
                    // console.log(objData)
                    Swal.fire("Configuracion",objData.msg,"success");
                    window.location = base_url+'/configure';
                  
                    // console.log(objData)
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
                  
            }
    }
}

function cancelar(){
    let formConfiguracion  = document.querySelector("#formConfiguracion");
    // formConfiguracion.reset();
}

function sel(id){

    var id = 1;

    var idconfig = id;
   
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Configure/getConfigure/'+idconfig;

    
    request.open("GET",ajaxUrl,true);
    request.send();


    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
    
         
            if(objData.status)
            {
            // console.log(objData)
            document.querySelector('#idConfig').value = objData.data.id;
            document.querySelector('#nombre_empresa').value = objData.data.nombre_negocio;
            document.querySelector('#ruc').value = objData.data.ruc;
            document.querySelector('#direccion').value = objData.data.direccion;
            document.querySelector('#telefono').value = objData.data.telefono;
            document.querySelector('#razon_social').value = objData.data.razon_social;
            document.querySelector('#serie_boleta').value = objData.data.serie_boleta;
            document.querySelector('#serie_factura').value = objData.data.serie_factura;
            document.querySelector('#correo_electronico').value = objData.data.correoElectronico;
            document.querySelector('#ruta').value = objData.data.ruta;
            document.querySelector('#token').value = objData.data.token;
            document.querySelector('#id_detraccion').value = objData.data.id_detraccion;
            document.querySelector('#tarifa').value = objData.data.estadia_dias_horas;
            }else{
                swal("Atencion",objData.msg,"error");
            }
        }
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