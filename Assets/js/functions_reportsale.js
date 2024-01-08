let tableSales;
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
      tableSales = $('#tableSales').dataTable({
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

$('.date-picker').datepicker( {
    closeText: 'Cerrar',
	prevText: '<Ant',
	nextText: 'Sig>',
	currentText: 'Hoy',
	monthNames: ['1 -', '2 -', '3 -', '4 -', '5 -', '6 -', '7 -', '8 -', '9 -', '10 -', '11 -', '12 -'],
	monthNamesShort: ['Enero','Febrero','Marzo','Abril', 'Mayo','Junio','Julio','Agosto','Septiembre', 'Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    showDays: false,
    onClose: function(dateText, inst) {
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
});




function fntSearchVMes(){
    let fecha = document.querySelector(".pagosMeses").value;
    if(fecha == ""){
        swal("", "Seleccione mes y año" , "error");
        return false;
    }else{
        let request = (window.XMLHttpRequest) ? 
            new XMLHttpRequest() : 
            new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Dashboard/salesMount';
      
        let formData = new FormData();
        formData.append('fecha',fecha);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState != 4) return;
            if(request.status == 200){
                // console.log(request.responseText);
                $("#graficames").html(request.responseText);
              
                return false;
            }
        }
    }
}