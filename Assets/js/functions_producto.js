
let tableProductos;

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
    tableProductos = $('#tableProductos').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " "+base_url+"/Producto/getProductos",
            "dataSrc": ""
        },
        "columns": [
            {"data":"idProducto"},
            {"data":"nombre"},
            {"data":"codesunat"},
  
            {"data":"codecategoria"},
            {"data":"precio_venta"},
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
} , false);

$('#tableProductos').dataTable();

    // console.log(tableProductos);
    window.addEventListener('load', ()=>{
        
        SearchCodeSunat();
        SearchCodeCategoria();
    });

    
    function guardarProductos(){
        let formProducto = document.querySelector("#formProducto");
            event.preventDefault();
    
            let nombre = document.querySelector("#nombre").value;
            if(nombre  == '') {
                Swal.fire("Atencion","El campo es obligatorio","error");
                return false;
            }
    
            let request  = (window.XMLHttpRequest) ? new XMLHttpRequest() :  new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Producto/setProducto';
            let formData = new FormData(formProducto);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
    
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
    
                    if(objData.status){
                        formProducto.reset();
                        Swal.fire("Producto",objData.msg,"success");
                        tableProductos.api().ajax.reload();
                        window.location.reload();
                    }else{
                        Swal.fire("Error",objData.msg,"error");
                    }
                }
        } 
    }

    function cancelar(){
        let formProducto = document.querySelector("#formProducto");
        formProducto.reset();
    }

    function SearchCodeSunat(){
        let ajaxUrl = base_url+'/CodeSunat/getSelectCodeSunat';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
    
        request.onreadystatechange = function(){
            if(request  .readyState == 4 && request.status == 200){
                document.querySelector('#codesunat').innerHTML = request.responseText;
                document.querySelector('#codesunat').value = 26137;
            
            }
        }
    }
    function SearchCodeCategoria(){
        let ajaxUrl = base_url+'/CateProduct/getSelectCateProduct';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
    
        request.onreadystatechange = function(){
            if(request  .readyState == 4 && request.status == 200){
                document.querySelector('#codecategoria').innerHTML = request.responseText;
                document.querySelector('#codecategoria').value = 1;
            
            }
        }
    }


    let btnCancelar =  document.querySelector("#btnCancelar");
    btnCancelar.addEventListener('click', () => {
        formProducto.reset();
    } )

function eliminarProducto(idProducto){

    var idProducto=idProducto;

    Swal.fire({
        title: 'Eliminar Producto',
        text: "¿Desea eliminar el Producto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!'
    }).then((willDelete) => {

        if(willDelete.isConfirmed){
            var request=(window.XMLHttpRequest)  ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl=base_url+'/Producto/deletProducto';
            var strData="idProducto="+idProducto;

            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            request.send(strData);

            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status==200 )
                {
                    var objData=JSON.parse(request.responseText);
                    
                    if(objData.status)
                    {
                        Swal.fire("Producto",objData.msg,"success");
                        tableProductos.api().ajax.reload();
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
function editarProducto(idproducto){


    var idproducto = idproducto;
 
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Producto/getProducto/'+idproducto; //url

    request.open("POST",ajaxUrl,true);
    request.send();
  
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200)
        {
            var objData =  JSON.parse(request.responseText);
            
            // console.log(objData);
            if(objData.status)
            {
                
            document.querySelector('#idProducto').value = objData.data.idProducto;
            
            document.querySelector('#codecategoria').value = objData.data.categoriaid;

            document.querySelector('#nombre').value = objData.data.nombre;

            document.querySelector('#codesunat').value = objData.data.sunatid;

            document.querySelector('#precio_venta').value = objData.data.precio_venta;
            tableProductos.api().ajax.reload();
            // window.location.href = base_url+'/producto';
            
            }
            else
            {
                Swal.fire("Atencion",objData.msg,"Error");
            }
            
            
        }
        
 }
}

function numeros(string){//Solo numeros
    var out = '';
    var filtro = '1234567890.';//Caracteres validos
    
    //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos 
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
             //Se añaden a la salida los caracteres validos
         out += string.charAt(i);
    
    //Retornar valor filtrado
    return out;
} 
