let tableRooms;
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
      tableRooms = $('#tableRooms').dataTable({
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
window.addEventListener('load', () => {
 
    categoryRooms();
    Rooms();
    $("#categoria").on("change", function(){
        if($("#categoria").val())
        {
            document.querySelector("#foodrooms").style.display = "none";
            let ajaxUrl = base_url+'/Reservations/getSelectCategoryRooms/'+$("#categoria").val();
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            request.open("GET",ajaxUrl,true);
            request.send();
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    const arrData = objData.data.map((inf) => {
                        return '<a href="" class="reservar"><p>Habitacion '+inf.nombre_habitacion+'</p><p><i class="fa fa-users" aria-hidden="true"></i> '+inf.capacidad+'</p></a>'

                    })
                    document.querySelector('#foo').innerHTML = arrData.join("")
                    
                }
            }
            
        }
          
      });

 
 },false);
 


function categoryRooms(){
    let ajaxUrl = base_url+'/Reservations/getCategoryRooms';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#categorias').innerHTML = request.responseText;
            document.querySelector('#categorias').value = 1;
        }
    }
}


function Rooms(){
    let ajaxUrl = base_url+'/Reservations/getRooms';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request  .readyState == 4 && request.status == 200){
            document.querySelector('#habitacion').innerHTML = request.responseText;
            document.querySelector('#habitacion').value = 3;
        }
    }
}


