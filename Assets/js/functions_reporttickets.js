let tableTickets;
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
      tableTickets = $('#tableTickets').dataTable({
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


function DescargarBoleta(id_boleta){
    var id_boleta = id_boleta;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Tickets/getTicketsID/'+id_boleta;
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

function DescargarXML(id_boleta){
    var id_boleta = id_boleta;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Tickets/getTicketsID/'+id_boleta;
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

function AnularBoleta(id_boleta){
    var id_boleta = id_boleta;
    swal({
        title: "Anular boleta",
        text: "¿Desea elimar la boleta?",
        icon: "warning",
        buttons:true,
        dangerMode: true,
        buttons:["No, cancelar","Si, eliminar"],closeModal:false
    }).then((willDelete) => {

        if(willDelete){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/Tickets/delTicket';
            var strData="id_boleta="+id_boleta;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                    
                    if(objData.status)
                    {
                        swal("Boleta",objData.msg,"success");
                        tableTickets.api().ajax.reload();
                    }
                    else
                    {
                        swal("Boleta",objData.msg,"error");
                    }
                }
            }

        }
     })
}
