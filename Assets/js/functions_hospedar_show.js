document.addEventListener(
  'DOMContentLoaded',
  function () {
    Swal.fire({
      title: 'Por favor espere',
      text: 'Procesando...',
      timer: 700,
      icon: 'info',
      allowOutsideClick: false,
      allowEscapeKey: false,
    });
    Swal.showLoading();
  },
  false
);

window.addEventListener(
  'load',
  () => {
    mediosPago();
  },
  false
);

function guardarAuemntoEstadia(id) {
  let formReserva = document.querySelector('#formEstadia');
  event.preventDefault();

  let tarifas = document.querySelector('#idTarifas').value;
  var allValores = Array.from(document.getElementsByName('inlineRadioOptions'));
  var seleccionado = allValores.map(function (valor) {
    seleccion = valor.checked;
    return { seleccion };
  });

  if (tarifas == null || tarifas == 0) {
    Swal.fire('Atencion', 'Es obligatorio seleccionar una tarifa', 'error');
  } else {
    for (var i = 0; i < seleccionado.length; i++) {
      var obj1 = seleccionado[i].seleccion;
      if (obj1 == true) {
        let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Reservations/setAumentoDeReservacion';
        let formData = new FormData(formReserva);
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              Swal.fire('Reservacion', objData.msg, 'success');
              window.location = base_url + '/Hospedar/show?id=' + id;
            }
          }
        };
      }
    }
  }
}

function mediosPago() {
  let ajaxUrl = base_url + '/CashRegisterMovements/getSelectMediosPago';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector('#medio_pago').innerHTML = request.responseText;
      document.querySelector('#medio_pago').value = 1;
    }
  };
}

function pagar(idcomprobante, montoFaltante) {
  Swal.fire({
    title: 'Por favor espere',
    text: 'Procesando...',
    timer: 700,
    icon: 'info',
    allowOutsideClick: false,
    allowEscapeKey: false,
  });
  Swal.showLoading();
  var monto = document.getElementById('total_pago').value;
  var idReservacion = document.getElementById('idReservacion').value;
  let formReservationPayment = document.querySelector('#formReservationPayment');
  if (monto == null || monto == '') {
    event.preventDefault();
    Swal.fire('Atencion', 'Ingresar monto', 'error');
  }
  // else if (monto != montoFaltante) {
  //   Swal.fire('Atencion', 'El monto ingresado debe ser igual al total de la reserva', 'error');
  // }
  else if (idcomprobante == 1) {
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Reservations/setPayReservations/' + idcomprobante;
    let formData = new FormData(formReservationPayment);
    request.open('POST', ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status === true) {
          Swal.fire('FACTURA', objData.msg, 'success');
          window.open(base_url + '/prints/facturares?id=' + idReservacion, '_blank');
          window.location = base_url + '/hospedar/show?id=' + idReservacion;
        } else {
          Swal.fire('FACTURA', objData.msg, 'error');
        }
      }
    };
  } else if (idcomprobante == 2) {
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Reservations/setPayReservations/' + idcomprobante;
    let formData = new FormData(formReservationPayment);
    request.open('POST', ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData.status === true) {
          Swal.fire('BOLETA', objData.msg, 'success');
          window.open(base_url + '/prints/boletares?id=' + idReservacion, '_blank');
          window.location = base_url + '/hospedar/show?id=' + idReservacion;
        } else {
          Swal.fire('BOLETA', objData.msg, 'error');
        }
      }
    };
  } else if (idcomprobante == 3) {
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Reservations/setPayReservations/' + idcomprobante;
    let formData = new FormData(formReservationPayment);
    request.open('POST', ajaxUrl, true);
    request.send(formData);
    // console.log(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        Swal.fire('TICKET', objData.msg, 'success');
        if (objData.status === true) {
          window.open(base_url + '/prints/ticketres?id=' + idReservacion, '_blank');
          window.location = base_url + '/hospedar/show?id=' + idReservacion;
        } else {
          Swal.fire('TICKET', objData.msg, 'error');
        }
      }
    };
  }
}

