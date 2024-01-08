let tableReservation;

let tableHabitacion;

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

    tableReservation = $('#tableReservation').dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
      },
      ajax: {
        url: ' ' + base_url + '/Reservations/getReservations',
        dataSrc: '',
      },
      columns: [
        { data: 'id_reservacion' },
        { data: 'nombre_habitacion' },
        { data: 'cliente' },
        { data: 'fecha_inicio' },
        { data: 'fecha_fin' },
        { data: 'origen' },
        { data: 'estado' },
        { data: 'options' },
      ],
      dom: 'lBfrtip',
      buttons: [],

      resonsieve: 'true',
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, 'desc']],
    });

    tableHabitacion = $('#tableHabitacion').dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
      },
      ajax: {
        url: ' ' + base_url + '/Reservations/getRoomsReser',
        dataSrc: '',
      },
      columns: [
        { data: 'options' },
        { data: 'nombre_habitacion' },
        { data: 'nombre_categoria_habitacion' },
        { data: 'estado_habitacion' },
        { data: 'capacidad' },
      ],
      dom: 'lBfrtip',
      buttons: [],

      resonsieve: 'true',
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, 'desc']],
    });

    document.querySelectorAll('input[type=text]').forEach((node) =>
      node.addEventListener('keypress', (e) => {
        if (e.keyCode == 13) {
          e.preventDefault();
        }
      })
    );
  },
  false
);

window.addEventListener(
  'load',
  () => {
    TipoComprobante();
    // mediosPago();
    statusReservation();
    originReservation();
    // categoryRooms();
    // searchHuesped();
    // roomsReservationsHoras();

    $('#tarifas li').on('click', function (e) {
      e.preventDefault();

      // Obtén el valor del atributo data-target
      var targetId = $(this).attr('data-target');
      // alert(targetId);
      // Oculta todos los elementos
      $('#horas_reserva, #dias_reserva').hide();

      // Muestra el elemento correspondiente al valor de data-target
      $('#' + targetId).show();

      // Realiza cualquier otra acción necesaria, como llamar a funciones específicas
      if (targetId === 'horas_reserva') {
        roomsReservationsHoras();
        $('#foodrooms').show();
        $('#foodroomsDays').hide();
      } else if (targetId === 'dias_reserva') {
        roomsReservationsArturo();
        $('#foodrooms').hide();
        $('#foodroomsDays').show();
      }
    });
  },
  false
);
var botones = '';
function tarifario(idhabitacion) {
  var tarifa = document.getElementById('tarifas').value;
  var titulo_precios = document.getElementById('precios');
  titulo_precios.style.removeProperty('display');
  calculo = 0;
  // alert(idhabitacion, tarifa);
  $('#total').html('S/. ' + calculo.toFixed(2));

  habitacionDiasreserva(idhabitacion);
  // alert('dis dias ');
  document.getElementById('precios-tarifa').innerHTML = '';
}
function habitacionDiasreserva(idhabitacion) {
  // let id = document.getElementById('idhabitacion').value;
  let id = idhabitacion;
  var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/Hospedar/preciosTarifa/2';
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
function TipoComprobante() {
  let ajaxUrl = base_url + '/Reservations/getTipoComprobante';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var data = JSON.parse(request.responseText);
      for (var i = 0; i < data.length; i++) {
        var idcomprobante = data[i]['id_tipo_comprobante'];
        botones = $('#botonesArturo').append(
          '<button class="btn btn-light btn-sm" id="' +
            idcomprobante +
            '" onclick="pagar(' +
            idcomprobante +
            ');"><i class="fa-solid fa-file-lines"></i><span id="btnText"> ' +
            data[i]['descripcion'] +
            '</span> </button>&nbsp'
        );
      }
    }
  };
}

function guardarReservacion() {
  let formReserva = document.querySelector('#formReserva');
  event.preventDefault();
  let tarifas = document.querySelector('#idTarifasjajaja').value;
  let identificacion = document.querySelector('#identificacion').value;
  let nombre = document.querySelector('#huesped').value;
  let documento = identificacion.length;
  var allValores = Array.from(document.getElementsByName('inlineRadioOptions'));
  var seleccionado = allValores.map(function (valor) {
    seleccion = valor.checked;
    return { seleccion };
  });
  // alert(tarifas);
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
        let ajaxUrl = base_url + '/Reservations/setReservationsAnticipado';
        let formData = new FormData(formReserva);
        request.open('POST', ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              Swal.fire('Reservacion', objData.msg, 'success');
              window.location = base_url + '/Hospedar';
            }
          }
        };
      }
    }
  } else {
    Swal.fire('Atencion', 'Ingrese un documento valido', 'error');
  }
}

