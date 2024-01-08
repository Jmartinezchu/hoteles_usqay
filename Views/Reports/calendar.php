<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $data['page_title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src = "https://code.jquery.com/jquery-3.0.0.min.js"> </script>
    <script src="
https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js
"></script>

    <link rel="shortcut icon" href="<?= media(); ?>/images/usqay-icon.svg" type="image/x-icon">
 
    <link rel="stylesheet" href="<?= media(); ?>/styles/main.min.css">
    <style>
     
        html, body {
        margin: 0;
        padding: 0;
        font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
        font-size: 14px;
        }

        #calendar {
        max-width: 900px;
        margin: 40px auto;
        }
       

        #calendar a.fc-event {
        color: grey; /*los estilos predeterminados de bootstrap lo hacen negro. deshacer  */
        }
    </style>

</head>

<body>

<div class="modal" id="exampleModal"  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>

      <!--Este es el pie del modal aqui puedes agregar mas botones-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    <script>
      const base_url = "<?= base_url(); ?>";
    </script>
    <?php 
      $con = new Mysql();
      $sql =  "SELECT r.id_reservacion, r.fecha_inicio, r.fecha_fin, u.nombres as cliente, h.nombre_habitacion FROM reservaciones r INNER JOIN usuario u ON r.cliente = u.idusuario INNER JOIN habitacion h on h.idhabitacion = r.habitacion_id WHERE reservacion_estado_id != 4 and r.reservacion_estado_id !=0; ";
      $reservaciones = $con->listar($sql);
      // var_dump($reservaciones);
    ?>
  

    <div class="container p-5" >
    <div>
    <button type="button" class="btn btn-success" onclick="history.back()">◄ Volver</button>
    <a class="btn btn-primary" href="<?= base_url(); ?>/reservations/create">Crear Reserva</a>
    </div>
        <div id="calendar"></div>
    </div>
    <!-- <div>jajaj</div> -->

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    timeZone: 'local',
                    editable: true,
                    headerToolbar: {
                        left: 'prev next today',
                        center: 'title',
                        right: 'dayGridMonth listWeek'
                    },
                    locale: 'es',
                    buttonIcons: true,
                    weekNumbers: false,
                    editable: true,
                
                     events: [
                        <?php foreach($reservaciones as $reserv){
                        ?>{
                            title    : '<?php echo $reserv['nombre_habitacion'] . ' ' . $reserv['cliente']; ?>',
                            id      : '<?php echo $reserv['id_reservacion']?>',
                            start    : '<?php echo $reserv['fecha_inicio'] ?>',
                            end: '<?php echo $reserv['fecha_fin'] ?>',
                            color    : "#EF6A0", 
                            textColor: "white",
                            
                            
                          },
                        <?php } ?>
                        
                  
                ], 	
                eventClick: function(info) {
                   // alert(info.event.id);
                  //  window.location.href = base_url+'/Reservations/show?id='+info.event.id
                   window.location.href = base_url+'/hospedar/show?id='+info.event.id

                    // $('#exampleModal').modal('show');

  	         	}	 
                
               
        });
        calendar.render();
                }
            //  }
            // }
            
    // }
    );

    </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.min.js"></script>
    <script src="<?= media(); ?>/js/jquery.min.js"></script>
</body>
</html>