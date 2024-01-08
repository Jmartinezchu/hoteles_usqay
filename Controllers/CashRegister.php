<?php 
 
 class CashRegister extends Controllers {
  
  
    public function __construct() {
        session_start();
        if(empty($_SESSION['login'])){
            header("Location ".base_url().'/login');
        }
        parent::__construct();
    }


    public function cashregister(){
       $data['page_tag'] = "Cajas - Usqay Hoteles";
       $data['page_title'] = "Cajas - Usqay Hoteles";
       $data['page_frontend'] = "Cajas";
       $data['page_functions_js'] = "functions_createcaja.js";
       $this->views->getView($this,"cash-registers",$data);
    }

    public function create(){
       $data['page_tag'] = "Crear Caja - Usqay Hoteles";
       $data['page_title'] = "Crear Caja  - Usqay Hoteles";
       $data['page_frontend'] = "Crear Caja ";
       $data['page_functions_js'] = "functions_createcaja.js";
       $this->views->getView($this,"create",$data);
    }


    public function getSelectCajas(){
        $htmlOptions = "";
        $arrData = $this->model->selectCajas();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_caja'].'">'.$arrData[$i]['nombre_caja'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }



    public function getCajas(){
        $arrData = $this->model->selectCajas();

        for($i=0; $i < count($arrData); $i++) {
            
            $btnDelet = '';
            if($arrData[$i]['estado'] == 1)
            {
                $arrData[$i]['estado'] = '<span>Activo</span>';
            }else{
                $arrData[$i]['estado'] = '<span>Inactivo</span>';
            }

            $btnEdit = '<a style="border:none; background:transparent;" onclick="fntUpdateCaja('.$arrData[$i]['id_caja'].')"title="Editar Caja"><i class="fa-solid fa-pencil"></i></a>';
           
            $btnDelet = '<a style="border:none; background:transparent; color:red" onclick="fntDeleteCaja('.$arrData[$i]['id_caja'].')" title="Eliminar Caja"><i class="fa-solid fa-trash"></i></a>';


            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';

        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }


    public function setCreate(){
        $idCaja = $_POST['idCaja'];
        $nombre_caja = strClean($_POST['nombre_caja']);
        $ubicacion = strClean($_POST['ubicacion']);
        $descripcion = strClean($_POST['descripcion']);

        if($idCaja == 0)
        {
            $request_caja = $this->model->insertCaja($nombre_caja, $ubicacion, $descripcion);
            $option = 1;
        }else{
            $request_caja = $this->model->updateCaja($idCaja,$nombre_caja, $ubicacion, $descripcion);
            $option = 2;
        }

        if($request_caja > 0)
        {
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
            }else {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            }
       
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
        }
    
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();

    }


    public function getSelectCash(){
        $htmlOptions = "";
        $arrData = $this->model->selectCashRegisterOpt();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_caja'].'">'.$arrData[$i]['nombre_caja'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

    public function deleteCashRegister()
    {
        $id_caja = intval($_POST['id_caja']);
        $requestDelete = $this->model->deleteCash($id_caja);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado correctamente la caja ');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar caja');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getCashRegisterId(int $idCaja){

        $idCaja = intval($idCaja);
        if($idCaja > 0){
            $arrData = $this->model->selectCashId($idCaja);

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