function updateReservacion() {
  // alert('estamos actualizando');
  let formReserva = document.querySelector('#formReserva');
  event.preventDefault();
  let idreservacion = document.querySelector('#idreservacion').value;
  // alert(idreservacion);
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Reservations/updateReservationsJm';
  let formData = new FormData(formReserva);
  request.open('POST', ajaxUrl, true);
  request.send(formData);
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        Swal.fire('Reservacion', objData.msg, 'success');
        window.location = base_url + '/Hospedar';
      }
    }
  };
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

function pagar(idcomprobante) {
  if (idcomprobante == 1) {
    var idcomprobante = idcomprobante;
    setTimeout(function () {
      Swal.fire({
        title: 'Por favor espere',
        text: 'Procesando...',
        timer: 20000,
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
      });
    }, 15000);
    Swal.showLoading();
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = idcomprobante;
    input.id = 'comprobante_factura_id[' + idcomprobante + ']';
    input.name = 'comprobante_factura_id[' + idcomprobante + ']';
    // console.log(input);
    let formReservationPayment = document.querySelector('#formReservationPayment');
    formReservationPayment.onsubmit = (e) => {
      e.preventDefault();
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url + '/Reservations/setPayReservations';
      let formData = new FormData(formReservationPayment);
      request.open('POST', ajaxUrl, true);
      request.send(formData);
      var idReservacion = document.getElementById('idReservacion').value;
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          // console.log('FACTURA')
          var objData = JSON.parse(request.responseText);
          Swal.fire('FACTURA', objData.msg, 'success');
          window.open(base_url + '/prints/facturares?id=' + idReservacion, '_blank');
          window.location = base_url + '/reservations';
        }
      };
    };
  } else if (idcomprobante == 2) {
    var idcomprobante = idcomprobante;
    setTimeout(function () {
      Swal.fire({
        title: 'Por favor espere',
        text: 'Procesando...',
        timer: 20000,
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
      });
    }, 15000);
    Swal.showLoading();
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = idcomprobante;
    input.id = 'comprobante_boleta_id[' + idcomprobante + ']';
    input.name = 'comprobante_boleta_id[' + idcomprobante + ']';
    // console.log(input)

    let formReservationPayment = document.querySelector('#formReservationPayment');
    formReservationPayment.onsubmit = (e) => {
      e.preventDefault();
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url + '/Reservations/setPayReservations';
      let formData = new FormData(formReservationPayment);
      request.open('POST', ajaxUrl, true);
      request.send(formData);
      var idReservacion = document.getElementById('idReservacion').value;
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          // console.log('BOLETA')
          var objData = JSON.parse(request.responseText);
          Swal.fire('BOLETA', objData.msg, 'success');
          window.open(base_url + '/prints/boletares?id=' + idReservacion, '_blank');
          window.location = base_url + '/reservations';
        }
      };
    };
  } else if (idcomprobante == 6) {
    setTimeout(function () {
      Swal.fire({
        title: 'Por favor espere',
        text: 'Procesando...',
        timer: 700,
        icon: 'info',
        allowOutsideClick: false,
        allowEscapeKey: false,
      });
    }, 300);
    var input = document.createElement('input');
    input.type = 'hidden';
    input.value = idcomprobante;
    input.id = 'comprobante_ticket_id[' + idcomprobante + ']';
    input.name = 'comprobante_ticket_id[' + idcomprobante + ']';
    // console.log(input)
    let formReservationPayment = document.querySelector('#formReservationPayment');
    formReservationPayment.onsubmit = (e) => {
      e.preventDefault();
      let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      let ajaxUrl = base_url + '/Reservations/setPayReservations';
      let formData = new FormData(formReservationPayment);
      request.open('POST', ajaxUrl, true);
      request.send(formData);
      var idReservacion = document.getElementById('idReservacion').value;
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          // console.log('TICKET')
          var objData = JSON.parse(request.responseText);
          Swal.fire('TICKET', objData.msg, 'success');

          window.open(base_url + '/prints/ticketres?id=' + idReservacion, '_blank');
          window.location = base_url + '/reservations';
        }
      };
    };
  }

  $('#botonesArturo').append(input);
}