function precuenta(idReservacion) {
  event.preventDefault();
  Swal.fire({
    title: 'Por favor espere',
    text: 'Procesando...',
    timer: 700,
    icon: 'info',
    allowOutsideClick: false,
    allowEscapeKey: false,
  });
  Swal.showLoading();
  window.open(base_url + '/prints/precuenta?id=' + idReservacion, '_blank');
}

function openCreate() {
  location.href = base_url + '/Reservations/create';
}

function cambiarEstadoHabitacion() {
  // let btnCambiarEstado = document.querySelector("#btnCambiarEstado").value;
  let estado = document.querySelector('#estado').value;
  let habitacionesid = document.querySelector('#habitacionesid').value;
  let id = document.querySelector('#idReservacion').value;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + `/Reservations/cambiarEstado/${id}`;
  request.open('POST', ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let res = JSON.parse(request.responseText);
      window.location = base_url + '/hospedar';
    }
  };
}
function cambiarEstadoHabitacionCheckIn() {
  // let btnCambiarEstado = document.querySelector("#btnCambiarEstado").value;
  let estado = document.querySelector('#estado').value;
  let habitacionesid = document.querySelector('#habitacionesid').value;
  let id = document.querySelector('#idReservacion').value;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + `/Reservations/cambiarEstadoCheckIn/${id}`;
  request.open('POST', ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let res = JSON.parse(request.responseText);
      window.location = base_url + '/hospedar';
    } else {
      Swal.fire({
        title: 'Aun no llega el momento',
        text: 'La fecha de inicio no es la de hoy',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        // cancelButtonColor: '#d33',
        confirmButtonText: 'ok',
      }).then(() => {
        console.log('jajaj ctm');
        window.location = base_url + '/hospedar';
      });
      console.log('no se permite el ingreso');
    }
  };
}

function AnularReservacion(id_reservacion) {
  var id_reservacion = id_reservacion;
  //console.log(id_reservacion)
  Swal.fire({
    title: 'Anular Reservacion',
    text: '¿Desea anular la reservacion?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/Reservations/delReservation';
      var strData = 'id_reservacion=' + id_reservacion;
      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            Swal.fire('Reservacion', objData.msg, 'success');
            tableReservation.api().ajax.reload();
          } else {
            Swal.fire('Reservacion', objData.msg, 'error');
          }
        }
      };
    }
  });
}

function searchCambiarCliente() {
  if ($('#identificacion').val().length == 8) {
    var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Api/getDni?dni=' + $('#identificacion').val();
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData != null) {
          $('#nombre').val(objData.nombres + ' ' + objData.apellidoPaterno + ' ' + objData.apellidoMaterno);
        } else {
        }
      }
    };
  } else if ($('#identificacion').val().length == 11) {
    var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Api/getRUC?ruc=' + $('#identificacion').val();
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData != null) {
          $('#nombre').val(objData.nombre);
        } else {
        }
      }
    };
  }
}

function agregarConsumoHabitacion() {
  $('#modalHospedarConsumo').modal('show');
}

var impuesto = 18;
var cont = 0;
var detalles = 0;
var cliente = 0;
function agregarBusquedaCliente() {
  event.preventDefault();
  let identificacion = document.querySelector('#identificacion').value;
  let name_customer = document.querySelector('#nombre_cliente').value;
  $('#clientes').val(name_customer);
  $('#identificacion_cliente').val(identificacion);
}

