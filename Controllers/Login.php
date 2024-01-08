<?php 

 class Login extends Controllers{

     public function __construct(){
         session_start();
         if(isset($_SESSION['login'])){
            header('Location: '.base_url().'/dashboard');
        }
         parent::__construct();
     }

     public function login(){
         $data['page_frontend'] = "Login";
         $data['page_tag'] = "Login - Usqay Hoteles";
         $data['page_title'] = "Login - Usqay Hoteles";
         $data['page_functions_js'] = "functions_login.js";
         $this->views->getView($this,"login",$data);
     }


     public function loginUser()
		{
           if($_POST)
		   {
			   if(empty($_POST['email']) || empty($_POST['password']))
			   {
				   $arrResponse = array('status' => false, 'msg' => 'Todos los campos son obligatorios');
			   }else{ 
                    $User  = strtolower(strClean($_POST['email'])); 
					$Password = hash("SHA256", $_POST['password']);
					$request_user = $this->model->loginUser($User,$Password);
					if(empty($request_user)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario o contraseña es incorrecta');
					}else{
						$arrData = $request_user;
						if($arrData['estado'] == 1)
						{
							$_SESSION['idUser'] = $arrData['idusuario'];
							$_SESSION['login']  = true; 

							$arrData = $this->model->sessionLogin($_SESSION['idUser']);
							$_SESSION['userData'] = $arrData;
							
							$arrResponse = array('status' => true, 'msg' => 'Ok');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Usuario inactivo');
						}
					}
			   }
			   // sleep(2);
			   echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		   }
		   die();
		}



 }

?>