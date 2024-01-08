<?php 
  
  class RoomsCategory extends Controllers {

    public function __construct(){
        session_start();
        if(empty($_SESSION['login'])){
            header("Location ".base_url().'/login');
        }
        parent::__construct();
    }

    public function getSelectRoomsCategory(){
        $htmlOptions = "";
        $arrData = $this->model->selectRoomsCategory();
        if(count($arrData) > 0){
            for($i=0; $i < count($arrData); $i++){
                $htmlOptions .= '<option value="'.$arrData[$i]['id_categoria_habitacion'].'">'.$arrData[$i]['nombre_categoria_habitacion'].'</option>';
            }
        }
        echo $htmlOptions;
        die();
    }


 
  

   
  }
 
?>