function agregarProducto(productoid, nombre, precio_venta) {
  var cantidad = 1;
  if (productoid != '') {
    var subtotal = cantidad * precio_venta;
    var fila =
      '<tr id="fila' +
      cont +
      '">' +
      '<td><button type="button" class="btn btn-light btn-sm" style="border-radius:10px"  onclick="eliminarDetalle(' +
      cont +
      ')"><i style="color:red;" class="mdi mdi-delete"></i></button></td>' +
      '<td><input  type="hidden" id="idarticulo[]" name="idarticulo[]" value="' +
      productoid +
      '">' +
      nombre +
      '</td>' +
      '<td><input onkeyup="this.value=num(this.value)" onchange="modificarSubtotales()" class="form-control"  type="text" style="width:50px;" name="cantidad[]" id="cantidad[]" value="' +
      cantidad +
      '"></td>' +
      '<td><input onkeyup="this.value=numeros(this.value)" onchange="modificarSubtotales()" class="form-control" type="text" style="width:50px;" name="precio_venta[]" id="precio_venta[]" value="' +
      precio_venta +
      '"></td>' +
      '<td><span id="subtotal' +
      cont +
      '" name="subtotal">' +
      subtotal +
      '</span></td>';
    cont++;
    detalles++;
    $('#detalles').append(fila);
    modificarSubtotales();
  } else {
    Swal.fire('Error al ingresar al detalle', 'Revisar producto', 'error');
  }
}

function modificarSubtotales() {
  var cant = document.getElementsByName('cantidad[]');
  var prev = document.getElementsByName('precio_venta[]');
  var sub = document.getElementsByName('subtotal');

  for (var i = 0; i < cant.length; i++) {
    var inpV = cant[i];
    var inpP = prev[i];
    var inpS = sub[i];
    inpS.value = inpV.value * inpP.value;
    inpSRounded = inpS.value;
    document.getElementsByName('subtotal')[i].innerHTML = inpSRounded.toFixed(2);
  }
  calcularTotales();
}

function calcularTotales() {
  var sub = document.getElementsByName('subtotal');
  var total = 0.0;
  var igv = 0.0;
  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName('subtotal')[i].value;
    var base = total / 1.1;
    igv = total - base;
    var rounded = +igv.toFixed(2);
    var rounded_total = +total.toFixed(2);
    var rounded_base = +base.toFixed(2);
  }
  $('#total_consumo').html('S/. ' + rounded_total);
  $('#total_venta').val(rounded_total);
  $('#subtotal').html('S/. ' + rounded_base);
  $('#subtotal_venta').val(rounded_base);
  $('#impuestos').html('S/. ' + rounded);
  $('#impuestos_venta').val(rounded);
}

var contPago = 0;
var detallesPago = 0;

function agregarPago() {
  var ingresoMonto = document.getElementById('montoPago').value;
  if (ingresoMonto == null || ingresoMonto == '') {
    Swal.fire('Atencion', 'Debe ingresar el monto', 'error');
  } else {
    var cantidad = 1;
    var total = document.getElementById('montoPago').value;
    var mediopagoid = document.getElementById('medio_pago').value;
    var medio_pago = $('select[name="medio_pago"] option:selected').text();
    var tablamediopago = document.getElementById('tablamediopago');
    tablamediopago.style.removeProperty('display');

    var fila =
      '<tr id="filaPago' +
      contPago +
      '">' +
      '<td><button type="button" class="btn btn-light btn-sm" style="border-radius:10px" onclick="eliminarDetallePago(' +
      contPago +
      ')"><i style="color:red;" class="mdi mdi-delete"></i></button></td>' +
      '<td><input type="hidden" id="idmediopago[]" name="idmediopago[]" value="' +
      mediopagoid +
      '">' +
      medio_pago +
      '</td>' +
      '<td style="display:none"><input type="hidden" id="cantidadPago[]" name="cantidadPago[]" value="' +
      cantidad +
      '"></td>' +
      '<td><input onkeyup="this.value=numeros(this.value)" onchange="modificarSubtotalesPago()" class="form-control" type="text" style="width:80px;" name="totalPago[]" id="totalPago[]" value="' +
      total +
      '"></td>' +
      '<td><span id="subtotalPago' +
      contPago +
      '" name="subtotalPago">' +
      total +
      '</span></td>';
    contPago++;
    detallesPago++;
    $('#detallesPago').append(fila);
    document.getElementById('montoPago').value = '';

    modificarSubtotalesPago();
  }
}

