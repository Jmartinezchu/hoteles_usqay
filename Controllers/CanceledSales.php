<?php 
 
 class CanceledSales extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }


    public function getCanceledSales(){
        $arrData = $this->model->selectCanceledSales();

        for($i=0; $i < count($arrData); $i++) {

            if($arrData[$i]['medio_pago_id'] == 1){
                $arrData[$i]['medio_pago_id'] = '<span>EFECTIVO</span>';
            }else if($arrData[$i]['medio_pago_id'] == 2){
                $arrData[$i]['medio_pago_id'] = '<span>VISA</span>';
            }else if($arrData[$i]['medio_pago_id'] == 3){
                $arrData[$i]['medio_pago_id'] = '<span>MASTERCARD</span>';
            }else if($arrData[$i]['medio_pago_id'] == 4){
                $arrData[$i]['medio_pago_id'] = '<span>TRANSFERENCIA</span>';
            }else if($arrData[$i]['medio_pago_id'] == 5){
                $arrData[$i]['medio_pago_id'] = '<span>YAPE</span>';
            }else if($arrData[$i]['medio_pago_id'] == 6){
                $arrData[$i]['medio_pago_id'] = '<span>PLIN</span>';
            }


            if($arrData[$i]['tipo_comprobante'] == 1){
                $arrData[$i]['tipo_comprobante'] = '<span>FACTURA</span>';
            }else if($arrData[$i]['tipo_comprobante'] == 2){
                $arrData[$i]['tipo_comprobante'] = '<span>BOLETA</span>';
            }else if($arrData[$i]['tipo_comprobante'] == 3){
                $arrData[$i]['tipo_comprobante'] = '<span>TICKET</span>';
            }

            // if($arrData[$i]['estado'] == 3){
            //     $arrData[$i]['estado']  = '<span style="background:#EF6A01;color:white;padding:5px;border-radius:5px">Venta anulada</span>';
            // }

        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

  
  



   

 }
