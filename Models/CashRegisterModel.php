<?php
 
 class CashRegisterModel extends Mysql{

    public $idCaja;
    public $Nombre_caja;
    public $Ubicacion;
    public $Descripcion;

    public function __construct(){
        parent::__construct();
    }

    public function deleteCash(int $idCaja){

        $this->idCaja = $idCaja;
        $sql = "DELETE FROM caja WHERE id_caja = $this->idCaja";
        $request = $this->eliminar($sql);
        return $request;
    }

    public function insertCaja(string $nombre_caja, string $ubicacion, string $descripcion){
        $this->Nombre_caja = $nombre_caja;
        $this->Ubicacion = $ubicacion;
        $this->Descripcion = $descripcion;

        $insert = "INSERT INTO caja(nombre_caja,ubicacion, descripcion) VALUES(?,?,?)";
        $arrData = array($this->Nombre_caja,$this->Ubicacion, $this->Descripcion);
        $request_insert = $this->insertar($insert,$arrData);
        return $request_insert;
        
    }

    public function updateCaja(int $idCaja,string $nombre_caja, string $ubicacion, string $descripcion){
        $this->idCaja = $idCaja;
        $this->Nombre_caja = $nombre_caja;
        $this->Ubicacion = $ubicacion;
        $this->Descripcion = $descripcion;

        $sql_caja ="UPDATE caja SET nombre_caja = ?, ubicacion = ?, descripcion = ? WHERE id_caja  = $this->idCaja";
        $arrData = array($this->Nombre_caja, $this->Ubicacion, $this->Descripcion);
        $request = $this->actualizar($sql_caja,$arrData);
              
        return $request;
    }

    public function selectCajas(){
        $sql  = "SELECT * FROM caja WHERE estado != 0";
        $request_sql = $this->listar($sql);
        return $request_sql;
    }

    public function selectCashRegisterOpt(){
        $sql = "SELECT * FROM caja WHERE estado != 0";
        $request = $this->listar($sql);
        return $request;
    }
    public function selectCashId(int $idCaja){
        $this->idCaja = $idCaja;
        $sql = "SELECT * 
              FROM caja
              WHERE id_caja =  $this->idCaja";
        $request = $this->buscar($sql);
        return $request;
    }
 }


?>