function eliminarDetallePago(indice) {
  $('#filaPago' + indice).remove();
  calcularTotalesPago();
  detallesPago = detallesPago - 1;
  if (detallesPago == 0) {
    var tablaPago = document.getElementById('tablamediopago');
    tablaPago.style.display = 'none';
  }
}

function eliminarDetalle(indice) {
  $('#fila' + indice).remove();
  calcularTotales();
  detalles = detalles - 1;
  if (detalles == 0) {
    var totalConsumo = document.getElementById('total_consumo');
    var impuestos = document.getElementById('impuestos');
    var subtotal = document.getElementById('subtotal');
    totalConsumo.style.display = 'none';
    impuestos.style.display = 'none';
    subtotal.style.display = 'none';
  }
}

function modificarSubtotalesPago() {
  var cant = document.getElementsByName('cantidadPago[]');
  var prev = document.getElementsByName('totalPago[]');
  var sub = document.getElementsByName('subtotalPago');
  for (var i = 0; i < cant.length; i++) {
    var inpV = cant[i];
    var inpP = prev[i];
    var inpS = sub[i];
    inpS.value = inpV.value * inpP.value;
    inpSRounded = inpS.value;
    document.getElementsByName('subtotalPago')[i].innerHTML = inpSRounded.toFixed(2);
  }
  calcularTotalesPago();
}

function calcularTotalesPago() {
  var sub = document.getElementsByName('subtotalPago');
  var total = 0.0;
  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName('subtotalPago')[i].value;
  }
  $('#total_pago').html('S/. ' + total);
  $('#total_pago').val(total);
}

function agregarClienteReservacion(idUsuario, idReserva) {
  event.preventDefault();
  let identificacion = document.querySelector('#identificacion').value;
  let nombre = document.querySelector('#nombre').value;
  let correo = document.querySelector('#correo').value;
  let direccion = document.querySelector('#direccion').value;
  let documento = parseInt(identificacion.length);
  if (nombre == '' || correo == '' || direccion == '' || identificacion == '') {
    Swal.fire('Atencion', 'El campo es obligatorio', 'error');
    return false;
  } else if (documento == 8 || documento == 11) {
    let formReservationPayment = document.querySelector('#formReservationPayment');
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Reservations/addClienteReservacion/' + idUsuario;
    let formData = new FormData(formReservationPayment);
    request.open('POST', ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          Swal.fire('Reservacion', objData.msg, 'success');
          window.location = base_url + '/hospedar/show?id=' + idReserva;
        }
      }
    };
  } else {
    Swal.fire('Atencion', 'Ingrese un documento valido', 'error');
    return false;
  }
}

function pagarConsumo(id) {
  var formHospedarConsumo = document.querySelector('#formHospedarConsumo');
  event.preventDefault();
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Reservations/setConsumo';
  let formData = new FormData(formHospedarConsumo);
  request.open('POST', ajaxUrl, true);
  request.send(formData);
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      Swal.fire('CONSUMO', objData.msg, 'success');
      //  console.log(objData.data);
      window.open(base_url + '/prints/comanda?id=' + objData.data, '_blank');
      window.location = base_url + '/hospedar/show?id=' + id;
    }
  };
}
function retornarProductos(detalleConsumo, idConsumo, idReservacion) {
  event.preventDefault();
  Swal.fire({
    title: 'Eliminar Consumo',
    text: '¿Desea eliminar el Consumo?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/Reservations/retonarConsumo/' + detalleConsumo;
      var strData = 'idConsumo=' + idConsumo;
      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);
          if (objData.status) {
            Swal.fire('Consumo', objData.msg, 'success');
            window.location = base_url + '/hospedar/show?id=' + idReservacion;
          } else {
            wal.fire('Reservacion', objData.msg, 'error');
          }
        }
      };
    }
  });
}

