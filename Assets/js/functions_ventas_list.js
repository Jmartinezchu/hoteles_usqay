let tableVentas;

document.addEventListener(
  'DOMContentLoaded',
  () => {
    Swal.fire({
      title: 'Por favor espere',
      text: 'Procesando...',
      timer: 700,
      icon: 'info',
      allowOutsideClick: false,
      allowEscapeKey: false,
    });
    Swal.showLoading();
    tableVentas = $('#tableVentas').dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
      },
      ajax: {
        url: ' ' + base_url + '/Sales/getVentas',
        dataSrc: '',
      },
      columns: [
        { data: 'idventa' },
        { data: 'nombres' },
        { data: 'fecha' },
        { data: 'descripcion' },
        // {"data":"mediopago"},
        { data: 'total_venta' },
        { data: 'nombre' },
        { data: 'options' },
      ],
      dom: 'lBfrtip',

      resonsieve: 'true',
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, 'desc']],
    });
  },
  false
);

function openCreate() {
  window.location.href = base_url + '/sales/crear';
}

window.addEventListener(
  'load',
  () => {
    // mediosPago();
  },
  false
);

function fntEditVenta(idventa) {
  var idventa = idventa;
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  let ajaxUrl = base_url + '/Sales/getSalesId/' + idventa;
  request.open('GET', ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      if (objData.status) {
        document.querySelector('#idventa').value = objData.data.idventa;
        document.querySelector('#clientes').value = objData.data.clienteid;
        document.querySelector('#User').value = objData.data.usuario;
        document.querySelector('#tipo_comprobante').value = objData.data.tipo_comprobante;
        document.querySelector('#impuestos_venta').value = objData.data.total_impuestos;
        document.querySelector('#subtotal_venta').value = objData.data.subtotal;
        document.querySelector('#total_venta').value = objData.data.total_venta;
        document.querySelector('#idarticulo').value = objData.data.idarticulo;
        document.querySelector('#cantidad').value = objData.data.cantidad;
        document.querySelector('#precio_venta').value = objData.data.precio_venta;
        let newmodal = document.querySelector('.newmodal-ventas');
        let newmodalC = document.querySelector('.newmodal-container');
        let cerrar = document.querySelector('.modalclose');

        document.querySelector('#medio_pago').value = objData.data.medio_pago_id;
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
      } else {
        Swal.Fire('Error', objData.msg, 'error');
      }
    }
  };
}

function AnularVenta(idventa) {
  var idventa = idventa;
  Swal.fire({
    title: 'Anular Venta',
    text: '¿Desea Anular la Venta?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Eliminar!',
  }).then((willDelete) => {
    if (willDelete.isConfirmed) {
      var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      var ajaxUrl = base_url + '/Sales/delSale';
      var strData = 'idventa=' + idventa;
      request.open('POST', ajaxUrl, true);
      request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      request.send(strData);
      request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
          var objData = JSON.parse(request.responseText);

          if (objData.status) {
            Swal.fire('Venta', objData.msg, 'success');
            tableVentas.api().ajax.reload();
          } else {
            Swal.fire('Venta', objData.msg, 'error');
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
