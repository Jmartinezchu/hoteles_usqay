<?php 

 class Rol extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }

    public function rol(){
        $data['page_frontend'] = "Roles";
        $data['page_tag'] = "Rol - Usqay Hoteles";
        $data['page_id']  = 3;
        $data['page_title'] = "Rol - Usqay Hoteles";
        $data['page_functions_js'] = "functions_rol.js";
        $this->views->getView($this,"rol",$data);
    }

    public function getRoles(){
        $arrData = $this->model->selectRoles();

        for($i=0; $i < count($arrData); $i++) {
            $btnPermisos = '';
            $btnEdit  = '';
            $btnDelet = '';
            if($arrData[$i]['estado'] == 1)
            {
                $arrData[$i]['estado'] = '<span>Activo</span>';
            }else{
                $arrData[$i]['estado'] = '<span>Inactivo</span>';
            }
          
            $btnPermisos = '<a style="border:none; background:transparent;"  onclick="fntPermisos('.$arrData[$i]['idrol'].')"><i class="fa-solid fa-lock"></i></a>';

            $btnEdit = '<a style="border:none; background:transparent;" class="btnEditRol" onclick="fntEditRol('.$arrData[$i]['idrol'].')" title="Editar Rol"> <i class="fa-solid fa-pencil"></i> </a>';
           
            $btnDelet = '<a style="border:none; background:transparent; color:red" class="btnEliminarRol" onclick="fntEliminarRol('.$arrData[$i]['idrol'].')" title="Eliminar Rol"><i class="fa-solid fa-trash"></i></a>';


            $arrData[$i]['options'] = '<div class="text-center">'.$btnPermisos.' '.$btnEdit.' '.$btnDelet.'</div>';

        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }


    public function show(){
        $data['page-frontend']="Roles";
        $data['page_tag']="Roles - Usqay  Hoteles";
        $data['page_title'] = "Roles - Usqay Hoteles";
        $data['page_functions_js'] = "functions_rol.js";
        $this->views->getView($this,"show",$data);
     }

    public function getSelectRoles(){
        $htmlOptions = "";
        $arrData = $this->model->selectRoles();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombre_rol'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

    
    public function delRol()
    {
        if($_POST)
        {
            $IdRol = intval($_POST['idrol']);
            $requestDelete = $this->model->deleteRol($IdRol);
            if($requestDelete == 'ok')
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
            }else if($requestDelete == 'exist'){
                $arrResponse = array('status' => false, 'msg'=> 'No es posible eliminar un Rol asociado a usuarios');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function setRol(){
       
        
        $IdRol          = intval($_POST['idrol']);
        $NombreRol      = strClean($_POST['nombrerol']);
       
        if($IdRol == 0){
            $request_rol = $this->model->insertRol($NombreRol);
            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
            $option = 1;
        }else{
            $request_rol = $this->model->updateRol($IdRol,$NombreRol);
            $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            $option = 1;
        }

        if($option == 1){
            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();

    }

    public function getRol(int $idrol)
    {
        $idRol = intval($idrol);
        if($idRol > 0)
        {
            $arrData = $this->model->selectRolShow($idRol);
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