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
}, false);

function openCreate(){
    window.location.href = base_url+"/sales/crear";
}

window.addEventListener('load', () => {
    mediosPago();
    
 },false);

function searchHuesped(){
    
  if ($('#identificacion').val().length == 8) {
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url+'/Api/getDni?dni='+$('#identificacion').val();
      request.open("GET", ajaxUrl, true);
      request.send();
      request.onreadystatechange = function () {
           if(request.readyState == 4 && request.status == 200)
              {
                  var objData = JSON.parse(request.responseText);
                  if(objData != null){
                      $('#nombre_cliente').val(objData.nombres+' '+objData.apellidoPaterno+' '+objData.apellidoMaterno);
                  }else{
                    
                  }
              }       
      }
  }else if($('#identificacion').val().length == 11){
      var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url+'/Api/getRUC?ruc='+$('#identificacion').val();
      request.open("GET", ajaxUrl, true);
      request.send();
      request.onreadystatechange = function () {
          if(request.readyState == 4 && request.status == 200)
              {
                  var objData = JSON.parse(request.responseText);
                  if(objData != null){
                      $('#nombre_cliente').val(objData.nombre);
                  }else{
                    
                  }
              }  
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
            document.querySelector('#medio_pago').innerHTML = request.responseText;
            document.querySelector('#medio_pago').value = 1;
        }
    }
}
 
 var impuesto=18;
 var cont= 0;
 var detalles=0;

 var cliente = 0;

function agregarProducto(productoid, nombre, precio_venta) {
    var cantidad = 1;
      
    if(productoid != ""){ 
        var subtotal = cantidad * precio_venta;
        var fila = '<tr id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-light btn-sm" style="border-radius:10px" onclick="eliminarDetalle('+cont+')"><i style="color:red;" class="mdi mdi-delete"></i></button></td>'+
        '<td><input type="hidden" id="idarticulo[]" name="idarticulo[]" value="'+productoid+'">'+nombre+'</td>'+
        '<td><input onkeyup="this.value=num(this.value)" onchange="modificarSubtotales()" class="form-control"  type="text" style="width:50px;" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><input onkeyup="this.value=numeros(this.value)" onchange="modificarSubtotales()" class="form-control" type="text" style="width:50px;" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
        '<td><span id="subtotal'+cont+'" name="subtotal">'+subtotal+'</span></td>';
        cont++;
        detalles++;
        $('#detalles').append(fila);
        // console.log(productoid)
        modificarSubtotales();
       // calcularTotales();
    }else{
        Swal.fire("Error al ingresar al detalle","Revisar producto","error");
    }
  }

function modificarSubtotales(){
	var cant=document.getElementsByName("cantidad[]");
	var prev=document.getElementsByName("precio_venta[]");
	var sub=document.getElementsByName("subtotal");


	for (var i = 0; i < cant.length; i++) {
        var inpV=cant[i];
        var inpP=prev[i];
        var inpS=sub[i];
		
        inpS.value=(inpV.value*inpP.value);

        inpSRounded = inpS.value;

		    document.getElementsByName("subtotal")[i].innerHTML=inpSRounded.toFixed(2);
	}
    calcularTotales();
}

function calcularTotales(){
	  var sub = document.getElementsByName("subtotal");
	  var total=0.0;
    var igv = 0.0;


    // TODO: CAMBIAR IGV 

	  for (var i = 0; i < sub.length; i++) {
        total += (document.getElementsByName("subtotal")[i].value);
        // console.log(total)
      
        var base = (total)/110 * 100;
        igv = (total/110)*10
        // console.log(igv)

        var rounded = +igv.toFixed(2);
        var rounded_total = +total.toFixed(2);
        var rounded_base = +base.toFixed(2);

        // console.log(rounded_base);
        // console.log(rounded_total);
        // console.log(rounded);

	  }
    $("#total").html("S/. "+rounded_total);
	  $("#total_venta").val(rounded_total);
	  $("#subtotal").html("S/. "+rounded_base);
	  $("#subtotal_venta").val(rounded_base);
    $("#impuestos").html("S/. "+rounded);
	  $("#impuestos_venta").val(rounded);
}

