document.addEventListener('DOMContentLoaded', function () {
  Swal.fire({
    title: 'Por favor espere',
    text: 'Procesando...',
    timer: 700,
    icon: 'info',
    allowOutsideClick: false,
    allowEscapeKey: false,
  });
  Swal.showLoading();
});
function guardarReservacion() {
  let formReserva = document.querySelector('#formReserva');
  // alert(formReserva);
  event.preventDefault();

  let tarifas = document.querySelector('#idTarifas').value;
  let identificacion = document.querySelector('#identificacion').value;
  let nombre = document.querySelector('#huesped').value;
  let documento = identificacion.length;
  var allValores = Array.from(document.getElementsByName('inlineRadioOptions'));
  var seleccionado = allValores.map(function (valor) {
    seleccion = valor.checked;
    return { seleccion };
  });
  // console.log(tarifas);
  if (tarifas == null || tarifas == 0) {
    Swal.fire('Atencion', 'Es obligatorio seleccionar una tarifa', 'error');
  } else if (nombre == null || nombre == 0 || nombre == '') {
    Swal.fire('Atencion', 'Es obligatorio que contenga un nombre de persona o empresa', 'error');
  } else if (identificacion == null || identificacion == 0 || identificacion == '') {
    Swal.fire('Atencion', 'Es obligatorio que contenga un numero de documento', 'error');
  } else if (documento == 8 || documento == 11) {
    for (var i = 0; i < seleccionado.length; i++) {
      var obj1 = seleccionado[i].seleccion;
      if (obj1 == true) {
        let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Reservations/setReservationsTarifas';
        let formData = new FormData(formReserva);
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        // alert(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              Swal.fire('Reservacion', objData.msg, 'success');
              window.location = base_url + '/Hospedar';
            }
          }
        };
        // return true;
      }
      // else{
      //     Swal.fire("Atencion","Es obligatorio seleccionar un precio","error");
      // }
    }
  } else {
    Swal.fire('Atencion', 'Ingrese un documento valido', 'error');
  }
}

window.addEventListener(
  'load',
  () => {
    originReservation();
    statusReservation();
  },
  false
);

