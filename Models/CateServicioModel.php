<?php

class CateServicioModel extends Mysql{
    
    public $idCateServicio;
    public $nombreCS;
    public $estado;

    public function __construct(){
        parent:: __construct();
    }
    public function selectCateServicio(){
        
        $sql="SELECT * FROM  categoria_servicio WHERE estado != 0";
        $request=$this->listar($sql);
        return $request;
    }

    public function selectCategoria(int $idcategoria) 
    {

        $this->idCateServicio = $idcategoria;
        $sql = "SELECT * FROM categoria_servicio WHERE idcategoria = $this->idCateServicio";
        $request = $this->buscar($sql);
        return $request;
    }



    public function insertCateServicio(string $nombreCS){
        $return="";
        $this->nombreCS=$nombreCS;
        
        $sql="INSERT INTO categoria_servicio(descripcion) VALUES (?)";
        $arrData=array($this->nombreCS);
        $request = $this -> insertar($sql,$arrData);
        return $request;

        
    }
    public function actualizarcategoria(int $idcategoria, string $nombreCS)
    {
        $this->idCateServicio = $idcategoria;
        $this->nombreCS = $nombreCS;
        
           
                $sql = "UPDATE categoria_servicio SET descripcion = ? WHERE idcategoria = $this->idCateServicio";
                
                $arrData = array($this->nombreCS);
                $request = $this->actualizar($sql,$arrData);
          
            return $request;
    }
   

    
    public function deletCateServicio(int $idCategoria){

        $this->idCateServicio = $idCategoria;

        $sql="DELETE FROM categoria_servicio WHERE idcategoria = $this->idCateServicio";
        $request = $this->eliminar($sql);
        return $request;
    }


  


}



?>