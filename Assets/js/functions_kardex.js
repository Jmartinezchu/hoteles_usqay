let tableKardex;
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
    
  
}, false);


window.addEventListener('load', () => {
    Almacenes();
 },false);
 

 function buscarKardex(){
    let kardex = document.querySelector("#kardex");
        event.preventDefault();
        let idalmacen = document.querySelector("#almacenes").value;
        tableKardex = $('#tableKardex').dataTable({
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            },
            "ajax": {
                "url": " "+base_url+"/Kardex/getKardex/"+idalmacen,
                "dataSrc": ""
            },
            "columns": [
                {"data":"idmovimiento_producto"},
                {"data":"nombre"},
                {"data":"nombre_almacen"},
                {"data":"stock"},
                {"data":"options"}
            ],
            'dom': 'lBfrtip',
            'buttons': [
             
            ],
            
            "resonsieve":"true",
            "bDestroy":true,
            "iDisplayLength": 10,
            "order": [[0,"desc"]]
        });
 }

 function Almacenes(){
    let ajaxUrl = base_url+'/Almacen/getSelectAlmacenes';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#almacenes').innerHTML = request.responseText;
            document.querySelector('#almacenes').value = 1;
        }
    }
}
