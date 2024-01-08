let tableBills;
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
      tableBills = $('#tableBills').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "resonsieve":"true",
        "bDestroy":true,
        "iDisplayLength": 10,
        "order": [[0,"desc"]]        
    });


}, false);


function DescargarFactura(id_factura){
    var id_factura = id_factura;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Bills/getBillsID/'+id_factura;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            // console.log(request.responseText)
            var data = JSON.parse(request.responseText);
            // console.log(objData["enlace"]);
            window.open(data["enlace_del_pdf"], "_blank");
        }

    };

}

function DescargarXML(id_factura){
    var id_factura = id_factura;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Bills/getBillsID/'+id_factura;
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            // console.log(request.responseText)
            var data = JSON.parse(request.responseText);
            window.open(data["enlace_del_xml"], "_blank");
        }

    };
}

function AnularFactura(id_factura){
    var id_factura = id_factura;
    swal({
        title: "Anular factura",
        text: "¿Desea elimar la factura?",
        icon: "warning",
        buttons:true,
        dangerMode: true,
        buttons:["No, cancelar","Si, eliminar"],closeModal:false
    }).then((willDelete) => {

        if(willDelete){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/Bills/delBills';
            var strData="id_factura="+id_factura;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                    
                    if(objData.status)
                    {
                        swal("Factura",objData.msg,"success");
                        tableBills.api().ajax.reload();
                    }
                    else
                    {
                        swal("Factura",objData.msg,"error");
                    }
                }
            }

        }
     })
}