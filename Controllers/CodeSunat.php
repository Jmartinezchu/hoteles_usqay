<?php 
    class CodeSunat extends Controllers{
        public function __construct(){
            parent::__construct();
            }
            public function getSelectCodeSunat(){
                $htmlOptions = "";
                $arrData = $this->model->selectCodeSunat();
                if(count($arrData) > 0){
                    for($i=0; $i < count($arrData); $i++){
                        $htmlOptions .= '<option value="'.$arrData[$i]['id'].'">'.$arrData[$i]['code'].' - '.$arrData[$i]['description'].'</option>';
                    }
                }
                echo $htmlOptions;
                die();
            }
            public function getSelectCodeSunatServicios(){
                $htmlOptions = "";
                $arrData = $this->model->selectCodeSunatServicios();
                if(count($arrData) > 0){
                    for($i=0; $i < count($arrData); $i++){
                        $htmlOptions .= '<option value="'.$arrData[$i]['id'].'">'.$arrData[$i]['code'].' - '.$arrData[$i]['description'].'</option>';
                    }
                }
                echo $htmlOptions;
                die();
            }
    }

?>