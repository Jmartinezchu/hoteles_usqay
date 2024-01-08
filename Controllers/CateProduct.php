<?php

class CateProduct extends Controllers{

    public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
    }
    
    public function cateproduct()
    {
        
        $data['page-frontend']="CateProducts";
        $data['page_tag']="Categoria de Productos - Usqay  Hoteles";
        $data['page_id']=3;
        $data['page_title'] = "CateProducto - Usqay Hoteles";
        $data['page_functions_js'] = "functions_cateproduct.js";
        $this->views->getView($this,"cateproduct",$data);
    }
    public function getCateProduct(){

        $arrData=$this->model->selectCateProduct();
        for($i=0; $i<count($arrData); $i++){
            $btnEdit='';
            $btnDelet='';
            if($arrData[$i]['estado']==1)
            {
                $arrData[$i]['estado']='<span>Activo</span>';
            }
            else
            {
                $arrData[$i]['estado']='<span>Inactivo</spand>';
            }
            
            $btnEdit = '<a onclick="EditCategoria('.$arrData[$i]['idcategoria'].')"><i class="fa-solid fa-pencil"></i> </a>';

            $btnDelet = '<a color="red" onclick="eliminarCateProduct('.$arrData[$i]['idcategoria'].')"><i class="fa-solid fa-trash"></i> </a>';  

            $arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelet.'</div>';
        
        
        }

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

        }

       

        // EXTRAER UNA CATEGORIA
       
     public function getCategoria(int $idcategoria)
     {
       $idCateProduct =  intval(strClean($idcategoria));

       
         $arrData = $this->model->selectCategoria($idCateProduct);

        
         if(empty($arrData)){ //vacio
           $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
         }else{
           $arrResponse = array('status' => true, 'data' => $arrData);
         }
         echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
       
       die();
     }    

        public function setCateProduct(){
       
        
            $IdCateProduct    = intval($_POST['idcategoria']);
            $Descripcion      = strClean($_POST['nombre']);
           
            if($IdCateProduct == 0)
            {
                $request = $this->model->insertCateProduct($Descripcion);
                $option = 1;
            }else{
                $request = $this->model->actualizarcategoria($IdCateProduct,$Descripcion);
                $option = 2;
            }
    
            if($request > 0)
            {
                if($option == 1)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                }else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                }
           
            }else if($request == 'exist'){
                $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe');
            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible guardar datos.'); 
            }
        
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
    
        }
        
        public function deleteCateProduct()
        {
            $idcategoria = intval($_POST['idcategoria']);
            $requestDelete = $this->model->deletCateProduc($idcategoria);
            if($requestDelete == 'ok')
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Categoria');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Producto');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

 //EXTRAER CATEGORIA

 public function getSelectCateProduct(){
    $htmlOptions="";
    $arrData=$this->model->selectCateProduct();
    if(count($arrData) > 0){
        for($i=0; $i < count($arrData); $i++){
            $htmlOptions .= '<option value="'.$arrData[$i]['idcategoria'].'">'.$arrData[$i]['descripcion'].'</option>';
        }
    }

    echo $htmlOptions;
    die();
}


    }

?>