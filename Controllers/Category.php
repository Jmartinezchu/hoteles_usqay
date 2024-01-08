<?php 
    class Category extends Controllers{
        public function __construct(){
            parent::__construct();
        }
        public function getSelectCodeCategoria(){
            $htmlOptions = "";
            $arrData = $this->model->selectCodeCategoria();
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