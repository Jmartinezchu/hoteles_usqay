<?php
 
 class OpenBox extends Controllers{
    public function __construct(){
    session_start();
    if(empty($_SESSION['login']))

    {
        header('Location: '.base_url().'/login');
    }
    parent::__construct();

    }

    public function OpenBox()
    {
        $data['page-frontend']= "Aperturar Caja";
        $data['page_tag']="Aperturar Caja - Usqay  Hoteles";
        $data['page_title'] = "Aperturar Caja - Usqay Hoteles";
        $data['page_functions_js'] = "functions_openbox.js";
        $this->views->getView($this,"OpenBox",$data);
    }

    public function getCortes(){
        $htmlOptions = "";
       
        // $caja = $_REQUEST['caja'];
        $arrData = $this->model->selectCortesDay();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id'].'">'.$arrData[$i]['inicio'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
      
    }


    public function HacerCorte(){
        $caja = $_REQUEST['caja'];
        $arrResponse = $this->model->cortePutito($caja);
        // $this->enviarCorteCorreo();
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
        // var_dump($caja);
    }

    public function enviarCorteCorreo(){
        $fecha = date('Y-m-d');
        if (isset($_REQUEST['fecha'])) {
            $fecha = $_REQUEST['fecha'];
        }
        $corte = "";
        if (isset($_REQUEST['corte'])) {
            $corte = $_REQUEST['corte'];
        }
        $caja = "";
        if (isset($_REQUEST['caja'])) {
            $caja = $_REQUEST["caja"];
        }
        // var_dump($corte);exit;
        $arrResponse = $this->model->enviarCorteCorreoCierre($fecha,$corte,$caja);
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
        // var_dump($caja);
    }

    public function totalVendidoCorte(){
        $fecha = date('Y-m-d');
        if (isset($_REQUEST['fecha'])) {
            $fecha = $_REQUEST['fecha'];
        }
        $corte = "";
        if (isset($_REQUEST['corte'])) {
            $corte = $_REQUEST['corte'];
        }
        $caja = "";
        if (isset($_REQUEST['caja'])) {
            $caja = $_REQUEST["caja"];
        }
        $corte = $this->model->totalDiaCorte($fecha,$corte,$caja);
        echo json_encode($corte);
    }


    public function getCortesDay(){
        $db = new Mysql();
        $array = array();
        $fecha = $_REQUEST['fecha'];
        // var_dump($fecha);exit;
        $caja = $_REQUEST['caja'];
        $query = "Select * from corte c INNER JOIN accion_caja ac ON c.id=ac.pk_accion where c.fecha_cierre = '".$fecha."' AND ac.caja = $caja order by c.id DESC";
        $res = $db->listar($query);
        // while ($row0 = $res) {
        //     $array[] = $row0["inicio"];
        // }
        foreach($res as $r){
            $array[] = $r['inicio'];
            // var_dump($array);
        }
      
        // var_dump($res);exit;
        echo json_encode($array);
    }


    public function setOpenBox(){
        $idOpenBox = intval($_POST['idOpenBox']);
        $cajas = setcookie("id_caja", $_REQUEST['cajas']);
        $monto_inicial = $_POST['monto_inicial'];

       if($idOpenBox == 0)
       {
           $request_open_box = $this->model->insertTurnOpening($cajas, $monto_inicial);
           $option = 1;
       }

       if($request_open_box > 0){
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