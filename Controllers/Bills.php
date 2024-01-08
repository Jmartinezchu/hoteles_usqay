<?php 
 
 class Bills extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }

    public function getBillsID(int $id_factura){
        $idFactura  = $id_factura;
        $arrData = $this->model->selectIDFACTURA($idFactura);

        echo $arrData;
      
        die();
    }

    public function getBills(){
        $arrData = $this->model->selectBills();

        for($i=0; $i < count($arrData); $i++) {

            if($arrData[$i]['estado'] == 2){
                $arrData[$i]['estado']  = '<span style="background:#0F4B81;color:white;padding:5px;border-radius:5px">Factura emitida</span>';
            }else if($arrData[$i]['estado'] == 4){
                $arrData[$i]['estado']  = '<span style="background:#EF6A01;color:white;padding:5px;border-radius:5px">Factura anulada</span>';
            }

            $btnDelet = '<a style="border:none; background:transparent;" onclick="AnularFactura('.$arrData[$i]['id_factura'].')" title="Anular Factura"><i class="fa-solid fa-trash fa-lg"></i></a>';

            $btnImprimir = ' <a title="Imprimir" href="'.base_url().'/prints/prints?id='.$arrData[$i]['id_factura'].'" target="_blank">
				<i class="fa-solid fa-print"></i>
				   </a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnImprimir.'   '.$btnDelet.'</div>';
          }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    function delBills(){
        $id_factura = intval($_POST['id_factura']);
        $requestDelete = $this->model->deleteBill($id_factura);
       
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha anulado correctamente la factura');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al anular la factura');
        }
        // exit;
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
    }
  



   

 }
