
document.addEventListener("DOMContentLoaded",function(){
    Swal.fire({
        title : 'Por favor espere',
        text : 'Procesando...',
        timer: 700,
        icon : 'info',
        allowOutsideClick : false,
        allowEscapeKey : false
      })
      Swal.showLoading()
    
    
})

let formHabitacion = document.querySelector("#formHabitacion");
    function guardarEstadoHabitacion(){
        event.preventDefault();

        let nombre = document.querySelector("#nombre").value;
        let estado = document.querySelector("#estado").value;
        
        if(nombre  == '' || estado == '') {
            Swal.fire("Atencion","El campo es obligatorio","error");
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Rooms/actualizarEstadoHabitacion';
        let formData = new FormData(formHabitacion);
        request.open("POST",ajaxUrl,true);
        request.send(formData);

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status){
                    formHabitacion.reset();
                    Swal.fire("Habitacion",objData.msg,"success");
                    window.location.reload();
                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
            }
        }
    }

window.addEventListener('load', () => {
    initCounterTimeRoom();
 },false);

function verReserva(id_reservacion){
    window.location.href = base_url+'/hospedar/show?id='+id_reservacion;
}



function hospedarHabitacion(id, nombre_habitacion){
    window.location.href = base_url+"/hospedar/create?id="+id+'&habitacion='+nombre_habitacion;
    
    $('#total').html("S/. "+ precio_dia * days);
    $('#total_reserva').val(precio_dia * days);

    let url = base_url+"Reservations/setReservationsId/"+id;
    let formData = new FormData(formReserva);
    request.open("POST",url,true);
    request.send(formData);
    // console.log(formData);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                Swal.fire("Reservacion",objData.msg,"success");
                  Swal.showLoading()
                window.location = base_url+'/reservations';
            }
        }
    }

}

function cambiarEstadoHabitacion(idhabitacion){

    // console.log(idhabitacion)
    var idhabitacion =  idhabitacion;

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Rooms/getRoomsId/'+idhabitacion;

    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
            if(objData.status)
            {
                document.querySelector('#idhabitacion').value = objData.data.idhabitacion;
                document.querySelector('#nombre').value = objData.data.nombre_habitacion;
                // document.querySelector('#estado').value = objData.data.estado_habitacion;

                $('#modalEstadoHabitacion').modal('show');
            }
            else {
                Swal.fire("Error",objData.msg,"error");
            }
        }
    }

}

function initCounterTimeRoom() {

    //Obtener datos del NodeList
    var rooms = Array.from(document.querySelectorAll('.stopwatch'));
    // console.log(rooms);

    //obtener los id del NodeList
    var idroom = rooms.map(function(room){
      return room.id;
    });
    // console.log(idroom)

    //recorrer todas las habitaciones
    for(var i=0; i<idroom.length; i++){

    //obtener los datos de cada habitacion
    var datos = document.getElementById(idroom[i]);
    // console.log(datos)

    //obtener la fecha de cada habitacion
    var fecha = datos.getAttribute("timer-room");
    // console.log(fecha);

    //obtener el id de cada habitacion
    var identificador = datos.getAttribute("identificador");
    // console.log(identificador);
    
    //obtener el estado de cada habitacion
    var estado = datos.getAttribute("estado");
    // console.log(estado);
      if(estado == 'Checked In'){
        start(identificador, fecha);
      }else{
        // stop(identificador);
      }
    }

  }

let stopwatchInterval;
let runningTime = 0;


const start = (identificador, fecha) => {
    // console.log('DavidZB :p!')
    const stopwatch = document.getElementById('stopwatch'+identificador);
    let startDateTime = new Date(fecha);
    let startTime = startDateTime.getTime();
    stopwatchInterval = setInterval( () => {
    runningTime = Date.now() - startTime;
    stopwatch.textContent = calculateTime(runningTime);
    }, 1000)

    // console.log(stopwatchInterval)
}

const calculateTime = runningTime => {
    const total_seconds = Math.floor(runningTime/1000);
    const total_minutes = Math.floor(total_seconds/60);
    const total_hours = Math.floor(total_minutes/60);

    const display_seconds = (total_seconds % 60).toString().padStart(2, "0");
    const display_minutes = (total_minutes % 60).toString().padStart(2, "0");
    const display_hours = (total_hours % 60).toString().padStart(2, "0");

    return `${display_hours}:${display_minutes}:${display_seconds}`
}

const stop = (identificador) => {
    const stopwatch = document.getElementById('stopwatch'+identificador);
    runningTime = 0;
    clearInterval(stopwatchInterval);
    stopwatch.textContent = '00:00:00';
}
