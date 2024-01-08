<?php

    class CodeSunatModel extends Mysql{
        public function __construct()
        {
            parent::__construct();
        }
        public function selectCodeSunat(){
            $sql = "SELECT *  FROM sunat_codes WHERE id != 26701";
            $request = $this->listar($sql);
            return $request;
        }
        public function selectCodeSunatServicios(){
            $sql = "SELECT *  FROM sunat_codes WHERE id = 26701";
            $request = $this->listar($sql);
            return $request;
        }
    }

?>