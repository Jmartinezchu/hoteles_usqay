<?php

class CateProductModel extends Mysql{
    
    public $idCateProduct;
    public $nombreCP;
    public $estado;

    public function __construct(){
        parent:: __construct();
    }
    public function selectCateProduct(){
        
        $sql="SELECT * FROM  categoria_producto WHERE estado != 0";
        $request=$this->listar($sql);
        return $request;
    }

    public function selectCategoria(int $idcategoria) 
    {

        $this->idCateProduct = $idcategoria;
        $sql = "SELECT * FROM categoria_producto WHERE idcategoria = $this->idCateProduct";
        $request = $this->buscar($sql);
        return $request;
    }



    public function insertCateProduct(string $nombrecp){
        $return="";
        $this->nombreCP=$nombrecp;
        
        $sql="INSERT INTO categoria_producto(descripcion) VALUES (?)";
        $arrData=array($this->nombreCP);
        $request = $this -> insertar($sql,$arrData);
        return $request;

        
    }
    public function actualizarcategoria(int $idcategoria, string $nombrecp)
    {
        $this->idCateProduct = $idcategoria;
        $this->nombreCP = $nombrecp;
        
           
                $sql = "UPDATE categoria_producto SET descripcion = ? WHERE idcategoria = $this->idCateProduct";
                
                $arrData = array($this->nombreCP);
                $request = $this->actualizar($sql,$arrData);
          
            return $request;
    }
   

    
    public function deletCateProduc(int $idCategoria){

        $this->idCateProduct = $idCategoria;

        $sql="DELETE FROM categoria_producto WHERE idcategoria = $this->idCateProduct";
        $request = $this->eliminar($sql);
        return $request;
    }


  


}



?>