//  $("#categoria").on("change", function(e){
// e.preventDefault();
//     if($("#categoria").val())
//     {
//         document.querySelector("#foodrooms").style.display = "none";
//         let ajaxUrl = base_url+'/Reservations/getSelectCategoryRooms/'+$("#categoria").val();
//         let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//         request.open("GET",ajaxUrl,true);
//         request.send();
//         request.onreadystatechange = function(){
//             if(request.readyState == 4 && request.status == 200){
//                 var objData = JSON.parse(request.responseText);
//                 const arrData = objData.data.map((inf) => {
//                     return '<a href="" class="reservar"><p>Habitacion '+inf.nombre_habitacion+'</p><p><i class="fa fa-users" aria-hidden="true"></i> '+inf.capacidad+'</p></a>'

//                 })
//                 document.querySelector('#foo').innerHTML = arrData.join("")

//             }
//         }

//     }

//   });

function roomsReservationsArturo() {
  let url = base_url + '/Reservations/getRoomsReservationArturo';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', url, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      for (var i = 0; i < objData.length; i++) {
        let room = objData[i];
        options = room['options'];
        idhabitacion = room['idhabitacion'];
        nombre_habitacion = room['nombre_habitacion'];
        capacidad = room['capacidad'];
        $('#foodroomsDays').append(
          '<div class="reservar col-md-6" style="" ><div style="cursor:pointer;width: 100%;position:relative;display:inline-block;text-align:center;box-shadow: 0px -1px 6px 0px #004987;;border-radius: 15px;margin: 4px 0px;" id=' +
            idhabitacion +
            '>' +
            options +
            '<p>Habitacion ' +
            nombre_habitacion +
            '</p><p><i class="fa fa-users" aria-hidden="true"></i> ' +
            capacidad +
            '</p></div></div>'
        );
      }
    }
  };
}

function roomsReservationsHoras() {
  let url = base_url + '/Reservations/getRoomsReservHoras';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', url, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      for (var i = 0; i < objData.length; i++) {
        let room = objData[i];
        options = room['options'];
        idhabitacion = room['idhabitacion'];
        nombre_habitacion = room['nombre_habitacion'];
        capacidad = room['capacidad'];
        $('#foodrooms').append(
          '<div class="reservar col-md-6" style="coursor:pointer;position:relative;display:inline-block;text-align:center" id=' +
            idhabitacion +
            '>' +
            options +
            '<p>Habitacion ' +
            nombre_habitacion +
            '</p><p><i class="fa fa-users" aria-hidden="true"></i> ' +
            capacidad +
            '</p></div>'
        );
      }
    }
  };
}

function calcularFecha() {
  var days = 0;

  let ingreso = document.getElementById('ingreso').value;

  let salida = document.getElementById('salida').value;

  var day1 = new Date(ingreso);
  var day2 = new Date(salida);

  var difference = Math.abs(day2 - day1);
  days = difference / (1000 * 3600 * 24);

  document.getElementById('tiempo_estadia').innerHTML = days;
  document.getElementById('tiempo').value = days;

  var totales = document.getElementById('totales').value;
  var calculo = Math.round(totales * days);
  console.log(totales, days);
  $('#tiempo').html(days);
  $('#total').html('S/. ' + calculo);
  $('#total_reserva').val(calculo);
  $('#total_habitacion').val(calculo);
}

function calcularFechaUpdate() {
  let ingreso = document.getElementById('ingreso').value;

  let salida = document.getElementById('salida').value;

  var day1 = new Date(ingreso);
  var day2 = new Date(salida);

  var difference = Math.abs(day2 - day1);
  days = difference / (1000 * 3600 * 24);
  document.getElementById('tiempo').value = days;
}

