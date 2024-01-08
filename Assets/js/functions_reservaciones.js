let tableReservation;

document.addEventListener("DOMContentLoaded", function() {

    tableReservation = $('#tableReservation').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/Reservations/getReservations",
            "dataSrc": ""
        },
        "columns": [
            {"data":"id_reservacion"},
            {"data":"cliente"},
            {"data":"fecha_inicio"},
            {"data":"fecha_fin"},
            {"data":"origen"},
            {"data":"nombre"},
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

   
}, false);


function openCreate(){
    location.href = base_url+'/Reservations/create';
}

function viewReservacion(id_reservacion){
    var id_reservacion = id_reservacion;
    window.location.href = base_url+'/reservations/show?id='+id_reservacion;
}

function viewCalendar(){
    url = base_url+'/reports/calendar';

    var open_calendar = window.open(url,'_blank');
    open_calendar.focus();
}
function fntEditReservacion(id_reservacion){
    var id_reservacion = id_reservacion;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Reservations/getReservationId/'+id_reservacion;
    request.open("GET",ajaxUrl,true);
    request.send();
    // console.log(id_reservacion);

    // request.onreadystatechange = function(){
    //     if(request.readyState == 4 && request.status == 200){
    //         var objData = JSON.parse(request.responseText);
    //     }
    // }
}

function AnularReservacion(id_reservacion){
    var id_reservacion = id_reservacion;
    //console.log(id_reservacion)
    swal({
     title: "Anular Reservación",
     text: "¿Desear anular la Reservación?",
     icon: "warning",
     buttons:true,
     dangerMode: true,
     buttons: ["No,cancelar","Si, eliminar"],
     closeModal: false
    }).then((willDelete) => {
        if(willDelete){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/Reservations/delReservation';
            var strData="id_reservacion="+id_reservacion;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                    
                    if(objData.status)
                    {
                        swal("Reservacion",objData.msg,"success");
                        tableReservation.api().ajax.reload();
                    }
                    else
                    {
                        swal("Reservacion",objData.msg,"error");
                    }
                }
            }
        }
    })
 }