function desecharProductos(idDetalleConsumo, idConsumo, cantidad) {
  event.preventDefault();
  document.querySelector('#iddetalle_desechable').value = idDetalleConsumo;
  document.querySelector('#idconsumo_desechable').value = idConsumo;
  document.querySelector('#cantidad_desechable').value = cantidad;
  $('#modalDesecharConsumo').modal('show');
}

function seleccionarDescuento() {
  event.preventDefault();
  var seleccionDescuento = document.getElementById('descuentos').value;
  var monto = document.getElementById('montoDescuento');
  var porcentaje = document.getElementById('porcentajeDescuento');
  if (seleccionDescuento == 1) {
    monto.style.removeProperty('display');
    porcentaje.style.display = 'none';
  } else if (seleccionDescuento == 2) {
    porcentaje.style.removeProperty('display');
    monto.style.display = 'none';
  }
}

function calcularDescuento(id, montoReserva) {
  var seleccion = document.getElementById('descuentos').value;
  var montoAument = document.getElementById('mtnDesc').value;
  var porcentajeAument = document.getElementById('pctjDesc').value;
  totalReserva = Number(montoReserva);
  monto = Number(montoAument);
  porcentaje = Number(porcentajeAument);
  if (seleccion != 0) {
    if (seleccion == 1) {
      if (monto == null || monto == '') {
        Swal.fire('Atencion', 'Ingresar el monto a descontar', 'error');
        return false;
      } else {
        if (monto > totalReserva) {
          Swal.fire('Atencion', 'El descuento no puede ser mayor al total de la reserva', 'error');
          return false;
        } else {
          montoActual = totalReserva - monto;
          // console.log(montoActual);
          let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
          let ajaxUrl = base_url + '/Reservations/almacenarDescuento/' + monto;
          var strData = 'idReserva=' + id;
          // console.log(ajaxUrl);
          request.open('POST', ajaxUrl, true);
          request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          request.send(strData);

          request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
              let objData = JSON.parse(request.responseText);
              if (objData.status) {
                Swal.fire('Descuento', objData.msg, 'success');
                window.location = base_url + '/hospedar/show?id=' + id;
              }
            }
          };
        }
      }
    } else if (seleccion == 2) {
      if (porcentaje == null || porcentaje == '') {
        Swal.fire('Atencion', 'Ingrese el porcentaje a descontar', 'error');
        return false;
      } else {
        if (porcentaje > 100) {
          Swal.fire('Atencion', 'No hay descuentos mayores a 100%', 'error');
          return false;
        } else {
          actualPorcentaje = porcentaje / 100;
          // console.log(actualPorcentaje);
          descuento = totalReserva * actualPorcentaje;
          montoActual = totalReserva - descuento;
          // console.log(montoActual);

          let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
          let ajaxUrl = base_url + '/Reservations/almacenarDescuento/' + descuento;
          var strData = 'idReserva=' + id;
          // console.log(ajaxUrl);
          request.open('POST', ajaxUrl, true);
          request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          request.send(strData);

          request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
              let objData = JSON.parse(request.responseText);
              if (objData.status) {
                Swal.fire('Descuento', objData.msg, 'success');
                window.location = base_url + '/hospedar/show?id=' + id;
              }
            }
          };
        }
      }
    } else {
      Swal.fire('Atencion', 'No existe esa seleccion en la funcion calcularDescuento', 'error');
      return false;
    }
  } else {
    Swal.fire('Atencion', 'Seleccionar Descuento por monto o porcentaje', 'error');
    return false;
  }
}

function eliminarDescuento(id, descuento) {
  event.preventDefault();
  Swal.fire({
    title: 'Eliminar Consumo',
    text: '¿Desea eliminar el Consumo?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url + '/Reservations/actualizarPrecioReserva/' + descuento;
      var strData = 'id=' + id;
      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          let objData = JSON.parse(request.responseText);
          Swal.fire('Descuento Eliminado', objData.msg, 'success');
          window.location = base_url + '/hospedar/show?id=' + id;
        }
      };
    }
  });
}

function agregarAumentoEstadia() {
  $('#modalEstadia').modal('show');
}

