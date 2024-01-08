<?php
 
 class CashRegisterMovements extends Controllers {
    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
    
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    
    }
    
    public function cashregistermovements(){
        $data['page_frontend'] = "Movimientos de caja";
        $data['page_tag'] = "Movimientos de caja - Usqay Hoteles";
        $data['page_title'] = "Movimientos de caja - Usqay Hoteles";
        $data['page_functions_js'] = "functions_cashregistermovements.js";
        $this->views->getView($this,"cashregistermovements",$data);
    }

    public function create(){
        $data['page_frontend'] = "Crear movimientos de caja";
        $data['page_tag'] = "Crear movimientos de caja - Usqay Hoteles";
        $data['page_title'] = "Crear movimientos de caja - Usqay Hoteles";
        $data['page_functions_js'] = "functions_create_cashregistermovements.js";
        $this->views->getView($this,"create",$data);
    }

    public function getSelectTipoMovimiento(){
        $htmlOptions = "";
        $arrData = $this->model->selectTipoMovimiento();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_tipomovimientocaja'].'">'.$arrData[$i]['nombre'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getSelectMonedas(){
        $htmlOptions = "";
        $arrData = $this->model->selectMonedas();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_moneda'].'">'.$arrData[$i]['descripcion'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getSelectMediosPago(){
        $htmlOptions = "";
        $arrData = $this->model->selectMediosPago();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idmediopago'].'">'.$arrData[$i]['nombre'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getCashRegisterMovements(){
        $arrData=$this->model->selectCashRegisterMovements();
        
        for($i=0; $i < count($arrData); $i++){
          
            if($arrData[$i]['monto'] > 0){
                $arrData[$i]['monto'] = '<span style="color:white; background:#0F4B81; padding:5px; border-radius:5px;">In</span> ' .$arrData[$i]['monto'];
            }else{
                $arrData[$i]['monto'] = '<span style="color:white; background:#EF6A01;padding:5px; border-radius:5px;">Out</span> ' .$arrData[$i]['monto'];
            }
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setCashRegisterMovement(){
        $idmovementcash = intval($_POST['idmovementcash']);
        $moneda = intval($_POST['moneda']);
        $tipo_movimiento = intval($_POST['tipo_movimiento']);
        $cajas = intval($_POST['cajas']);
        $turnoid = intval($_POST['turnoid']);
        $metodo_pago = intval($_POST['metodo_pago']);
        $usuarioid = $_POST['usuarioid'];
        $monto   = $_POST['monto'];
        $descripcion = strClean($_POST['descripcion']);

        $request_cashmovement = $this->model->insertCashMovement($moneda,$tipo_movimiento,$cajas,$turnoid,$metodo_pago,$usuarioid,$monto,$descripcion);

        if($request_cashmovement > 0){
            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
        }

        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
    }
 }

?>
