<?php
 
 class StoreHouseMovement extends Controllers{
    
    
    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }

    public function storehousemovement(){
        $data['page_frontend'] = "Movimiento de almacen";
        $data['page_tag'] = "Movimiento de almacen - Usqay Hoteles";
        $data['page_id']  = 3;
        $data['page_title'] = "Movimiento de almacen - Usqay Hoteles";
        $data['page_functions_js'] = "functions_storehousemovement.js";
        $this->views->getView($this,"storehousemovement",$data);
    }


    public function getStoreHouseMovement(){
        $arrData = $this->model->selectStoreHouseMovement();

        for($i=0; $i < count($arrData); $i++) {
            $btnView    = '';
            $btnDelet   = '';

            if($arrData[$i]['tipo_movimiento'] == 1){
                $arrData[$i]['tipo_movimiento'] = '<p>Ingreso</p>';
            }else{
                $arrData[$i]['tipo_movimiento'] = '<p>Salida</p>';
            }

           
            $btnView .= '<a href="'.base_url().'/DetailStoreHouseMovement/detail?id='.$arrData[$i]['idmovimiento_almacen'].'&almacen='.$arrData[$i]['almacenid'].'" title="Detalle Movimiento Almacen"><i class="fa-solid fa-plus"></i></a>';


            $btnDelet .= '<a style="border:none; background:transparent; color:red;"  onclick="deleteStoreHouseMovement('.$arrData[$i]['idmovimiento_almacen'].')" title="Eliminar usuario"><i class="fa-solid fa-trash"></i></a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnView.'  '.$btnDelet.'</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delStoreHouseMovement(){
        $idmovimiento_almacen = $_POST['idmovimiento_almacen'];
        $requestDelete = $this->model->deleteMovimiento($idmovimiento_almacen);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el movimiento de almacen');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el movimiento de almacen');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setStoreHouseMovement(){
        $idMovimiento  = intval($_POST['idmovimiento']);
        $tipoMovimiento = intval($_POST['tipo_movimiento']);
        $almacenes     = intval($_POST['almacenes']);
        $descripcion   = strClean($_POST['descripcion']);
        $option = "";

        if($idMovimiento == 0){
            $request_movimiento = $this->model->insertarMovimiento($tipoMovimiento,$almacenes,$descripcion);
            $option = 1;
        }else{
            $request_movimiento = $this->model->actualizarMovimiento($idMovimiento,$tipoMovimiento,$almacenes,$descripcion);
            $option = 2;
        }

        if($request_movimiento > 0){
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
 }

?>