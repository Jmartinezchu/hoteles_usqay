
let tablePisoHabitacion;

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
      tablePisoHabitacion = $('#tablePisoHabitacion').dataTable({
          "aProcessing":true,
          "aServerSide":true,
          "language": {
              "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
          },
          "ajax": {
              "url": " "+base_url+"/PisoHabitacion/getVariosPisos",
              "dataSrc": ""
          },
          "columns": [
              {"data":"idpiso"},
              {"data":"nombrepiso"},
              {"data":"estado"},
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
  })
  
    function guardarSalon(){
        let formPisoHabitacion = document.querySelector("#formPisoHabitacion");
          event.preventDefault();
  
          let nombre = document.querySelector("#nombrepiso").value;
  
          if(nombre  == '') {
              Swal.fire("Atencion","El campo es obligatorio","error");
              return false;
          }
  
          let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
  
  
          let ajaxUrl = base_url+'/PisoHabitacion/setPiso';
  
          let formData = new FormData(formPisoHabitacion);   
          request.open("POST",ajaxUrl,true);
          request.send(formData);
          
          request.onreadystatechange = function(){
              if(request.readyState == 4 && request.status == 200){
                //   console.log(JSON.parse(request.responseText));
                  let objData = JSON.parse(request.responseText);
                  
                  if(objData.status){
                      
                    Swal.fire("Piso Hotel",objData.msg,"success");
                      
                      tablePisoHabitacion.api().ajax.reload();
                       formPisoHabitacion.reset();
  
                  }else{
                    Swal.fire("Error",objData.msg,"error");
                  }
                  
              }
              window.location.reload();
      }
      
    }

    function cancelar(){
         formPisoHabitacion.reset();
    }

    function DeletePiso(idpiso){
        
        var idpiso = idpiso;

        Swal.fire({
            title: 'Eliminar Salon',
                text: "¿Desea eliminar el Salon?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!'
        }).then((willDelete) => {
    
            if(willDelete.isConfirmed){
                var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl=base_url+'/PisoHabitacion/deletePiso';
                var strData="idpiso="+idpiso;

                request.open("POST",ajaxUrl,true);
                request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                request.send(strData);

                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status==200 )
                    {
                        var objData=JSON.parse(request.responseText);
                    
                        if(objData.status)
                        {
                            Swal.fire("PISO - HOTEL",objData.msg,"success");
                            tablePisoHabitacion.api().ajax.reload();
                            
                        }
                        else
                        {
                            Swal.fire("Atencion",objData.msg,"error");
                        }
                    }
                }

            }
        })
    }

    

    function EditPiso(idpiso){

        var idpiso = idpiso;
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/PisoHabitacion/getUnPiso/'+idpiso; //url
    
        request.open("POST",ajaxUrl,true);
        request.send();
    
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200)
            {
                var objData =  JSON.parse(request.responseText);
                
                // console.log(objData);
                
                document.querySelector('#idpiso').value = objData.data.idpiso;
    
                document.querySelector('#nombrepiso').value = objData.data.nombrepiso;
    
            }
     }
    }
    $('#tablePisoHabitacion').dataTable();        
    