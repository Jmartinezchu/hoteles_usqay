<?php

class TarifasRoomsModel extends Mysql
{
    public $IdTarifa;
    public $nombreT;
    public $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectVariasTarifas()
    {
        $sql = "SELECT * FROM tarifas WHERE estado != 0 ";
        $request = $this->listar($sql);
        return $request;
    }
    public function selectVariasTarifasDayHour()
    {
        $sql = "SELECT * FROM tarifas WHERE estado != 0 AND idTarifa = 1 OR idTarifa = 2 ORDER BY nombreTarifa ASC";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectAllTarifas()
    {
        $sql = "SELECT * FROM tarifas WHERE estado != 0 ORDER BY nombreTarifa ASC";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectUnaTarifa(int $IdTarifa)
    {
        $this->IdTarifa = $IdTarifa;
        $sql = "SELECT * FROM tarifas WHERE idTarifa  = $this->IdTarifa";
        $request = $this->buscar($sql);
        return $request;
    }

    public function insertTarifa(string $nombreTarifa)
    {
        $return = "";
        $this->nombreT = $nombreTarifa;
        $sql = "INSERT INTO tarifas(nombreTarifa) VALUES (?)";
        $arrData = array($this->nombreT);
        $request = $this->insertar($sql, $arrData);
        return $request;
    }

    public function updateTarifa(int $IdTarifa, string $nombreT)
    {

        $this->IdTarifa = $IdTarifa;
        $this->nombreT = $nombreT;

        $sql = "UPDATE tarifas SET nombreTarifa = ? WHERE idTarifa  = $this->IdTarifa";
        $arrData = array($this->nombreT);
        $request = $this->actualizar($sql, $arrData);
        return $request;
    }

    public function deleteTarifa(int $IdTarifa)
    {

        $this->IdTarifa = $IdTarifa;

        $sql = "DELETE FROM tarifas WHERE idTarifa  = $this->IdTarifa";
        $request = $this->eliminar($sql);
        return $request;
    }
    public function TodoTarifas()
    {
        $sql = "SELECT idTarifa, nombreTarifa FROM tarifas";
        $request = $this->listar($sql);
        return $request;
    }
}
