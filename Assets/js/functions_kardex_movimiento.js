let tableKardexSeguimiento;
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
      })
      Swal.showLoading()
  
        let idkardex = document.querySelector("#productoid").value;
        tableKardexSeguimiento = $('#tableKardexSeguimiento').dataTable({
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": " "+base_url+"/Kardex/getKardexSeguimiento/"+idkardex,
                "dataSrc": ""
            },
            "columns": [
                {"data":"nombre_almacen"},
                {"data":"nombre"},
                {"data":"cantidad"},
                {"data":"total"},
                {"data":"tipo_movimiento"},
                {"data":"fecha"},
                {"data":"descripcion"}
            ],
            'dom': 'lBfrtip',
            'buttons': [
             
            ],
            
            "resonsieve":"true",
            "bDestroy":true,
            "iDisplayLength": 10,
            "order": [[0,"desc"]]
        });
    
  
}, false);