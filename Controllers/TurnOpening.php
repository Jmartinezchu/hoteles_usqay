<?php 
 
 class TurnOpening extends Controllers {
     public function __construct() {
         session_start();
         if(empty($_SESSION['login'])){
             header("Location ".base_url().'/login');
         }
         parent::__construct();
     }

     public function turnopening(){
        $data['page_tag'] = "Aperturar Turno - Usqay Hoteles";
        $data['page_title'] = "Aperturar Turno  - Usqay Hoteles";
        $data['page_frontend'] = "Aperturar Turno ";
        $data['page_functions_js'] = "functions_openingturno.js";
        $this->views->getView($this,"opening",$data);
     }


     public function setTurnOpening(){
         $idTurnOpening = intval($_POST['idTurnOpening']);
         $cajas = $_POST['cajas'];
         $turnos = $_POST['turnos'];
         $monto_inicial = $_POST['monto_inicial'];

        if($idTurnOpening == 0)
        {
            $request_turn_opening = $this->model->insertTurnOpening($cajas, $turnos, $monto_inicial);
            $option = 1;
        }

        if($request_turn_opening > 0){
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg' => 'Se aperturo caja correctamente');
            }
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
        }
    
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
     }


     
 }


?>