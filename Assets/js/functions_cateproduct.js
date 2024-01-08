
let tableCateProduct;

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
    tableCateProduct = $('#tableCateProduct').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/CateProduct/getCateProduct",
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

function guardarCategoriaProducto(){
    let formCateProduct = document.querySelector("#formCateProduct");
        event.preventDefault();

        // let idcategoria=document.querySelector("#idcategoria").value;

        let nombre = document.querySelector("#nombre").value;

        if(nombre  == '') {
            Swal.fire("Atencion","El campo es obligatorio","error");
            return false;
        }

        let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');


        let ajaxUrl = base_url+'/CateProduct/setCateProduct';

        let formData = new FormData(formCateProduct);
        
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                // console.log(JSON.parse(request.responseText));
                let objData = JSON.parse(request.responseText);
                
                if(objData.status){
                    
                    Swal.fire("Categoria Producto",objData.msg,"success");
                    
                    tableCateProduct.api().ajax.reload();
                    formCateProduct.reset();
                    window.location.reload();

                }else{
                    Swal.fire("Error",objData.msg,"error");
                }
                
            }
           
        }
}

function cancelar(){
    let formCateProduct = document.querySelector("#formCateProduct");
    formCateProduct.reset();
}
function eliminarCateProduct(idcategoria){

    var idcategoria=idcategoria;

    Swal.fire({
        title: 'Eliminar Categoria Producto',
            text: "¿Desea eliminar la categoria Producto?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {

        if(willDelete.isConfirmed){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/CateProduct/deleteCateProduct';
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
                        Swal.fire("CATEGORIA - PRODUCTO",objData.msg,"success");
                        tableCateProduct.api().ajax.reload();
                        
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

    
             
    // document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
    // document.querySelector('.modal-header').classList.replace("headerRegister","headerUpdate");
    // document.querySelector('#btnActionForm').classList.replace("btn-success","btn-info");
    // document.querySelector('#titleBtn').innerHTML = "Actualizar";
    
    //obtener el atributo rl del controlador para editar
    var idcategoria = idcategoria;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/CateProduct/getCategoria/'+idcategoria; //url

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
$('#tableCateProduct').dataTable();        

        
    
