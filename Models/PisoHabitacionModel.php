<?php

class PisoHabitacionModel extends Mysql{
    public $IdPiso;
    public $nombreP;
    public $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectVariosPisos(){
        $sql="SELECT * FROM piso_habitacion WHERE estado != 0";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectUnPiso(int $idpiso){
        $this->IdPiso = $idpiso;
        $sql="SELECT * FROM piso_habitacion WHERE idpiso  = $this->IdPiso";
        $request = $this->buscar($sql);
        return $request;
    }

    public function insertPiso(string $nombrePiso){
        $return="";
        $this->nombreP = $nombrePiso;
    
        $sql = "INSERT INTO piso_habitacion(nombrepiso) VALUES (?)";
        $arrData = array($this->nombreP);
        $request = $this->insertar($sql,$arrData);
        return $request;
    }

    public function updatePiso(int $idpiso, string $nombrePiso){

        $this->IdPiso = $idpiso;
        $this->nombreP = $nombrePiso;

        $sql = "UPDATE piso_habitacion SET nombrepiso = ? WHERE idpiso  = $this->IdPiso";
        $arrData = array($this->nombreP);
        $request = $this->actualizar($sql,$arrData);
        return $request;
    }

    public function deletePiso(int $idpiso){

        $this->IdPiso = $idpiso;

        $sql = "DELETE FROM piso_habitacion WHERE idpiso  = $this->IdPiso";
        $request = $this->eliminar($sql);
        return $request;
    }

}
?>