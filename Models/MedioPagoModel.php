<?php
class MedioPagoModel extends Mysql{

    public $idMedioPago;
    public $Nombre;
    public $Estado;

    public function __construct(){

        parent:: __construct();
    }

    public function selectMedio(){

        $sql="SELECT * FROM medio_pago WHERE estado!=0";
        $request=$this->listar($sql);
        return $request;
    }

    public function selectMedio2(int $idmediopago){

        $this->idMedioPago = $idmediopago;
        
        $sql = "SELECT * FROM medio_pago WHERE idmediopago = $this->idMedioPago";

        $request = $this->buscar($sql);
        return $request;
    }

    public function insertarMedio(string $nombre){
        
        $return="";

        $this->Nombre = $nombre;

        $sql="INSERT INTO medio_pago(nombre) VALUES (?)";
        $arrData=array($this->Nombre);
        $request  = $this->insertar($sql,$arrData);
        return $request;
    }

    public function actualizarMedio(int $idmediopago, string $nombre){
    
    $this->idMedioPago = $idmediopago;
    $this->Nombre = $nombre;

    $sql="UPDATE medio_pago SET nombre = ? WHERE idmediopago = $this->idMedioPago";

    $arrData = array($this->Nombre);
    $request = $this->actualizar($sql,$arrData);
    return $request;

    }

    public function deletMedio(int $idmediopago){
        $this->idMedioPago = $idmediopago;

        $sql="DELETE FROM medio_pago WHERE idmediopago = $this->idMedioPago";
        $request = $this->eliminar($sql);
        return $request;
    }
}

?>