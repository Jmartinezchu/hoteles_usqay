
window.addEventListener('load', () => {
    Swal.fire({
    title : 'Por favor espere',
    text : 'Procesando...',
    timer: 700,
    icon : 'info',
    allowOutsideClick : false,
    allowEscapeKey : false
    })
    Swal.showLoading()
    carga_cortes();
    // cajas();
    // Turnos();
  
},false);

// function cargar_cortes(){
//     let ajaxUrl = base_url+'/OpenBox/getCortes';
//     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//     request.open("GET",ajaxUrl,true);
//     request.send();

//     request.onreadystatechange = function(){
//         if(request.readyState == 4 && request.status == 200){
     
           
//         console.log(request.responseText)
//         document.querySelector('#cortes').innerHTML = request.responseText;
//                 // carga_data_corte();
           
        
//             // document.querySelector('#cortes').value = 1;
//         }
//     }
    
// }


function carga_cortes(){
    var caja = $("#cajas option:selected").val();
    if(caja === "")
    {
        TotalDiario();
    }else{
        var param = {
            'fecha': $('#fecha').val(),
            'caja': caja
        };
        $.ajax({
            url: base_url+'/OpenBox/getCortesDay',
            type: 'POST',
            data: param,
            cache: true,
            dataType: 'json',
            success: function(data) {
                if (data != "") {
                    var txt = "";
                    $.each(data, function(key, value) {
                        txt += "<option value='" + value + "'>" + value + "</option>";
                    });
                    //txt += "<option value='TODO'>Todo el Día</option>";
                    $("#cortes").html(txt);
                    carga_data_cortes();
                } else {
                    // alert("No Hubo actividad ese día");
                    swal("No hubo actividad ese día","","error");
                    var corte_actual = $("#cortes option:selected").val();
                    var dia = corte_actual.split(" ");
                    $('#fecha').val(dia[0]);
                }
            }
        });
    }
   
}

function carga_data_cortes(){
    var corte = $("#cortes option:selected").val();
    var caja = $("#cajas option:selected").val();

    var param = {
        'fecha': $('#fecha').val(),
        'corte': corte,
        'caja': caja
    };
    $.ajax({
        url: base_url+'/OpenBox/totalVendidoCorte',
        type: 'POST',
        data: param,
        cache: true,
        dataType: 'json',
        success: function(data) {
            $("#vendido").val(parseFloat(data.vendido).toFixed(2));
           
        }
    });
}

function corte(){
    if (confirm("Se hara un corte. ¿Deseas Continuar?")) {
        //Imprimimos corte actual
        var caja = $("#cajas option:selected").val();
        var corte = $("#cortes option:selected").val();
        var inicial = 1;

        if (caja === "") {
            corte = "";
            inicial = 0;
        }

        var param = {
            'fecha': $('#fecha').val(),
            'cajero': 'Jeason Cueva',
            'corte': corte,
            'inicial': inicial,
            'caja': caja,
            'tipo': 2
        };

       
        //Hacemos corte en si
        $.ajax({
            url: base_url+'/OpenBox/HacerCorte?caja=' + caja,
            type: 'POST',
            cache: true,
            dataType: 'json',
            success: function(data) {
                location.href = base_url+'/turnopening';
            }
        });
        

    
    }
}
// function cargar_cortes(){
//     var param = {
//         'fecha': $('#fecha').val(),
//         // 'caja': $('#caja').val()
//     };
//     console.log(param)
//     $.ajax({
//         url: base_url+'/Reports/getCortes',
//         type: 'POST',
//         data: param,
//         cache: true,
//         dataType: 'json',
//         success: function(data) {
//             if (data != "") {
//                 var txt = "";
//                 $.each(data, function(key, value) {
//                     txt += "<option value='" + value + "'>" + value + "</option>";
//                 });
//                 $("#cortes").html(txt);
//                 // carga_data_corte();
//             } else {
//                 alert("No Hubo actividad ese día");
//                 var corte_actual = $("#cortes option:selected").val();
//                 var dia = corte_actual.split(" ");
//                 $('#fecha').val(dia[0]);
//             }
//         }
//     });
// }


// function cajas(){
//     let ajaxUrl = base_url+'/CashRegister/getSelectCash';
//     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//     request.open("GET",ajaxUrl,true);
//     request.send();

//     request.onreadystatechange = function(){
//         if(request.readyState == 4 && request.status == 200){
//             document.querySelector('#cajas').innerHTML = request.responseText;
//             document.querySelector('#cajas').value = 1;
//         }
//     }
// }  
// function Turnos(){
//     let ajaxUrl = base_url+'/Turns/getSelectTurns';
//     let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
//     request.open("GET",ajaxUrl,true);
//     request.send();

//     request.onreadystatechange = function(){
//         if(request  .readyState == 4 && request.status == 200){
//             document.querySelector('#turnos').innerHTML = request.responseText;
//             document.querySelector('#turnos').value = 1;
//             console.log(request.responseText)
//         }
//     }
// } 

function imprimir(){
    var url  = base_url+'/Prints/closeBox';
    var win = window.open(url,'_blank');
    win.focus();
}


function email(){
    let ajaxUrl = base_url+'/Reports/email';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("POST",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            swal("Cierre de caja","Reporte enviado correctamente","success");
        }
    }
}

function buscar() {
    window.location.href = base_url+'/Reports/dayli?fecha=' + $('#fecha').val();
}

function generarPDF(){
    var HTML_Width = $("#panel_data").width();
    var HTML_Height = $("#panel_data").height();
    var top_left_margin = 5;
    var PDF_Width = HTML_Width+(top_left_margin*2);
    var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;


    html2canvas($("#panel_data")[0],{allowTaint:true}).then(function(canvas) {
        canvas.getContext('2d');
        
        // console.log(canvas.height+"  "+canvas.width);
        
        
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
        
        
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        
        pdf.save("cierre_de_caja.pdf");
    });
};