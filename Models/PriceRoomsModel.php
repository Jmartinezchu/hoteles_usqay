<?php

class PriceRoomsModel extends Mysql
{
    public $idPrecioHabitacion;
    public $IdHabitacion;
    public $IdTarifa;
    public $dias;
    public $horas;
    public $minutos;
    public $precio;
    public $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function selectVariosPrecios()
    {
        $sql = "SELECT p.idPrecioHabitacion, h.nombre_habitacion, t.nombreTarifa, p.precio, p.dias, p.horas, p.minutos, p.estado FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE p.estado != 0";
        $request = $this->listar($sql);
        return $request;
    }
    public function selectVariosPreciosDayHour()
    {
        $sql = "SELECT p.idPrecioHabitacion, h.nombre_habitacion, t.nombreTarifa, p.precio, p.dias, p.horas, p.minutos, p.estado FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE  p.estado != 0";
        $request = $this->listar($sql);
        return $request;
    }

    public function selectUnPrecio(int $idPrecioHabitacion)
    {
        $this->idPrecioHabitacion = $idPrecioHabitacion;
        $sql = "SELECT * FROM preciohabitacion WHERE idPrecioHabitacion  = $this->idPrecioHabitacion";
        $request = $this->buscar($sql);
        return $request;
    }

    public function insertPrecio(int $IdHabitacion, int $IdTarifa, float $precio, int $dias, int $horas, int $minutos)
    {
        $return = "";
        $this->IdHabitacion = $IdHabitacion;
        $this->IdTarifa = $IdTarifa;
        $this->precio = $precio;
        $this->dias = $dias;
        $this->horas = $horas;
        $this->minutos = $minutos;

        $sql = "INSERT INTO preciohabitacion (idTarifa, idHabitacion, precio, dias, horas, minutos) VALUES (?,?,?,?,?,?)";
        $arrData = array($this->IdTarifa, $this->IdHabitacion, $this->precio, $this->dias, $this->horas, $this->minutos);
        $request = $this->insertar($sql, $arrData);
        return $request;
    }

    public function updatePrecio(int $idPrecioHabitacion, int $IdHabitacion, int $IdTarifa, float $precio, int $dias, int $horas, int $minutos)
    {

        $this->idPrecioHabitacion = $idPrecioHabitacion;
        $this->IdHabitacion = $IdHabitacion;
        $this->IdTarifa = $IdTarifa;
        $this->precio = $precio;
        $this->dias = $dias;
        $this->horas = $horas;
        $this->minutos = $minutos;

        $sql = "UPDATE preciohabitacion SET idTarifa = ?, idHabitacion = ?, precio = ?, dias = ?, horas = ?, minutos = ? WHERE idPrecioHabitacion = $this->idPrecioHabitacion";
        $arrData = array($this->IdHabitacion, $this->IdTarifa, $this->precio, $this->dias, $this->horas, $this->minutos);
        $request = $this->actualizar($sql, $arrData);
        var_dump($request);
        exit;
        return $request;
    }

    public function deletePrecio(int $idPrecioHabitacion)
    {

        $this->idPrecioHabitacion = $idPrecioHabitacion;

        $sql = "DELETE FROM preciohabitacion WHERE idPrecioHabitacion  = $this->idPrecioHabitacion";
        $request = $this->eliminar($sql);
        return $request;
    }
}
