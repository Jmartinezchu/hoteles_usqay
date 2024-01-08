let tableCashRegisterMovements;
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
    tableCashRegisterMovements = $('#tableCashRegisterMovements').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/CashRegisterMovements/getCashRegisterMovements",
            "dataSrc": ""
        },
        "columns": [
            {"data":"id_movimientocaja"},
            {"data":"fecha"},
            {"data":"nombre"},
            {"data":"descripcion"},
            {"data":"monto"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
         
        ],
        
        "resonsieve":"true",
        "bDestroy":true,
        "iDisplayLength": 10,
        "order": [[0,"desc"]]
    });

    
}, false)

window.addEventListener('load', () => {
},false);
function openCreate(){
   
    window.location.href = base_url+"/cashregistermovements/create";
    
}

