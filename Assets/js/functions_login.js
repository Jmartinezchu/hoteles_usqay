

document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector("#formlogin")){

        let formLogin =  document.querySelector("#formlogin");
        formLogin.onsubmit = function(e){
            e.preventDefault();

            let strEmail = document.querySelector("#email").value;
            let strPassword = document.querySelector("#password").value;

            if(strEmail == '' || strPassword == ''){
                swal("Atencion", "Todos los campos son obligatorios", "error");
                return false;
            }else{
                // document.querySelector("#divLoading").classList.replace("d-none","d-flex");
                var request =  (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url+'/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST",ajaxUrl,true);
                request.send(formData);

                request.onreadystatechange = function(){
                    if(request.readyState != 4) return;
                    if(request.status == 200){
                        var objData = JSON.parse(request.responseText);
                        if(objData.status)
                        {
                           window.location = base_url+'/OpenBox';
                        }else{
                            swal("Atencion", objData.msg, "error");
                            document.querySelector("#password").value = "";
                        }
                    }else{
                        swal("Atencion", "Error en el proceso", "error");
                    }
                    // document.querySelector("#divLoading").classList.replace("d-flex","d-none");
    
                    return false;
                }
                
            }
        }
    }
}, false);