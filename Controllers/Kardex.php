<?php
 
 class Kardex extends Controllers{
   
    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
    
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    
    }

    public function kardex(){
        $data['page-frontend']= "Kardex";
        $data['page_tag']="Kardex  - Usqay  Hoteles";
        $data['page_id']=3;
        $data['page_title'] = "Kardex - Usqay Hoteles";
        $data['page_functions_js'] = "functions_kardex.js";
        $this->views->getView($this,"kardex",$data);
    }

    public function movement($id){
        $data['page-frontend']= "Movimiento Kardex ".$id;
        $data['page_tag']="Movimiento Kardex - Usqay  Hoteles";
        $data['page_title'] = "Movimiento Kardex - Usqay Hoteles";
        $data['page_functions_js'] = "functions_kardex_movimiento.js";
        $this->views->getView($this,"movement",$data);
    }

    public function getKardex($idalmacen){

        $idalmacen = intval($idalmacen);
        if($idalmacen > 0){
            $arrData = $this->model->selectKardex($idalmacen);

            for($i=0; $i < count($arrData); $i++) {
                $btnView   = '';
    
                $btnView .= '<a href="'.base_url().'/kardex/movement?productoid='.$arrData[$i]['productoid'].'" title="Detalle Movimiento Almacen"><i class="fa-solid fa-chart-line"></i></a>';
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.'</div>';
            }
           
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

 

    public function getKardexSeguimiento($idproducto){
        $idProducto = intval($idproducto);
        if($idProducto > 0){
            $arrData = $this->model->selectkardexSeguimiento($idProducto);
            for($i=0; $i < count($arrData); $i++){
                
                if($arrData[$i]['tipo_movimiento'] == 1){
                    $arrData[$i]['tipo_movimiento'] = '<p>ALMACEN INGRESO</p>';
                }else if($arrData[$i]['tipo_movimiento'] == 3){
                    $arrData[$i]['tipo_movimiento'] = '<p>VENTA PRODUCTO</p>';
                }else{
                    $arrData[$i]['tipo_movimiento'] = '<p>ALMACEN SALIDA</p>';

                }

                if($arrData[$i]['cantidad'] > 0){
                    $arrData[$i]['cantidad'] = '<span style="color:white; background:#0F4B81;padding:5px; border-radius:5px;">'.$arrData[$i]['cantidad'].'</span>';
                    $arrData[$i]['total'] = formatMoney(0);
                }else if($arrData[$i]['cantidad'] < 0){
                    $arrData[$i]['cantidad'] = '<span style="color:white; background:#EF6A01;padding:5px; border-radius:5px;">'.$arrData[$i]['cantidad'].'</span>';
                    // TODO: VENTAS GENERADAS 
                    $arrData[$i]['total'] = formatMoney(abs($arrData[$i]['total']));
                    // $arrData[$i]['total'] = formatMoney(0);  
                }

            }
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
  
 }

?>