function calcularHoras() {
  var horas = document.getElementById('horas').value;
  document.getElementById('tiempo_estadia').innerHTML = horas;
  document.getElementById('tiempo').value = horas;
  hora = horas;
  // console.log(hora);
  var totales = document.getElementById('totales').value;
  var calculo = Math.round(totales * horas);
  // var total = calculo.toFixed(2);

  $('#total').html('S/. ' + calculo);
  $('#total_reserva').val(calculo);
  $('#total_habitacion').val(calculo);
}

function calcularHorasTotalReservaId(totalReserva, id) {
  horas = 1;
  var horas = document.getElementById('horas').value;
  document.getElementById('tiempo_estadia').innerHTML = horas;
  document.getElementById('tiempo').value = horas;
  var totales = document.getElementById('totales').value;
  var calculo = Math.round(totales * horas);
  // var total = calculo.toFixed(2);

  $('#total').html('S/. ' + calculo);
  $('#total_reserva').val(calculo);
  $('#total_habitacion').val(calculo);

  calcularAumentoReserva(totalReserva, id, calculo);
}

function calcularFechaTotalReservaId(totalReserva, id) {
  let ingreso = document.getElementById('ingreso').value;

  let salida = document.getElementById('salida').value;

  var day1 = new Date(ingreso);
  var day2 = new Date(salida);

  var difference = Math.abs(day2 - day1);
  days = difference / (1000 * 3600 * 24);

  document.getElementById('tiempo_estadia').innerHTML = days;
  document.getElementById('tiempo').value = days;

  var totales = document.getElementById('totales').value;
  var calculo = Math.round(totales * days);

  $('#total').html('S/. ' + calculo);
  $('#total_reserva').val(calculo);
  $('#total_habitacion').val(calculo);
  calcularAumentoReserva(totalReserva, id, calculo);
}

function calcularAumentoReserva(totalReserva, id, calculo) {
  var totalEstadia = calculo;
  var aumento = totalReserva;
  var totalAumento = totalEstadia + aumento;
  // console.log(totalAumento);
  // console.log(id);
}
function calcularAumentoReserva(totalReserva, id, calculo) {
  var totalEstadia = calculo;
  var aumento = totalReserva;
  var inicio = document.getElementById('ingreso').value;
  var salida = document.getElementById('salida').value;
  var totalAumento = totalEstadia + aumento;
  $('#total').html('S/. ' + totalAumento);
  $('#total_reserva').val(totalAumento);
  let formEstadia = document.querySelector('#formEstadia');
  formEstadia.onsubmit = (e) => {
    e.preventDefault();
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Reservations/updateAumentarReservacionId/' + id;
    // console.log(ajaxUrl);
    let formData = new FormData(formEstadia);
    request.open('POST', ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        // console.log(objData);
        if (objData.status) {
          Swal.fire('Reservacion', objData.msg, 'success');
          window.location = base_url + '/hospedar';
        }
      }
    };
  };
}

function habitacionHorasId(id) {
  let url = base_url + '/hospedar/habitacionHoras/' + id;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', url, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      $('#totales').val(objData.precio_hora);
      // console.log(objData);
    }
  };
}

function habitacionDiasId(id) {
  let url = base_url + '/hospedar/habitacionDias/' + id;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', url, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      $('#totales').val(objData.precio_dia);
    }
  };
}

function fntEditReservacion(id_reservacion) {
  var id_reservacion = id_reservacion;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Reservations/getReservationId/' + id_reservacion;
  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      // console.log(objData);
      if (objData.status) {
        document.querySelector('#idreservacion').value = objData.data.id_reservacion;
        document.querySelector('#ingreso').value = objData.data.fecha_inicio;
        document.querySelector('#salida').value = objData.data.fecha_fin;
        // document.querySelector('#tiempo').value = objData.data.tiempo;
        document.querySelector('#origen_reserva').value = objData.data.reservacion_origen_id;
        document.querySelector('#huesped').value = objData.data.cliente;
        document.querySelector('#estados_reservaciones').value = objData.data.reservacion_estado_id;
        document.querySelector('#idhabitacion').value = objData.data.habitacion_id;
        document.querySelector('#total_reserva').value = objData.data.total;
        document.querySelector('#idTarifasjajaja').value = objData.data.tipoServicio;
        // document.querySelector('#idTarifasjajaja').value = objData.data.tipoServicio;
        console.log(objData.data);
        $('#modalEditReservations').modal('show');
      } else {
        Swal.fire('Error', objData.msg, 'error');
      }
    }
  };
}

