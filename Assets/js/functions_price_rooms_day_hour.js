let tablePriceHabitacionDayHour;

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
    tablePriceHabitacionDayHour = $('#tablePriceHabitacionDayHour').dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
      },
      ajax: {
        url: ' ' + base_url + '/PriceRooms/getVariosPreciosDayHour',
        dataSrc: '',
      },
      columns: [
        { data: 'idPrecioHabitacion' },
        { data: 'nombre_habitacion' },
        { data: 'nombreTarifa' },
        { data: 'precio' },
        { data: 'dias' },
        { data: 'horas' },
        { data: 'minutos' },
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
  },
  false
);

window.addEventListener(
  'load',
  () => {
    Rooms();
  },
  false
);

function guardarPrecio() {
  let formPriceRoomsDayHour = document.querySelector('#formPriceRoomsDayHour');
  event.preventDefault();

  let habitacion = document.querySelector('#idRoom').value;
  let tarifa = document.querySelector('#idTarifas').value;
  let precio = document.querySelector('#price').value;
  let dias = document.querySelector('#days').value;
  let horas = document.querySelector('#hours').value;
  let minutos = document.querySelector('#minutes').value;

  if (precio == '' || dias == '' || horas == '' || minutos == '' || habitacion == '' || tarifa == '') {
    Swal.fire('Atencion', 'El campo es obligatorio', 'error');
    return false;
  } else if (dias > 31) {
    Swal.fire('Atencion', 'Los dias no son mayor a 31', 'error');
    return false;
  } else if (horas > 240) {
    Swal.fire('Atencion', 'Las horas no son mayor a 2484848484', 'error');
    return false;
  } else if (minutos > 60) {
    Swal.fire('Atencion', 'Los minutos no son mayor a 60', 'error');
    return false;
  } else {
    let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');

    let ajaxUrl = base_url + '/PriceRooms/setPrecio';

    let formData = new FormData(formPriceRoomsDayHour);
    request.open('POST', ajaxUrl, true);
    request.send(formData);

    request.onreadystatechange = function () {
      if (request.readyState == 4 && request.status == 200) {
        let objData = JSON.parse(request.responseText);
        if (objData.status) {
          Swal.fire('Precio', objData.msg, 'success');
          tablePriceHabitacionDayHour.api().ajax.reload();
          formPriceRoomsDayHour.reset();
        } else {
          Swal.fire('Error', objData.msg, 'error');
        }
      }
      window.location.reload();
    };
  }
}

function Rooms() {
  let ajaxUrl = base_url + '/Rooms/getHabitaciones';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector('#idRoom').innerHTML = request.responseText;
      document.querySelector('#idRoom').value = 1;
    }
  };
}
function cancelar() {
  formPriceRoomsDayHour.reset();
}

function DeletePrecio(idprecio) {
  Swal.fire({
    title: 'Eliminar Precio',
    text: '¿Desea eliminar el Precio?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/PriceRooms/deletePrecio';
      var strData = 'idprecio=' + idprecio;

      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);

          if (objData.status) {
            Swal.fire('Precio', objData.msg, 'success');
            tablePriceHabitacionDayHour.api().ajax.reload();
          } else {
            Swal.fire('Atencion', objData.msg, 'error');
          }
        }
      };
    }
  });
}

function EditPrecio(idprecio) {
  var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  var ajaxUrl = base_url + '/PriceRooms/getUnPrecio/' + idprecio; //url

  request.open('POST', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      document.querySelector('#idPrecio').value = objData.data.idPrecioHabitacion;
      document.querySelector('#idRoom').value = objData.data.idHabitacion;
      document.querySelector('#idTarifas').value = objData.data.idTarifa;
      document.querySelector('#price').value = objData.data.precio;
      document.querySelector('#days').value = objData.data.dias;
      document.querySelector('#hours').value = objData.data.horas;
      document.querySelector('#minutes').value = objData.data.minutos;
    }
  };
}
function Numeros(string) {
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
function tarifario() {
  var tarifa = document.getElementById('idTarifas').value;
  if (tarifa == 1) {
    $('#days').val(0);
    $('#hours').val(1);
    $('#minutes').val(0);
  } else if (tarifa == 2) {
    $('#days').val(1);
    $('#hours').val(0);
    $('#minutes').val(0);
  } else {
  }
}
$('#tablePriceHabitacionDayHour').dataTable();
