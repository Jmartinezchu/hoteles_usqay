<?php

class Producto extends Controllers{

    public function __construct(){
    session_start();
    if(empty($_SESSION['login']))

    {
        header('Location: '.base_url().'/login');
    }
    parent::__construct();

    }
    public function producto()
    {
        $data['page-frontend']="Productos";
        $data['page_tag']="Producto - Usqay  Hoteles";
        $data['page_id']=3;
        $data['page_title'] = "Producto - Usqay Hoteles";
        $data['page_functions_js'] = "functions_producto.js";
        $this->views->getView($this,"producto",$data);
    }
    public function servicio()
    {
        $data['page-frontend']="Servicios";
        $data['page_tag']="Servicios - Usqay  Hoteles";
        $data['page_id']=3;
        $data['page_title'] = "Servicio - Usqay Hoteles";
        $data['page_functions_js'] = "functions_servicio.js";
        $this->views->getView($this,"servicio",$data);
    }


    public function getSelectProductos(){
        $htmlOptions="";
        $arrData=$this->model->selectProductos();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['idProducto'].'">'.$arrData[$i]['nombre'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }

            // EXTRAER UNA PRODUCTO
       
     public function getProducto(int $idproducto)
     {

        $IdProducto =  intval(strClean($idproducto));
 

         $arrData = $this->model->selectProducto($IdProducto);

        
         if(empty($arrData)){ //vacio
           $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
         }else{
           $arrResponse = array('status' => true, 'data' => $arrData);
         }
         echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
       
       die();
     }    

    public function getProductos(){
        $arrData=$this->model->selectProductos();
        
        for($i=0; $i < count($arrData); $i++){
            $btnPermisos='';
            $btnEdit='';
            $btnDelet='';
            if($arrData[$i]['estado']==1)
            {
                $arrData[$i]['estado']='<spand>Activo</spand>';
            }
            else
            {
                $arrData[$i]['estado']='<spand>Inactivo</spand>';
            }


            $btnEdit = '<a onclick="editarProducto('.$arrData[$i]['idProducto'].')" title="Eliminar Producto"><i  class="dripicons-pencil"></i> </a>';
            $btnDelet = '<a onclick="eliminarProducto('.$arrData[$i]['idProducto'].')" title="Eliminar Producto"><i style="color:red" class="fa-solid fa-trash"></i></a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnPermisos.' '.$btnEdit.' '.$btnDelet.'</div>';
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getServicios(){
        $arrData=$this->model->selectServicios();
        
        for($i=0; $i < count($arrData); $i++){
            $btnPermisos='';
            $btnEdit='';
            $btnDelet='';
            if($arrData[$i]['estado']==1)
            {
                $arrData[$i]['estado']='<spand>Activo</spand>';
            }
            else
            {
                $arrData[$i]['estado']='<spand>Inactivo</spand>';
            }


            $btnEdit = '<a onclick="editarProducto('.$arrData[$i]['idProducto'].')" title="Eliminar Producto"><i  class="dripicons-pencil"></i> </a>';
            $btnDelet = '<a onclick="eliminarProducto('.$arrData[$i]['idProducto'].')" title="Eliminar Producto"><i style="color:red" class="fa-solid fa-trash"></i></a>';

            $arrData[$i]['options'] = '<div class="text-center">'.$btnPermisos.' '.$btnEdit.' '.$btnDelet.'</div>';
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }

    



    public function setProducto(){

        // var_dump($_POST);
        $IdProducto          = intval($_POST['idProducto']);
        $unidadMedida = strClean($_POST['uni_de_medida']);
        $CategoriaId          = intval($_POST['codecategoria']);
        $SunatId = intval($_POST['codesunat']);
        $Nombre = strClean($_POST['nombre']);
        $PrecioVenta = floatval($_POST['precio_venta']);
        if($IdProducto == 0)
        {
            $request_prod = $this->model->insertProducto($CategoriaId,$SunatId,$Nombre,$PrecioVenta,$unidadMedida);
            $option = 1;
        }else{
            $request_prod = $this->model->actualizarproducto($IdProducto,$CategoriaId,$SunatId,$Nombre,$PrecioVenta);
            $option = 2;
        }

        if($request_prod > 0)
        {
            if($option == 1)
            {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
               
            }else {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            } 
            
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
        
    
    }
    public function deletProducto()
    {
        $idProducto = intval($_POST['idProducto']);
        $requestDelete = $this->model->deleteProducto($idProducto);
        if($requestDelete == 'ok')
        {
            $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Producto');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Producto');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    
}
?>
