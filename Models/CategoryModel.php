<?php

    class CategoryModel extends Mysql{
        
        public function __construct()
        {
            parent::__construct();
        }
        public function selectCodeCategoria(){
            $sql = "SELECT *  FROM categoria_producto";
            $request = $this->listar($sql);
            return $request;
        }
    }

?>