function tarifario() {
  var tarifa = document.getElementById('idTarifas').value;
  var horas_reserva = document.getElementById('horas_reserva');
  var dias_reserva = document.getElementById('dias_reserva');
  var titulo_precios = document.getElementById('precios');
  var estadia_tarifas = document.getElementById('tiempoDeTarifas');
  titulo_precios.style.removeProperty('display');
  calculo = 0;
  total = 0;
  $('#total').html('S/. ' + calculo.toFixed(2));
  $('#total_actual').html('S/. ' + total.toFixed(2));

  if (tarifa == 1) {
    habitacionHoras(tarifa);
    document.getElementById('precios-tarifa').innerHTML = '';
    horas_reserva.style.removeProperty('display');
    dias_reserva.style.display = 'none';
    estadia_tarifas.style.display = 'none';
  } else if (tarifa == 2) {
    habitacionDias(tarifa);
    document.getElementById('precios-tarifa').innerHTML = '';
    dias_reserva.style.removeProperty('display');
    horas_reserva.style.display = 'none';
    estadia_tarifas.style.display = 'none';
  } else {
    habitacionTarifa(tarifa);
    document.getElementById('precios-tarifa').innerHTML = '';
    estadia_tarifas.style.removeProperty('display');
    dias_reserva.style.display = 'none';
    horas_reserva.style.display = 'none';
  }
}

function habitacionTarifa(tarifa) {
  let id = document.getElementById('idhabitacion').value;
  var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/Hospedar/preciosTarifa/' + tarifa;
  var strData = 'id=' + id;

  request.open('POST', ajaxUrl, true);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.send(strData);

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      for (var i = 0; i < objData.length; i++) {
        let datos = objData[i];
        id = datos['idPrecioHabitacion'];
        precio = datos['precio'];
        dias = datos['dias'];
        horas = datos['horas'];
        minutos = datos['minutos'];
        $('#precios-tarifa').append(
          '<div class="form-check form-check-inline"><input onchange="precioSeleccionadoTarifas()" class="form-check-input" type="radio" name="inlineRadioOptions" id="' +
            id +
            '" value="' +
            id +
            '" precio="' +
            precio +
            '" dias="' +
            dias +
            '" horas="' +
            horas +
            '" minutos="' +
            minutos +
            '"><label class="form-check-label" for="' +
            id +
            '">' +
            precio +
            '</label></div>'
        );
      }
      // alert(id, precio);
    }
  };
}

function habitacionDias(tarifa) {
  let id = document.getElementById('idhabitacion').value;
  var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/Hospedar/preciosTarifa/' + tarifa;
  var strData = 'id=' + id;

  request.open('POST', ajaxUrl, true);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.send(strData);

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      for (var i = 0; i < objData.length; i++) {
        let datos = objData[i];
        id = datos['idPrecioHabitacion'];
        precio = datos['precio'];
        dias = datos['dias'];
        horas = datos['horas'];
        minutos = datos['minutos'];

        $('#precios-tarifa').append(
          '<div class="form-check form-check-inline"><input onchange="precioSeleccionadoDias()" class="form-check-input" type="radio" name="inlineRadioOptions" id="' +
            id +
            '" value="' +
            id +
            '" precio="' +
            precio +
            '" dias="' +
            dias +
            '" horas="' +
            horas +
            '" minutos="' +
            minutos +
            '"><label class="form-check-label" for="' +
            id +
            '">' +
            precio +
            '</label></div>'
        );
      }
      // alert(id, precio);
    }
  };
}