function tarifario() {
  var tarifa = document.getElementById('idTarifas').value;
  var horas_reserva = document.getElementById('horas_reserva');
  var dias_reserva = document.getElementById('dias_reserva');
  var titulo_precios = document.getElementById('precios');
  var estadia_tarifas = document.getElementById('tiempoDeTarifas');
  var reserva_anticipada = document.getElementById('reserva_anticipada');
  titulo_precios.style.removeProperty('display');
  calculo = 0;
  $('#total').html('S/. ' + calculo.toFixed(2));
  // alert(tarifa);
  if (tarifa == 1) {
    habitacionHoras(tarifa);
    document.getElementById('precios-tarifa').innerHTML = '';
    horas_reserva.style.removeProperty('display');
    dias_reserva.style.display = 'none';
    estadia_tarifas.style.display = 'none';
    reserva_anticipada.style.display = 'none';
  } else if (tarifa == 2) {
    habitacionDias(tarifa);
    document.getElementById('precios-tarifa').innerHTML = '';
    dias_reserva.style.removeProperty('display');
    horas_reserva.style.display = 'none';
    estadia_tarifas.style.display = 'none';
    reserva_anticipada.style.display = 'none';
  } else if (tarifa == 5) {
    habitacionAnticipadas(tarifa);
    document.getElementById('precios-tarifa').innerHTML = '';
    reserva_anticipada.style.removeProperty('display');
    horas_reserva.style.display = 'none';
    estadia_tarifas.style.display = 'none';
    dias_reserva.style.display = 'none';
  } else {
    habitacionTarifa(tarifa);
    document.getElementById('precios-tarifa').innerHTML = '';
    estadia_tarifas.style.removeProperty('display');
    dias_reserva.style.display = 'none';
    horas_reserva.style.display = 'none';
    reserva_anticipada.style.display = 'none';
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

function habitacionAnticipadas(tarifa) {
  // alert('jajaj');
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
          '<div class="form-check form-check-inline"><input onchange="precioSeleccionadoDiasAnticipado()" class="form-check-input" type="radio" name="inlineRadioOptions" id="' +
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

function precioSeleccionadoDiasAnticipado() {
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
      calcularFechaanticipada();
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
function verReserva(id_reservacion) {
  window.location.href = base_url + '/Hospedar/show?id=' + id_reservacion;
}

function originReservation() {
  // alert('Hola');
  let ajaxUrl = base_url + '/Hospedar/getOriginReservation';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector('#origen_reserva').innerHTML = request.responseText;
      document.querySelector('#origen_reserva').value = 1;
    }
  };
}

function calcularTarifa() {
  var diasTarifa = document.getElementById('tiempoDias').value;
  var horasTarifa = document.getElementById('tiempoHoras').value;
  var minutosTarifa = document.getElementById('tiempoMinutos').value;

  var calculo = document.getElementById('totales').value;

  $('#total').html('S/. ' + calculo);
  $('#total_reserva').val(calculo);
  $('#total_habitacion').val(calculo);
  $('#diasTotal').val(diasTarifa);
  $('#horasTotal').val(horasTarifa);
  $('#minutosTotal').val(minutosTarifa);
}

function calcularFecha() {
  var days = 0;
  let ingreso = document.getElementById('ingreso').value;
  let salida = document.getElementById('salida').value;

  var day1 = new Date(ingreso);
  var day2 = new Date(salida);

  var difference = Math.abs(day2 - day1);
  days = difference / (1000 * 3600 * 24);

  var diasTarifa = document.getElementById('tiempoDias').value;
  var diasTotal = days * diasTarifa;

  var totales = document.getElementById('totales').value;
  var calculo = totales * diasTotal;

  $('#tiempo').html(days);
  $('#total').html('S/. ' + calculo.toFixed(2));
  $('#total_reserva').val(calculo.toFixed(2));
  $('#total_habitacion').val(calculo.toFixed(2));
  $('#diasTotal').val(diasTotal);
}
function calcularFechaanticipada() {
  var days = 0;
  let ingreso = document.getElementById('ingresoant').value;
  let salida = document.getElementById('salidaant').value;

  var day1 = new Date(ingreso);
  var day2 = new Date(salida);

  var difference = Math.abs(day2 - day1);
  days = difference / (1000 * 3600 * 24);

  var diasTarifa = document.getElementById('tiempoDias').value;
  var diasTotal = days * diasTarifa;

  var totales = document.getElementById('totales').value;
  var calculo = totales * diasTotal;

  $('#tiempoant').html(days);
  $('#total').html('S/. ' + calculo.toFixed(2));
  $('#total_reserva').val(calculo.toFixed(2));
  $('#total_habitacion').val(calculo.toFixed(2));
  $('#diasTotal').val(diasTotal);
}

function calcularHoras() {
  var horas = 1;
  var horas = document.getElementById('horas').value;
  var horasTarifa = document.getElementById('tiempoHoras').value;
  var horasTotal = horas * horasTarifa;

  var totales = document.getElementById('totales').value;
  var calculo = totales * horasTotal;

  $('#total').html('S/. ' + calculo.toFixed(2));
  $('#total_reserva').val(calculo.toFixed(2));
  $('#total_habitacion').val(calculo.toFixed(2));
  $('#horasTotal').val(horasTotal);
}

function searchHuesped() {
  if ($('#identificacion').val().length == 8) {
    var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Api/getDni?dni=' + $('#identificacion').val();
    request.open('GET', ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        var objData = JSON.parse(request.responseText);
        if (objData != null) {
          $('#huesped').val(objData.nombres + ' ' + objData.apellidoPaterno + ' ' + objData.apellidoMaterno);
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
          $('#huesped').val(objData.nombre);
        } else {
        }
      }
    };
  }
}

function statusReservation() {
  let ajaxUrl = base_url + '/Reservations/getStatusReservation';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector('#estados_reservaciones').innerHTML = request.responseText;
      document.querySelector('#estados_reservaciones').value = 2;
    }
  };
}
function numeros(string) {
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
