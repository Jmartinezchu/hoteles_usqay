let tableCanceledSales;
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
      tableCanceledSales = $('#tableCanceledSales').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "",
            "dataSrc": " "+base_url+"/CanceledSales/getCanceledSales"
        },
        "columns": [
            {"data":"idventa"},
            {"data":"cliente"},
            {"data":"created_at"},
            {"data":"tipo_comprobante"},
            {"data":"medio_pago_id"},
            {"data":"total_venta"},
            {"data":"estado"},
        ],
        'dom': 'lBfrtip',
        'buttons': [
        ],
        "resonsieve":"true",
        "bDestroy":true,
        "iDisplayLength": 10,
        "order": [[0,"desc"]]
    });

    // console.log(base_url);

} , false);
$('#tableCanceledSales').DataTable();
