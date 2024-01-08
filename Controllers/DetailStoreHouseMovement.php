<?php
 
 class DetailStoreHouseMovement extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login'])){
            header("Location: ".base_url().'/login');
        }
        parent::__construct();
    }

    public function detail($id){
        $data['page_frontend'] = "Detalle de Movimiento de almacen";
        $data['page_tag'] = "Detalle de Movimiento de almacen - Usqay Hotekes";
        $data['page_id'] = 4;
        $data['page_title'] = "Detalle de movimiento de almancen - Usqay Hoteles";
        $data['page_functions_js'] = "functions_detalle_almacen.js";

        $this->views->getView($this, "detail", $data);
     }

     public function setDetailStoreHouseMovement(){
        // $idDetalleMovimiento  = intval($_POST['iddetallemovimiento']);
        $movimientoid = intval($_POST['idmovimiento']);
        $almacenid = intval($_POST['almacenid']);
        $usuario = $_POST['usuario'];
        $productos     = intval($_POST['productos']);
        $cantidad   = intval($_POST['cantidad']);
        $descripcion = strClean($_POST['descripcion']);
        $option = "";

      
        $request_detalle_movimiento = $this->model->insertarDetalleMovimiento($movimientoid,$almacenid,$productos,$cantidad,$usuario, $descripcion);
        $option = 1;


        if($request_detalle_movimiento > 0){
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

     public function deletDetailStoreHouseMovement(){
        $iddetalle = intval($_POST['iddetalle_movimiento']);
        $requestDelete = $this->model->deleteDetalleMovimiento($iddetalle);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado correctamente');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
     }


     public function getDetailStoreHouseMovement($idmovimiento){

        $iddetallemovimiento = intval($idmovimiento);
        if($iddetallemovimiento > 0){
            $arrData = $this->model->selectDetailStoreHouseMovement($iddetallemovimiento);

            for($i=0; $i < count($arrData); $i++) {
                $btnDelet   = '';
    
                $btnDelet .= '<a style="border:none; background:transparent; color:red;"  onclick="deleteDetalle('.$arrData[$i]['iddetalle_movimiento'].')" title="Eliminar producto"><i class="fa-solid fa-trash"></i></a>';

                $arrData[$i]['options'] = '<div class="text-center">'.$btnDelet.'</div>';
            }
        }
       
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
     }

 }

?>