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
    tableHabitacion = $('#tableHabitacion').dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
      },
      ajax: {
        url: ' ' + base_url + '/Rooms/getRooms',
        dataSrc: '',
      },
      columns: [
        { data: 'idhabitacion' },
        { data: 'nombre_habitacion' },
        { data: 'nombre_categoria_habitacion' },
        { data: 'estado_habitacion' },
        { data: 'capacidad' },
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

$('#tableHabitacion').DataTable();

window.addEventListener(
  'load',
  () => {
    CategoryRooms();
    pisoHabitacion();
  },
  false
);

let formHabitacion = document.querySelector('#formHabitacion');
function guardarHabitacion() {
  event.preventDefault();

  let nombre = document.querySelector('#nombre').value;
  let categoria = document.querySelector('#categoria').value;
  let estado = document.querySelector('#estado').value;
  let capacidad = document.querySelector('#capacidad').value;
  let descripcion = document.querySelector('#descripcion').value;

  if (nombre == '' || categoria == '' || estado == '' || capacidad == '') {
    Swal.fire('Atencion', 'El campo es obligatorio', 'error');
  }

  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Rooms/setHabitaciones';
  let formData = new FormData(formHabitacion);
  request.open('POST', ajaxUrl, true);
  request.send(formData);

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);

      if (objData.status) {
        formHabitacion.reset();
        Swal.fire('Habitacion', objData.msg, 'success');

        window.location.reload();
      } else {
        Swal.fire('Error', objData.msg, 'error');
      }
    }
  };
}
function cancelarHabitacion() {
  let formHabitacion = document.querySelector('#formHabitacion');
  formHabitacion.reset();
}
function pisoHabitacion() {
  let ajaxUrl = base_url + '/PisoHabitacion/getPisos';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector('#piso').innerHTML = request.responseText;
      document.querySelector('#piso').value = 1;
    }
  };
}

function CategoryRooms() {
  let ajaxUrl = base_url + '/RoomsCategory/getSelectRoomsCategory';
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector('#categoria').innerHTML = request.responseText;
      document.querySelector('#categoria').value = 1;
    }
  };
}

function editRooms(idhabitacion) {
  var idhabitacion = idhabitacion;

  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Rooms/getRoomsId/' + idhabitacion;

  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      console.log(objData);
      if (objData.status) {
        console.log(objData);
        document.querySelector('#idhabitacion').value = objData.data.idhabitacion;
        document.querySelector('#nombre').value = objData.data.nombre_habitacion;
        document.querySelector('#categoria').value = objData.data.categoriahabitacionid;
        document.querySelector('#estado').value = objData.data.estado_habitacion;
        document.querySelector('#capacidad').value = objData.data.capacidad;
        document.querySelector('#descripcion').value = objData.data.descripcion;
        document.querySelector('#piso').value = objData.data.idpiso;
        $('#modalUpdateHabitacion').modal('show');
      } else {
        Swal.fire('Error', objData.msg, 'error');
      }
    }
  };
}

function openCreate() {
  window.location.href = base_url + '/rooms/create';
}

function deleteRooms(idhabitacion) {
  var idhabitacion = idhabitacion;
  Swal.fire({
    title: 'Eliminar Habitacion',
    text: '¿Desea eliminar la habitacion?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/Rooms/deleteRooms';
      var strData = 'idhabitacion=' + idhabitacion;

      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);

      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);

          if (objData.status) {
            Swal.fire('Habitacion', objData.msg, 'success');
            tableHabitacion.api().ajax.reload();
          } else {
            Swal.fire('Atencion', objData.msg, 'error');
          }
        }
      };
    }
  });
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
$('#tablePriceHabitacion').dataTable();