function habitacionHoras(tarifa) {
  let id = document.getElementById('idhabitacion').value;
  var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/Hospedar/preciosTarifa/' + tarifa;
  var strData = 'id=' + id;

  request.open('POST', ajaxUrl, true);
  request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  request.send(strData);

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      for (var i = 0; i < objData.length; i++) {
        let datos = objData[i];
        id = datos['idPrecioHabitacion'];
        precio = datos['precio'];
        dias = datos['dias'];
        horas = datos['horas'];
        minutos = datos['minutos'];

        $('#precios-tarifa').append(
          '<div class="form-check form-check-inline"><input onchange="precioSeleccionadoHoras()" class="form-check-input" type="radio" name="inlineRadioOptions" id="' +
            id +
            '" value="' +
            id +
            '" precio="' +
            precio +
            '" dias="' +
            dias +
            '" horas="' +
            horas +
            '" minutos="' +
            minutos +
            '"><label class="form-check-label" for="' +
            id +
            '">' +
            precio +
            '</label></div>'
        );
      }
      // alert(id, precio);
    }
  };
}

function precioSeleccionadoTarifas() {
  var allValores = Array.from(document.getElementsByName('inlineRadioOptions'));

  var seleccionado = allValores.map(function (valor) {
    seleccion = valor.checked;
    id = valor.id;
    return { seleccion, id };
  });

  for (var i = 0; i < seleccionado.length; i++) {
    var obj1 = seleccionado[i].seleccion;
    var obj2 = seleccionado[i].id;
    if (obj1 == true) {
      var datos = document.getElementById(obj2);
      var precio = datos.getAttribute('precio');
      var dias = datos.getAttribute('dias');
      var horas = datos.getAttribute('horas');
      var minutos = datos.getAttribute('minutos');
      $('#tiempoDias').val(dias);
      $('#tiempoHoras').val(horas);
      $('#tiempoMinutos').val(minutos);
      $('#totales').val(precio);
      $('#diaTar').html(dias);
      $('#horaTar').html(horas);
      $('#minTar').html(minutos);
      calcularTarifa();
    }
  }
}

function precioSeleccionadoDias() {
  var allValores = Array.from(document.getElementsByName('inlineRadioOptions'));

  var seleccionado = allValores.map(function (valor) {
    seleccion = valor.checked;
    id = valor.id;
    return { seleccion, id };
  });

  for (var i = 0; i < seleccionado.length; i++) {
    var obj1 = seleccionado[i].seleccion;
    var obj2 = seleccionado[i].id;
    if (obj1 == true) {
      var datos = document.getElementById(obj2);
      var precio = datos.getAttribute('precio');
      var dias = datos.getAttribute('dias');
      var horas = datos.getAttribute('horas');
      var minutos = datos.getAttribute('minutos');
      $('#tiempoDias').val(dias);
      $('#tiempoHoras').val(horas);
      $('#tiempoMinutos').val(minutos);
      $('#totales').val(precio);
      calcularFecha();
    }
  }
}

function precioSeleccionadoHoras() {
  var allValores = Array.from(document.getElementsByName('inlineRadioOptions'));

  var seleccionado = allValores.map(function (valor) {
    seleccion = valor.checked;
    id = valor.id;
    return { seleccion, id };
  });

  for (var i = 0; i < seleccionado.length; i++) {
    var obj1 = seleccionado[i].seleccion;
    var obj2 = seleccionado[i].id;
    if (obj1 == true) {
      var datos = document.getElementById(obj2);
      var precio = datos.getAttribute('precio');
      var dias = datos.getAttribute('dias');
      var horas = datos.getAttribute('horas');
      var minutos = datos.getAttribute('minutos');
      $('#tiempoDias').val(dias);
      $('#tiempoHoras').val(horas);
      $('#tiempoMinutos').val(minutos);
      $('#totales').val(precio);
      calcularHoras();
    }
  }
}
function calcularTarifa() {
  var diasTarifa = document.getElementById('tiempoDias').value;
  var horasTarifa = document.getElementById('tiempoHoras').value;
  var minutosTarifa = document.getElementById('tiempoMinutos').value;
  var totalReserva = parseFloat(document.getElementById('total_reserva').value);

  var calculo = parseFloat(document.getElementById('totales').value);

  total = calculo + totalReserva;

  console.log(total);

  $('#total').html('S/. ' + calculo);
  $('#total_aumento').val(calculo);
  $('#diasTotal').val(diasTarifa);
  $('#horasTotal').val(horasTarifa);
  $('#minutosTotal').val(minutosTarifa);
  $('#montoActualReservacion').val(total);
  $('#total_actual').html('S/. ' + total.toFixed(2));
}

