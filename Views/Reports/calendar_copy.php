<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $data['page_title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link rel="stylesheet" href="<?= media(); ?>/plugins/bootstrap/css/bootstrap.min.css">
    <script src = "<?= media(); ?>/plugins/jquery/jquery-3.0.0.min.js"> </script>
    <link href='<?= media(); ?>/lib/fullcalendar.min.css' rel='stylesheet' />
    <link href='<?= media(); ?>/lib/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <link href='<?= media(); ?>/lib/scheduler.min.css' rel='stylesheet' />
    <!-- jQuery 2.2.3 -->
    <script src="<?= media(); ?>/js/jquery-2.2.3.min.js"></script>
    <script src='<?= media(); ?>/lib/moment.min.js'></script>
    <script src='<?= media(); ?>/lib/fullcalendar.min.js'></script>
    <script src='<?= media(); ?>/lib/scheduler.min.js'></script>
    <link rel="shortcut icon" href="<?= media(); ?>/images/usqay-icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= media(); ?>/styles/main.min.css">
    <style>
     
     body {
    margin: 0;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
    }

    p {
        text-align: center;
    }

    #calendar {
    
        max-width: 1200px !important;
        margin: 50px auto;

    }

    .fc-resource-area td {
        cursor: pointer;
    }
    .close{
        float: right;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: 1;
    }
    .fc-timeline-event .fc-time {
        font-weight: 700;
        padding: 0 1px;
        display: none !important;
    }
    </style>

</head>

<body>

    
    <?php 
      $con = new Mysql();
      $sql =  "SELECT r.id_reservacion, r.fecha_inicio, r.fecha_fin, u.nombres as cliente FROM reservaciones r INNER JOIN usuario u ON r.cliente = u.idusuario WHERE reservacion_estado_id != 4 ";
      $reservaciones = $con->listar($sql);
      // var_dump($reservaciones);
    ?>

<?php 
      $hab = new Mysql();
      $sql =  "SELECT * FROM habitacion";
      $rooms = $hab->listar($sql);
      // $id = $rooms['idhabitacion'];
      // $nombre = $rooms['nombre_habitacion'];