function pagar(idcomprobante){
    var monto = document.getElementById("total_pago").value;
    var totalPago = document.getElementById("total_venta").value
    let formSale = document.querySelector("#formSale");
    event.preventDefault();
    if(monto == null || monto == ''){
      event.preventDefault();
      Swal.fire('Atencion','Ingresar monto', "error")
        }else 
          if(monto != totalPago){
            Swal.fire('Atencion','El monto ingresado no puede ser mayor ni menor al monto a pagar', "error")
          }else 
            if(idcomprobante == 1){   
              let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
              let ajaxUrl = base_url+'/Sales/setSales/'+idcomprobante;
              let formData = new FormData(formSale);
              request.open("POST",ajaxUrl,true);
              request.send(formData);
              request.onreadystatechange = function(){
                  if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.status ===  true){
                      Swal.fire("FACTURA",objData.msg,"success");
                      window.open(base_url+'/prints/facturasales?id='+objData.data,'_blank');
                      window.location = base_url+'/sales';
                    }else{
                      Swal.fire("FACTURA",objData.msg,"error");
                    }  
                  }
              }
            }else 
              if(idcomprobante == 2){
                let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url+'/Sales/setSales/'+idcomprobante;
                let formData = new FormData(formSale);
                request.open("POST",ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        var objData = JSON.parse(request.responseText);
                        console.log(objData);
                        if(objData.status ===  true){
                          Swal.fire("BOLETA",objData.msg,"success");
                          window.open(base_url+'/prints/boletasales?id='+objData.data,'_blank');
                          // window.location = base_url+'/sales';
                        }else{
                        Swal.fire("BOLETA",objData.msg,"error");
                        }  
                    }
                }
              }else 
                if(idcomprobante == 3){
                    console.log("Si es igual al monto a pagar");
                  let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
                  let ajaxUrl = base_url+'/Sales/setSales/'+idcomprobante;
                  let formData = new FormData(formSale);
                  request.open("POST",ajaxUrl,true);
                  request.send(formData);
                  request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                      var objData = JSON.parse(request.responseText);
                      if(objData.status ===  true){
                        Swal.fire("TICKET",objData.msg,"success");    
                        window.open(base_url+'/prints/ticketsales?id='+objData.data,'_blank');
                        window.location = base_url+'/sales';
                      }else{
                        Swal.fire("TICKET",objData.msg,"error");
                      }  
                    }
                  } 
                } 
  }
function eliminarDetalle(indice){
    $("#fila"+indice).remove();
    calcularTotales();
    detalles=detalles-1;
  
    if(detalles==0){
      var totalConsumo = document.getElementById("total");
      var impuestos = document.getElementById("impuestos");
      var subtotal = document.getElementById("subtotal");
      totalConsumo.style.display = 'none';
      impuestos.style.display = 'none';
      subtotal.style.display = 'none';
    }
  }
  
var contPago= 0;
var detallesPago=0;


function agregarPago(){

  var ingresoMonto = document.getElementById("montoPago").value;

  if(ingresoMonto == null || ingresoMonto == ''){
    Swal.fire("Atencion","Debe ingresar el monto","error");
  }else{
      var cantidad = 1;
      var total = document.getElementById("montoPago").value;
      var mediopagoid = document.getElementById("medio_pago").value;
      var medio_pago = $('select[name="medio_pago"] option:selected').text();
    
      // console.log(medio_pago)
      var tablamediopago = document.getElementById("tablamediopago");
      tablamediopago.style.removeProperty("display");
      var fila = '<tr id="filaPago'+contPago+'">'+
      '<td><button type="button" class="btn btn-light btn-sm" style="border-radius:10px" onclick="eliminarDetallePago('+contPago+')"><i style="color:red;" class="mdi mdi-delete"></i></button></td>'+
      '<td><input type="hidden" id="idmediopago[]" name="idmediopago[]" value="'+mediopagoid+'">'+medio_pago+'</td>'+
      '<td style="display:none"><input type="hidden" id="cantidadPago[]" name="cantidadPago[]" value="'+cantidad+'"></td>'+
      '<td><input onkeyup="this.value=numeros(this.value)" onchange="modificarSubtotalesPago()" class="form-control" type="text" style="width:50px;" name="totalPago[]" id="totalPago[]" value="'+total+'"></td>'+
      '<td><span id="subtotalPago'+contPago+'" name="subtotalPago">'+total+'</span></td>';
      contPago++;
      detallesPago++;
      $('#detallesPago').append(fila);

      document.getElementById("montoPago").value = '';

      modificarSubtotalesPago();

  }
  

}
function eliminarDetallePago(indice){
  $("#filaPago"+indice).remove();
  calcularTotalesPago();
  detallesPago=detallesPago-1;

  if(detallesPago==0){
    var tablaPago = document.getElementById("tablamediopago");
    tablaPago.style.display = 'none';
  }
}

function modificarSubtotalesPago(){
	var cant=document.getElementsByName("cantidadPago[]");
	var prev=document.getElementsByName("totalPago[]");
	var sub=document.getElementsByName("subtotalPago");

	for (var i = 0; i < cant.length; i++) {
    var inpV=cant[i];
		var inpP=prev[i];
		var inpS=sub[i];
		inpS.value = (inpV.value * inpP.value);
    inpSRounded = inpS.value;
		document.getElementsByName("subtotalPago")[i].innerHTML=inpSRounded.toFixed(2);
	}
    calcularTotalesPago();
}

function calcularTotalesPago(){
    var sub = document.getElementsByName("subtotalPago");
    var total = 0.0;
    for(var i=0; i < sub.length; i++){
        total += (document.getElementsByName("subtotalPago")[i].value);
    // console.log(total);
    }
    $("#total_pago").html("S/. " + total);
    $("#total_pago").val(total);
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
  
  function num(string){//Solo numeros
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