function originReservation() {
  let ajaxUrl = base_url + '/Reservations/getOriginReservation';
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

function statusReservation() {
  let ajaxUrl = base_url + '/Reservations/getStatusReservation';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector('#estados_reservaciones').innerHTML = request.responseText;
      document.querySelector('#estados_reservaciones').value = 1;
    }
  };
}

var cont = 0;
var habitaciones = 0;

function agregarHabitacion(idhabitacion, nombre_habitacion, capacidad) {
  if (idhabitacion != '') {
    var fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td><input type="hidden" name="idhabitacion" value="' +
      idhabitacion +
      '"><b>HABITACION ' +
      nombre_habitacion +
      ' - CAPACIDAD ' +
      capacidad +
      '</td>' +
      '<td><button type="button" style="background-color: transparent; width:30px; height:30px; border:none; border-radius:10px;"" onclick="eliminarHabitacion(' +
      cont +
      ')"><i style="color: #DC3545;" class="fa-solid fa-trash fa-lg"></i></button></td>' +
      '</tr>';
    document.querySelector('#no_disp').style.display = 'none';
    document.querySelector('#n_habitaciones').innerHTML = cont + 1;
    cont++;
    habitaciones++;
    $('#habitaciones').append(fila);

    var count = document.getElementsByName('fila');
    var fecha_salida = document.querySelector('#salida').value;
    var fecha_ingreso = document.querySelector('#ingreso').value;

    // $('#total').html('S/. ' + precio_dia * days);
    // $('#total_reserva').val(precio_dia * days);
    tarifario(idhabitacion);
  } else {
    // console.error("dandole dandoleeeeeeeeeeeeeeeee ");
  }
}

function agregarHabitacionHoras(idhabitacion, nombre_habitacion, capacidad, precio_hora) {
  if (idhabitacion != '') {
    var fila =
      '<tr class="filas" id="fila' +
      cont +
      '">' +
      '<td><input type="hidden" name="idhabitacion" value="' +
      idhabitacion +
      '"><b>HABITACION ' +
      nombre_habitacion +
      ' - CAPACIDAD ' +
      capacidad +
      '</b><input type="hidden" id="precio" name="precio" value="' +
      precio_hora +
      '"></td>' +
      '<td><button type="button" style="background-color: transparent; width:30px; height:30px; border:none; border-radius:10px;"" onclick="eliminarHabitacion(' +
      cont +
      ')"><i style="color: #DC3545;" class="fa-solid fa-trash fa-lg"></i></button></td>' +
      '</tr>';
    document.querySelector('#no_disp').style.display = 'none';
    document.querySelector('#n_habitaciones').innerHTML = cont + 1;
    cont++;
    habitaciones++;
    $('#habitaciones').append(fila);

    $('#total').html('S/. ' + precio_hora * hora);
    $('#total_reserva').val(precio_hora * hora);
  } else {
    // console.error("dandole putitos ");
  }
}

function openCreate() {
  location.href = base_url + '/Reservations/create';
}

function viewReservacion(id_reservacion) {
  var id_reservacion = id_reservacion;
  window.location.href = base_url + '/reservations/show?id=' + id_reservacion;
}

function viewCalendar() {
  url = base_url + '/calendario/calendario';

  var open_calendar = window.open(url, '_blank');
  open_calendar.focus();
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

function eliminarHabitacion(indice) {
  $('#fila' + indice).remove();
  habitaciones = habitaciones - 1;
  document.querySelector('#n_habitaciones').innerHTML = cont - 1;
}

// function categoryRooms() {
//   let ajaxUrl = base_url + "/Reservations/getCategoryRooms";
//   let request = window.XMLHttpRequest
//     ? new XMLHttpRequest()
//     : new ActiveXObject("Microsoft.XMLHTTP");
//   request.open("GET", ajaxUrl, true);
//   request.send();

//   request.onreadystatechange = function () {
//     if (request.readyState == 4 && request.status == 200) {
//       document.querySelector("#categoria").innerHTML = request.responseText;
//       document.querySelector("#categoria").value = 1;
//     }
//   };
// }

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
function habitacionHoras() {
  let id = document.getElementById('idhabitacion').value;
  let url = base_url + '/hospedar/habitacionHoras/' + id;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', url, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      $('#totales').val(objData.precio_hora);
    }
  };
}