function calcularFecha() {
  var days = 0;
  let ingreso = document.getElementById('ingreso').value;
  let salida = document.getElementById('salida').value;
  var totalReserva = parseFloat(document.getElementById('total_reserva').value);

  var day1 = new Date(ingreso);
  var day2 = new Date(salida);

  var difference = Math.abs(day2 - day1);
  days = difference / (1000 * 3600 * 24);

  var diasTarifa = document.getElementById('tiempoDias').value;
  var diasTotal = days * diasTarifa;

  var totales = parseFloat(document.getElementById('totales').value);
  var calculo = totales * diasTotal;
  total = calculo + totalReserva;
  console.log(total);

  $('#tiempo').html(days);
  $('#total').html('S/. ' + calculo.toFixed(2));
  $('#total_aumento').val(calculo);
  $('#diasTotal').val(diasTotal);
  $('#montoActualReservacion').val(total);
  $('#total_actual').html('S/. ' + total.toFixed(2));
}

function calcularHoras() {
  var horas = 1;
  var horas = document.getElementById('horas').value;
  var horasTarifa = document.getElementById('tiempoHoras').value;
  var totalReserva = parseFloat(document.getElementById('total_reserva').value);

  var horasTotal = horas * horasTarifa;

  var totales = parseFloat(document.getElementById('totales').value);
  var calculo = totales * horasTotal;
  total = calculo + totalReserva;

  console.log(total);

  $('#total').html('S/. ' + calculo.toFixed(2));
  $('#total_aumento').val(calculo);
  $('#horasTotal').val(horasTotal);
  $('#montoActualReservacion').val(total);
  $('#total_actual').html('S/. ' + total.toFixed(2));
}
function eliminarAumentoEstadia(detalleConsumo, idConsumo, idReservacion) {
  event.preventDefault();
  // console.log(idEstadia, idReservacion);
  Swal.fire({
    title: 'Eliminar Servicio',
    text: '¿Desea el aumento de estadia?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/Reservations/delAumentoEstadia/' + detalleConsumo;
      var strData = 'idConsumo=' + idConsumo;
      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);

          if (objData.status) {
            Swal.fire('SERVICIO', objData.msg, 'success');
            window.location = base_url + '/hospedar/show?id=' + idReservacion;
          } else {
            Swal.fire('SERVICIO', objData.msg, 'error');
          }
        }
      };
    }
  });
}

function eliminarServicio(detalleConsumo, idConsumo, idReservacion) {
  event.preventDefault();
  Swal.fire({
    title: 'Eliminar Servicio',
    text: '¿Desea eliminar el servicio?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/Reservations/delServicio/' + detalleConsumo;
      var strData = 'idConsumo=' + idConsumo;
      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);

          if (objData.status) {
            Swal.fire('SERVICIO', objData.msg, 'success');
            window.location = base_url + '/hospedar/show?id=' + idReservacion;
          } else {
            Swal.fire('SERVICIO', objData.msg, 'error');
          }
        }
      };
    }
  });
}

function numeros(string) {
  //Solo numeros
  var out = '';
  var filtro = '1234567890.'; //Caracteres validos

  //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos
  for (var i = 0; i < string.length; i++)
    if (filtro.indexOf(string.charAt(i)) != -1)
      //Se añaden a la salida los caracteres validos
      out += string.charAt(i);

  //Retornar valor filtrado
  return out;
}

function num(string) {
  //Solo numeros
  var out = '';
  var filtro = '1234567890'; //Caracteres validos

  //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos
  for (var i = 0; i < string.length; i++)
    if (filtro.indexOf(string.charAt(i)) != -1)
      //Se añaden a la salida los caracteres validos
      out += string.charAt(i);

  //Retornar valor filtrado
  return out;
}
