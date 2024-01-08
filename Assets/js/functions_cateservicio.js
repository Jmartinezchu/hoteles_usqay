
let tableCateServicio;

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
      tableCateServicio = $('#tableCateServicio').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/CateServicio/getCateServicio",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idcategoria"},
            {"data":"descripcion"},
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

function guardarCategoriaServicio(){
    let formCateServicio = document.querySelector("#formCateServicio");
        event.preventDefault();

        // let idcategoria=document.querySelector("#idcategoria").value;

        let nombre = document.querySelector("#nombre").value;

        if(nombre  == '') {
            Swal.fire("Atencion","El campo es obligatorio","error");
            return false;
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');


        let ajaxUrl = base_url+'/CateServicio/setCateServicio';

        let formData = new FormData(formCateServicio);
        
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                // console.log(JSON.parse(request.responseText));
                let objData = JSON.parse(request.responseText);
                
                if(objData.status){
                    
                    Swal.fire("Categoria Servicio",objData.msg,"success");
                    
                    tableCateServicio.api().ajax.reload();
                    formCateServicio.reset();
                    window.location.reload();

                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
                
            }
           
        }
}

function cancelar(){
    let formCateServicio = document.querySelector("#formCateServicio");
    formCateServicio.reset();
}
function eliminarCateServicio(idcategoria){

    var idcategoria=idcategoria;

    Swal.fire({
        title: 'Eliminar Categoria Servicio',
            text: "¿Desea eliminar la categoria Servicio?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {

        if(willDelete.isConfirmed){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/CateServicio/deleteCateServicio';
            var strData="idcategoria="+idcategoria;

            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                   
                    if(objData.status)
                    {
                        Swal.fire("CATEGORIA - SERVICIO",objData.msg,"success");
                        tableCateServicio.api().ajax.reload();
                        
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



function EditCategoria(idcategoria){

    var idcategoria = idcategoria;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/CateServicio/getCategoria/'+idcategoria; //url

    request.open("POST",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
            
            // console.log(objData);
            
            document.querySelector('#idcategoria').value = objData.data.idcategoria;

            document.querySelector('#nombre').value = objData.data.descripcion;

        }
 }
}
$('#tableCateServicio').dataTable();        

        
    