function habitacionDias() {
  let id = document.getElementById('idhabitacion').value;
  let url = base_url + '/hospedar/habitacionDias/' + id;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', url, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      $('#totales').val(objData.precio_dia);
    }
  };
}

// onclick='fntViewRoom('<?= $room['idhabitacion']; ?>)'
function aumentarEstadia(id) {
  let cerrar = document.querySelector('.modalclose');
  let newmodal = document.querySelector('.newmodal-estadia');
  let newmodalC = document.querySelector('.newmodal-container');

  newmodalC.style.opacity = '1';
  newmodalC.style.visibility = 'visible';
  newmodal.classList.toggle('newmodal-modalclose');

  cerrar.addEventListener('click', function () {
    newmodal.classList.toggle('newmodal-modalclose');

    setTimeout(function () {
      newmodalC.style.opacity = '0';
      newmodalC.style.visibility = 'hidden';
    }, 900);
  });
}

function agregarConsumoHabitacion() {
  $('#modalHospedarConsumo').modal('show');
}

var impuesto = 18;
var cont = 0;
var detalles = 0;

var cliente = 0;

function agregarProducto1() {
  agregarProducto();
}

function agregarConsumo() {
  // console.log("pinga");
  // TODO:
}

function agregarBusquedaCliente() {
  event.preventDefault();
  let identificacion = document.querySelector('#identificacion').value;
  let name_customer = document.querySelector('#nombre_cliente').value;
  $('#clientes').val(name_customer);
  $('#identificacion_cliente').val(identificacion);
}
// let customers = document.querySelector("#addCustomers");
// customers.addEventListener('click',(e) => {
//     e.preventDefault();
//     let identificacion = document.querySelector("#identificacion").value;
//     let name_customer = document.querySelector("#nombre_cliente").value;
//     $('#clientes').val(name_customer);
//     $('#identificacion_cliente').val(identificacion);

// })

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
      '<td><input class="form-control"  type="text" style="width : 50px; " name="cantidad[]" id="cantidad[]" value="' +
      cantidad +
      '"></td>' +
      '<td><input class="form-control" type="text" style="width : 50px; " name="precio_venta[]" id="precio_venta[]" value="' +
      precio_venta +
      '"></td>' +
      '<td><span id="subtotal' +
      cont +
      '" name="subtotal">' +
      subtotal +
      '</span></td>' +
      '<td><button type="button" class="btn btn-light btn-sm" style="border-radius:10px" onclick="modificarSubtotales()"><i class="uil-refresh"></i></button></td>' +
      '</tr>';

    cont++;
    detalles++;
    $('#detalles').append(fila);
    // console.log(productoid)
    modificarSubtotales();
    // calcularTotales();
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
    document.getElementsByName('subtotal')[i].innerHTML = inpS.value;
  }
  calcularTotales();
}

function calcularTotales() {
  var sub = document.getElementsByName('subtotal');
  var total = 0.0;
  var igv = 0.0;

  // TODO: CAMBIAR IGV

  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName('subtotal')[i].value;

    var base = (total / 110) * 100;
    igv = (total / 110) * 10;
    // console.log(igv)

    var rounded = +(Math.round(igv + 'e+2') + 'e-2');
    var rounded_total = +(Math.round(total + 'e+2') + 'e-2');
    var rounded_base = +(Math.round(base + 'e+2') + 'e-2');
  }
  // console.log(total);
  $('#total').html('S/. ' + rounded_total);
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

    // console.log(medio_pago)
    var tablamediopago = document.getElementById('tablamediopago');
    tablamediopago.style.removeProperty('display');
    var fila =
      '<tr id="fila' +
      contPago +
      '">' +
      '<td><button class="btn btn-light btn-sm" style="border-radius:10px" type="button" onclick="eliminarDetallePago(' +
      contPago +
      ')"><i style="color:red;" class="fa-solid fa-trash"></i></td>' +
      '<td><input class="form-control" type="hidden" id="idmediopago[]" name="idmediopago[]" value="' +
      mediopagoid +
      '">' +
      medio_pago +
      '</td>' +
      '<td style="display:none"><input class="form-control" type="hidden" name="cantidadPago[]" id="cantidadPago[]" value="' +
      cantidad +
      '"></td>' +
      '<td><input class="form-control" type="text" name="totalPago[]" id="totalPago[]" value="' +
      total +
      '"></td>' +
      '<td><span id="subtotalPago' +
      contPago +
      '" name="subtotalPago">' +
      total +
      '</span></td>' +
      '<td></button><button class="btn btn-light btn-sm" style="border-radius:10px"  type="button" onclick="modificarSubtotalesPago()"><i class="fa fa-refresh"></i></button></td>' +
      '</tr>';
    contPago++;
    detallesPago++;
    $('#detallesPago').append(fila);
    // document.getElementById("monto_ingresado").innerHTML = '$ '+total+',00';
    document.getElementById('montoPago').value = '';
    // calcularTotales();
    modificarSubtotalesPago();
  }
}
function eliminarDetallePago(indice) {
  $('#fila' + indice).remove();
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
    document.getElementsByName('subtotalPago')[i].innerHTML = inpS.value;
  }
  calcularTotalesPago();
}

