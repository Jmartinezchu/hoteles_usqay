
let tableCategoryRoom;

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
      tableCategoryRoom = $('#tableCategoryRoom').dataTable({
          "aProcessing":true,
          "aServerSide":true,
          "language": {
              "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
          },
          "ajax": {
              "url": " "+base_url+"/CategoryRoom/getCategoryRooms",
              "dataSrc": ""
          },
          "columns": [
              {"data":"id_categoria_habitacion"},
              {"data":"nombre_categoria_habitacion"},
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

  function guardarCategoriaHabitacion(){
    let formCategoryRoom = document.querySelector("#formCategoryRoom");
          event.preventDefault();
  
          let nombre = document.querySelector("#nombre_categoria_habitacion").value;
  
          if(nombre  == '') {
              Swal.fire("Atencion","El campo es obligatorio","error");
              return false;
          }
  
          let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
  
  
          let ajaxUrl = base_url+'/CategoryRoom/setCategoryRoom';
  
          let formData = new FormData(formCategoryRoom);
          
          request.open("POST",ajaxUrl,true);
          request.send(formData);
          
          request.onreadystatechange = function(){
              if(request.readyState == 4 && request.status == 200){
                //   console.log(JSON.parse(request.responseText));
                  let objData = JSON.parse(request.responseText);
                  
                  if(objData.status){
                      
                        Swal.fire("Categoria Habitacion",objData.msg,"success");
                      
                      tableCategoryRoom.api().ajax.reload();
                       formCategoryRoom.reset();
  
                  }else{
                        Swal.fire("Error",objData.msg,"error");
                  }
                  
              }
             
          }
          window.location.reload();
  }

    function DeleteCategoryRoom(id_categoria_habitacion){
        
        var id_categoria_habitacion = id_categoria_habitacion;
        Swal.fire({
            title: 'Eliminar Categoria Habitacion',
            text: "¿Desea eliminar la categoria Habitacion?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
        }).then((willDelete) => {
            if(willDelete.isConfirmed){
                var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl=base_url+'/CategoryRoom/deleteCategoryRooms';
                var strData="id_categoria_habitacion="+id_categoria_habitacion;

                request.open("POST",ajaxUrl,true);
                request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                request.send(strData);

                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status==200 )
                    {
                        var objData=JSON.parse(request.responseText);
                    
                        if(objData.status)
                        {
                            Swal.fire("CATEGORIA - HABITACION",objData.msg,"success");
                            tableCategoryRoom.api().ajax.reload();
                            
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

    function cancelar(){
        let formCategoryRoom = document.querySelector("#formCategoryRoom");
        formCategoryRoom.reset();
    }

    function EditCategoryRoom(id_categoria_habitacion){

        var id_categoria_habitacion = id_categoria_habitacion;
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/CategoryRoom/getCategoryRoom/'+id_categoria_habitacion; //url
    
        request.open("POST",ajaxUrl,true);
        request.send();
    
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200)
            {
                var objData =  JSON.parse(request.responseText);
                
                // console.log(objData);
                
                document.querySelector('#id_categoria_habitacion').value = objData.data.id_categoria_habitacion;
    
                document.querySelector('#nombre_categoria_habitacion').value = objData.data.nombre_categoria_habitacion;
    
            }
     }
    }
    $('#tableCategoryRoom').dataTable();        
    