<?php 
 
 class Tickets extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }

    public function getTicketsID(int $id_boleta){
        $idBoleta  = $id_boleta;
        $arrData = $this->model->selectIdTicket($idBoleta);

        echo $arrData;
      
        die();
    }

    function delTicket(){
        $id_boleta = intval($_POST['id_boleta']);
        
        $requestDelete = $this->model->deleteTicket($id_boleta);
       
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha anulado correctamente la boleta');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al anular la boleta, el comprobante debe ser aceptado por SUNAT para ser anulado');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
    }


    public function getTickets(){
        
        // $inicio = $_POST['fechainicio'];
        // $fin = $_POST['fechafin'];

        $arrData = $this->model->selectTickets();

        for($i=0; $i < count($arrData); $i++) {

            if($arrData[$i]['estado'] == 2){
                $arrData[$i]['estado'] = '<span style="background:#0F4B81;color:white;padding:5px;border-radius:5px">Boleta emitida</span>';
                $btnDelet = '<button style="border:none; background:transparent;" onclick="AnularBoleta('.$arrData[$i]['id_boleta'].')" title="Anular Boleta"><i style="color: #DC3545;"  class="fa-solid fa-trash fa-lg"></i></button>';
            }else if($arrData[$i]['estado'] == 3){
                $arrData[$i]['estado']  = '<span style="background:#EF6A01;color:white;padding:5px;border-radius:5px">Boleta anulada</span>';
            }

      

            $btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/prints?id='.$arrData[$i]['id_boleta'].'" target="_blank" style="color:black">
				<i class="fa-solid fa-print"></i>
				   </a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnImprimir.'   '.$btnDelet.'</div>';
          }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
  



   

 }
