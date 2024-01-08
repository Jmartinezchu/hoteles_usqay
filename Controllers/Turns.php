<?php 
 
 class Turns extends Controllers {

    public function __construct() {
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }

    public function turns(){
        $data['page_tag'] = "Turnos - Usqay Hoteles";
        $data['page_title'] = "Turnos - Usqay Hoteles";
        $data['page_frontend'] = "Turnos";
        $data['page_functions_js'] = "functions_turns.js";
        $this->views->getView($this,"turns",$data);
    }

    public function create(){
        $data['page_tag'] = "Turnos - Usqay Hoteles";
        $data['page_title'] = "Turnos - Usqay Hoteles";
        $data['page_frontend'] = "Turnos";
        $data['page_functions_js'] = "functions_turns.js";
        $this->views->getView($this,"create",$data);
    }

    
    public function getSelectTurns(){
        $htmlOptions = "";
        $arrData = $this->model->selectTurns();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idturno'].'">'.$arrData[$i]['nombre_turno'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }



    public function getTurns(){
        $arrData = $this->model->selectTurns();

        for($i=0; $i < count($arrData); $i++) {
            $btnDelet   = '';
            $btnEdit    = '';

            $btnEdit .= '<a style="border:none; background:transparent;" onclick="editTurns('.$arrData[$i]['idturno'].')" title="Editar Turno"><i class="fa-solid fa-pencil"></i></a>';


            $btnDelet = '<a style="border:none; background:transparent; color:red" onclick="deleteTurns('.$arrData[$i]['idturno'].')" title="Eliminar Turno"><i class="fa-solid fa-trash"></i></a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setTurn(){
        $idTurno = intval($_POST['idturno']);
        $nombre_turno = strClean($_POST['nombre_turno']);
        $hora_inicio = $_POST['hora_inicio'];
        $hora_fin = $_POST['hora_fin'];

        if($idTurno == 0) {
            $request_turn = $this->model->insertTurn($nombre_turno,$hora_inicio,$hora_fin);
            $option = 1;
        }else{
            $request_turn = $this->model->updateTurn($idTurno, $nombre_turno, $hora_inicio, $hora_fin);
            $option = 2;
        }

        if($request_turn > 0){
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
            }else {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            }
        }else if($request_turn == 'exist'){
            $arrResponse = array('status' => false, 'msg' => '¡Atención! El turno ya existe');
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
        }
    
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();

    }

    public function deletTurns()
    {
        $idTurno = intval($_POST['idturno']);
        $requestDelete = $this->model->deleteTurns($idTurno);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Turno');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Turno');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getTurnsId(int $idTurns){

        $idTurns = intval($idTurns);
        if($idTurns > 0){
            $arrData = $this->model->selectTurnsId($idTurns);

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