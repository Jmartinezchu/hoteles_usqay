<?php

class CategoryRoomModel extends Mysql{
    public $IdCH;
    public $nombreCH;
    public $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectCategoryRooms(){
        $sql="SELECT * FROM categoria_habitacion WHERE estado != 0";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectCategoryRoom(int $idcategoria){
        $this->IdCH = $idcategoria;
        $sql="SELECT * FROM categoria_habitacion WHERE id_categoria_habitacion = $this->IdCH";
        $request = $this->buscar($sql);
        return $request;
    }

    public function insertCategoryRoom(string $nombreCategory){
        $return="";
        $this->nombreCH = $nombreCategory;
    
        $sql = "INSERT INTO categoria_habitacion(nombre_categoria_habitacion) VALUES (?)";
        $arrData = array($this->nombreCH);
        $request = $this->insertar($sql,$arrData);
        return $request;
    }

    public function updateCategoryRoom(int $idcategoria, string $nombreCategory){

        $this->IdCH = $idcategoria;
        $this->nombreCH = $nombreCategory;

        //$sql_

        $sql = "UPDATE categoria_habitacion SET nombre_categoria_habitacion = ? WHERE id_categoria_habitacion = $this->IdCH";
        $arrData = array($this->nombreCH);
        $request = $this->actualizar($sql,$arrData);
        return $request;
    }

    public function deleteCategoryRoom(int $idcategoria){

        $this->IdCH = $idcategoria;

        $sql = "DELETE FROM categoria_habitacion WHERE id_categoria_habitacion = $this->IdCH";
        $request = $this->eliminar($sql);
        return $request;
    }

}
?>