function calcularTotalesPago() {
  var sub = document.getElementsByName('subtotalPago');
  var total = 0.0;
  for (var i = 0; i < sub.length; i++) {
    total += document.getElementsByName('subtotalPago')[i].value;
    // console.log(total);
  }
  $('#total_pago').html('S/. ' + total);
  $('#total_pago').val(total);
}
function calcularTotales() {
  var sub = document.getElementsByName('subtotal');
  var total = 0.0;
  var igv = 0.0;

  // TODO: CAMBIAR IGV

  for (var i = 0; i < sub.length; i++) {
    var igv1 = document.getElementsByName('subtotal')[i].value * 0.1;
    total += document.getElementsByName('subtotal')[i].value;
    // console.log(total)

    var base = (total / 110) * 100;
    igv = (total / 110) * 10;
    // console.log(igv)
    // console.log(base);

    var rounded = +(Math.round(igv + 'e+2') + 'e-2');
    var rounded_total = +(Math.round(total + 'e+2') + 'e-2');
    var rounded_base = +(Math.round(base + 'e+2') + 'e-2');
  }
  $('#total_consumo').html('S/. ' + rounded_total);
  $('#total_venta').val(rounded_total);
  $('#subtotal').html('S/. ' + rounded_base);
  $('#subtotal_venta').val(rounded_base);
  $('#impuestos').html('S/. ' + rounded);
  $('#impuestos_venta').val(rounded);
}

function agregarClienteReservacion(idUsuario, idReserva) {
  // alert("DavidBoooy!");
  // console.log(idUsuario, idReserva);
  event.preventDefault();

  let identificacion = document.querySelector('#identificacion').value;
  let nombre = document.querySelector('#nombre').value;
  let correo = document.querySelector('#correo').value;
  let direccion = document.querySelector('#direccion').value;

  if (nombre == '' || correo == '' || direccion == '' || identificacion == '') {
    Swal.fire('Atencion', 'El campo es obligatorio', 'error');
    return false;
  }

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
}
function pagarConsumo(id) {
  // var idcomprobante = 4
  var formHospedarConsumo = document.querySelector('#formHospedarConsumo');
  event.preventDefault();
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Reservations/setConsumo';
  //  console.log(ajaxUrl)
  let formData = new FormData(formHospedarConsumo);
  request.open('POST', ajaxUrl, true);
  request.send(formData);
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      // console.log(request.responseText)
      var objData = JSON.parse(request.responseText);
      Swal.fire('CONSUMO', objData.msg, 'success');
      //  console.log(objData.data);
      //  window.open(base_url+'/prints/comanda?id='+objData.data,'_blank');
      window.location = base_url + '/hospedar/show?id=' + id;
    }
  };
}
function retornarProductos(detalleConsumo, idConsumo, idReservacion) {
  event.preventDefault();
  // console.log(idEstadia, idReservacion);
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
      // console.log(ajaxUrl);
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
            Swal.fire('Reservacion', objData.msg, 'error');
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
  // alert(tarifa);
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
  // console.log(idEstadia, idReservacion);
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
      // console.log(ajaxUrl);
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