?>
  

    <div class="container p-5" >
        <div id="calendar"></div>
    </div>

    
  <!-- Modal add. update, delete-->
  <div class="modal fade" id="ModalEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content modal-success">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="titleEvent"> </h4>
              </div>
        <div class="modal-body" style="background-color: #f5eded !important;">
          <div class="row">
            <div class="col-md-offset-1 col-md-10">

              <div class="form-group"> 
                <div class="input-group">
                    <span class="input-group-addon"> Habitación &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                     <select name="id_habitacion" id="id_habitacion" class="form-control">
                      <?php foreach($rooms as $room){?>
                      <option value="<?php echo "1"?>"><?php echo "1"?></option>
                      <?php }?>
                    </select> 
                </div>
              </div>

              <div class="form-group"> 
                <div class="input-group">
                    <span class="input-group-addon"> Check In  &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <input type="date" class="form-control" name="txtDate" id="txtDate" required >
                    <span class="input-group-addon"> Hora</span>
                    <input type="time" class="form-control" name="txtHour" id="txtHour"  required >
                </div>
              </div>

              <div class="form-group"> 
                <div class="input-group">
                    <span class="input-group-addon"> Check Out &nbsp;&nbsp; &nbsp;</span>
                    <input type="date" class="form-control" name="txtDateEnd" id="txtDateEnd"  required >
                    <span class="input-group-addon"> Hora &nbsp;&nbsp;</span>
                    <input type="time" class="form-control" name="txtHourEnd" id="txtHourEnd" required >

                </div>
              </div>

              <div class="form-group"> 
                <div class="input-group">
                  <span class="input-group-addon"> Documento &nbsp;&nbsp; </span>
                  <input type="text" class="form-control" name="documento" id="documento" required placeholder="Ingrese documento">
                </div>
              </div>

              <div class="form-group"> 
                <div class="input-group">
                  <span class="input-group-addon"> Nombres &nbsp;&nbsp; &nbsp;&nbsp;</span>
                  <input type="text" class="form-control" name="nombre" id="nombre" required placeholder="Nombres completos">
                </div>
              </div>

              <div class="form-group"> 
                <div class="input-group">
                  <span class="input-group-addon"> Dirección &nbsp;&nbsp; &nbsp;&nbsp;</span>
                  <input type="text" class="form-control" name="direccion" id="direccion" required placeholder="Dirección">
                </div>
              </div>

              <div class="form-group"> 
                <div class="input-group">
                  <span class="input-group-addon"> Observación </span>
                  <input type="text" class="form-control" name="observacion" id="observacion" required placeholder="Observación">
                </div>
              </div>
 
              


            </div>
           </div>

          <input type="hidden" id="txtId" name="txtId"><br>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success"  id="btnAdd">Agregar</button>
          <button type="button" class="btn btn-secondary" id="btnUpdate">Actualizar</button>
          <button type="button" class="btn btn-danger" id="btnDel">Eliminar</button>
          <button type="button" class="btn btn-default"  id="btnClose">Cancelar</button>
          
        </div>
      </div>
    </div>
  </div>

    <script>

    $(function() { // document ready

        $('#calendar').fullCalendar({
        now: new Date(),
        editable: true,
        selectable: true,
        aspectRatio: 1.8,
        scrollTime: '00:00',
        header: {
            left: 'promptResource today prev,next',
            center: 'title',
            right: 'timelineMonth,timelineDay,timelineThreeDays'
        },
        defaultView: 'timelineMonth',
        views: {
            timelineThreeDays: {
            type: 'timeline',
            duration: { days: 5 } 
            }
        },
        resourceAreaWidth: '15%',   
        resourceColumns: [
            {
            labelText: 'Habitaciones', 
            field: 'title'
            }
        ],        
        
        //Cambiar url
        resources: "http://localhost/hoteles/Reports/getRooms",
        // events: "index.php?action=reservas",
        
    
    
        eventRender: function(calEvent, element) {

            
            var hoy = Date();
            
            if (calEvent.estado == '0') {
                element.css({
                    'background-color': '#33ad85',
                    'border-color': '#333333',
                    'color': 'white'
                });
            }
            if (calEvent.estado == '3') {
                element.css({
                    'background-color': '#f0ad4e',
                    'border-color': '#333333',
                    'color': 'white'
                });
            }
        }

        });
    
    }); 


    $('#bagregar').click(function(){
        
        DataGUI();
        DataSendUI('addroom',NewEvent);
        $('#ModalRoom').modal('toggle');
        limpiar();
        $('#calendar').fullCalendar('refetchResources');
        });

    $('#btnAdd').click(function(){
        
        DataGUI();
        DataSendUI('agregar',NewEvent);
        $('#ModalEvent').modal('toggle');
        limpiar();
        });

        $('#btnDel').click(function(){
        
        DataGUI();
        DataSendUI('eliminar',NewEvent);
        $('#ModalEvent').modal('toggle');
        limpiar();
        });

        $('#btnUpdate').click(function(){
        
        DataGUI();
        DataSendUI('actualizar',NewEvent);
        $('#ModalEvent').modal('toggle');
        limpiar();
        });

        $('#btnClose').click(function(){

        $('#ModalEvent').modal('toggle'),
        limpiar();
        });

        $('#btnClose1').click(function(){ 
        $('#ModalEvent').modal('toggle'),
        limpiar();
        });

    function limpiar() {
            document.getElementById("txtId").value = "";
            document.getElementById("id_habitacion").value = "";
            document.getElementById("documento").value = "";
            document.getElementById("nombre").value = "";
            document.getElementById("direccion").value = "";
            document.getElementById("txtDate").value = "";
            document.getElementById("txtDateEnd").value = "";
            document.getElementById("observacion").value = "";
            $("#titleEvent").empty();

        }

        function DataGUI(){

            NewEvent={
            // TABLE EVENTO 
            id:$('#txtId').val(),
            id_habitacion:$('#id_habitacion').val(),
            documento:$('#documento').val(),
            nombre:$('#nombre').val(),
            direccion:$('#direccion').val(),
            observacion:$('#observacion').val(),
            start:$('#txtDate').val()+" "+$('#txtHour').val(),
            end:$('#txtDateEnd').val()+" "+$('#txtHourEnd').val()
        };
    
        }       

        function DataSendUI(accion,objEvento){ 
            $.ajax({
            type:'POST',
            //Cambiar url
            url:'index.php?action=reserva&accion='+accion,
            data:objEvento, 
            success:function(msg){
                if (msg){
                $('#calendar').fullCalendar('refetchEvents');
                if(!modal){
                $('#ModalEvent').modal('toggle');
                $('#ModalRoom').modal('toggle');
                }
                }
            },
            error:function(){
                alert("Hay un error");
            }
            });

        }





    </script>
    <script src='<?= media(); ?>/lib/locale/es.js'></script>
   

    </script>
</body>
</html>