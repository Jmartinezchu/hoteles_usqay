<?php 
 
 class Users extends Controllers{
     public function __construct()
     {
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
         }
         parent::__construct();
     }

     public function users(){
         $data['page_frontend'] = "Usuarios";
         $data['page_tag'] = "Usuarios - Usqay Hoteles";
         $data['page_id'] = 4;
         $data['page_title'] = "Usuarios - Usqay Hoteles";
         $data['page_functions_js'] = "functions_usuarios.js";

         $this->views->getView($this, "users", $data);
     }


     public function create(){
        $data['page_frontend'] = "Usuarios";
        $data['page_tag'] = "Usuarios - Usqay Hotekes";
        $data['page_id'] = 4;
        $data['page_title'] = "Usuarios - Usqay Hoteles";
        $data['page_functions_js'] = "functions_usuarios.js";

        $this->views->getView($this, "create", $data);
     }


     public function show($id){
        $data['page_frontend'] = "Usuarios";
        $data['page_tag'] = "Usuarios - Usqay Hotekes";
        $data['page_id'] = 4;
        $data['page_title'] = "Usuarios - Usqay Hoteles";
        $data['page_functions_js'] = "functions_show_users.js";

        $this->views->getView($this, "show", $data);
     }


     public function deleteUser(){
        $idUser = intval($_POST['idusuario']);
        $requestDelete = $this->model->deleteUser($idUser);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
     }


     public function setUser(){
         if($_POST){
             $idUser = intval($_POST['idusuario']);
             $identificacion = $_POST['identificacion'];
             $nombre = strClean($_POST['nombres']);
             $apellidos = strClean($_POST['apellidos']);
             $telefono = intval($_POST['telefono']);
             $email  = strClean($_POST['email_user']);
             $roles  = intval($_POST['roles']);
             $option = "";

             if($idUser == 0){
                 $option = 1;
                 $password = empty($_POST['password']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['password']);
                 
                 $request_user = $this->model->insertUser($identificacion, $nombre, $apellidos, $telefono, $email, $password, $roles);
             }else{
                 $option = 2;
                 $password =  empty($_POST['password']) ? "" : hash("SHA256",$_POST['password']);
                 $request_user = $this->model->updateUser($idUser,$identificacion, $nombre, $apellidos, $telefono, $email, $password, $roles );
             }

             
             if($request_user > 0)
             {
                 if($option == 1){
                     $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                 }else{
                     $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                 }
             }else if($request_user == 'exist'){
                 $arrResponse = array('status' => false, 'msg' => '¡Atención! el email o la identificación ya existe, ingresa otro');
             }else{
                 $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos');
             }
             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
         }
         die();
     }


     public function getUsers(){
         $arrData = $this->model->selectUsers();

         for($i=0; $i < count($arrData); $i++) {
             $btnView    = '';
             $btnEdit    = '';
             $btnDelet   = '';

            
             $btnView .= '<a style="color:black;"href="'.base_url().'/users/show?id='.$arrData[$i]['idusuario'].'" title="Detalle usuario"><i class="fa-solid fa-plus"></i></a>';

             $btnEdit .= '<a style="border:none; background:transparent;" onclick="fntEditUsuario('.$arrData[$i]['idusuario'].')" title="Editar usuario"><i class="fa-solid fa-pencil"></i></a>';

             $btnDelet .= '<a style="border:none; background:transparent; color:red"  onclick="deleteUser('.$arrData[$i]['idusuario'].')" title="Eliminar usuario"><i class="fa-solid fa-trash"></i></a>';

             $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.'  '.$btnDelet.'</div>';
         }
         echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
         die();
     }

     public function getUser(int $idusuario)
     {
        
         $idUser = intval($idusuario);

         if($idUser > 0) 
         {
             $arrData = $this->model->selectUserShow($idUser);

             if(empty($arrData)){
                 $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
             }else{
                 $arrResponse = array('status' => true, 'data' => $arrData);
             }
             echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
         }

         die();
     }

 }


?>