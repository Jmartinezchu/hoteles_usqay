<?php

use Spipu\Html2Pdf\Tag\Html\S;

class Almacen extends Controllers{

public function __construct(){
    session_start();
    if(empty($_SESSION['login']))

    {
        header('Location: '.base_url().'/login');
    }
    parent::__construct();

    }

    public function almacen(){
        $data['page_frontend'] = "Almacen";
        $data['page_tag'] = "Almacen - Usqay Hoteles";
        $data['page_id']  = 6;
        $data['page_title'] = "Almacen - Usqay Hoteles";
        $data['page_functions_js'] = "functions_almacen.js";
        $this->views->getView($this,"almacen",$data);
    } 
    public function getAlmacen(int $idalmacen)
     {
       $idAlmacen =  intval(strClean($idalmacen));
         $arrData = $this->model->selectAlmacen($idAlmacen);
         if(empty($arrData)){ //vacio
           $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
         }else{
           $arrResponse = array('status' => true, 'data' => $arrData);
         }
         echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
       
       die();
     }

     public function getSelectAlmacenes(){
        $htmlOptions = "";
        $arrData = $this->model->selectAlmacenes();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idalmacen'].'">'.$arrData[$i]['nombre_almacen'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getAlmacenes(){
        $arrData = $this->model->selectAlmacenes();

        for($i=0; $i < count($arrData); $i++) {
            $btnEdit  = '';
            $btnDelet= '';
            if($arrData[$i]['estado'] == 1)
            {
                $arrData[$i]['estado'] = '<span>Activo</span>';
            }else{
                $arrData[$i]['estado'] = '<span>Inactivo</span>';
            }
            $btnEdit = '<button style="border:none; background:transparent;" onclick="editarAlmacen('.$arrData[$i]['idalmacen'].')"> <i class="fa-solid fa-pencil"></i> </button>';
            $btnDelet = '<button style="border:none; background:transparent; color: red;" onclick="eliminarAlmacen('.$arrData[$i]['idalmacen'].')" title="Eliminar Almacen"><i class="fa-solid fa-trash"></i></button>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';

        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }


    public function setAlmacen(){        
        $IdAlmacen               = intval($_POST['idAlmacen']);
        $NombreAlmacen           = strClean($_POST['nombre']);
        $UbicacionAlmacen        = strClean($_POST['ubicacion']);
        $DescripcionAlmacen      = strClean($_POST['descripcion']);
        if($IdAlmacen == 0)
        {
            $request_almacen = $this->model->insertAlmacen($NombreAlmacen, $UbicacionAlmacen, $DescripcionAlmacen);
            $option = 1;
        }else{
            $request_almacen = $this->model->updateAlmacen($IdAlmacen, $NombreAlmacen, $UbicacionAlmacen, $DescripcionAlmacen);
            $option = 2;
        }

        if($request_almacen > 0)
        {
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
            }else {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            }
       
        }else if($request_almacen == 'exist'){
            $arrResponse = array('status' => false, 'msg' => '¡Atención! El Almacen ya existe');
        }else{
            $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
        }
    
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();

    }
    public function delAlmacen(){
        $idalmacen = intval($_POST['idalmacen']);
        $requestDelete = $this->model->deleteAlmacen($idalmacen);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Almacen');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Almacen');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
    
?>