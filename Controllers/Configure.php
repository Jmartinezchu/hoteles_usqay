<?php 
 
 class Configure extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }

    public function configure(){
        $data['page_frontend'] = "Configuracion";
        $data['page_tag'] = "Configuracion - Usqay Hoteles";
        $data['page_title'] = "Configuracion - Usqay Hoteles";
        $data['page_id'] = 6;
        $data['page_functions_js'] = "functions_configure.js";
        $this->views->getView($this,"configure",$data);
    }

    public function getConfigure(int $idconfig)
    {
       
        $idconfig = intval($idconfig);

        if($idconfig > 0) 
        {
            $arrData = $this->model->selectConfigShow($idconfig);

            if(empty($arrData)){
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            }else{
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }

        die();
    }


    public function setConfigure(){
        // var_dump($_POST);
        
        $idConfig      = $_POST['idConfig'];
        $nombreEmpresa = $_POST['nombre_empresa'];
        $ruc           = $_POST['ruc'];
        $razon_social  = $_POST['razon_social'];
        $direccion     = $_POST['direccion'];
        $telefono      = $_POST['telefono'];
        $correo        = $_POST['correo_electronico'];
        $serie_boleta  = $_POST['serie_boleta'];
        $serie_factura = $_POST['serie_factura'];
        $token         = $_POST['token'];
        $ruta          = $_POST['ruta'];
        $detraccion = 0;
        $tipoEstadia   = $_POST['tarifa'];

        if(isset($POST['id_detraccion'])){
            $request_configure = $this->model->insertConfigure($idConfig,$nombreEmpresa, $ruc, $direccion, $telefono, $razon_social, $serie_boleta, $serie_factura, $correo, $ruta, $token, $POST['id_detraccion'], $tipoEstadia);
            $option = 1;
        }else{
            $request_configure = $this->model->insertConfigure($idConfig,$nombreEmpresa, $ruc, $direccion, $telefono, $razon_social, $serie_boleta, $serie_factura, $correo, $ruta, $token, $detraccion, $tipoEstadia);
            $option = 1;
        }
        // var_dump($request_configure);exit;
    
        if($request_configure ==  true) {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
        }else{
            $arrResponse = array("status" => false, "msg" => 'Ocurrio un error');
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }


 }

?>