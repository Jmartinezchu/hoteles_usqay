<?php 
 
 class HospedarModel extends Mysql{

    public $idpiso;
    public $nombrepiso;
    public $idHabitacion;

    public function __construct()
     {
         parent::__construct();
         
     }
    public function selectVariosPisos(){
        $sql="SELECT * FROM piso_habitacion WHERE estado != 0";
        $request = $this->listar($sql);
        return $request;
    }

    public function verReserva(int $habitacion){
 
        $this->idHabitacion = $habitacion;
        $sql = "SELECT id_reservacion FROM reservaciones where habitacion_id = $this->idHabitacion ORDER BY id_reservacion desc limit 1";
        $request_sql = $this->buscar($sql);
        // echo json_encode($request_sql['id_reservacion']);
        return $request_sql['id_reservacion'];
    }

    public function listarHabitacion(){
        $sql="SELECT * FROM habitacion";
        $request = $this->listar($sql);
        return $request;
    }
    public function buscarHabitacion(int $idhabitacion){
        $this->idHabitacion = $idhabitacion;
        $sql="SELECT * FROM habitacion WHERE idhabitacion = $this->idHabitacion";
        $request = $this->buscar($sql);
        return $request;
    }

    public function buscarHabitaciones(int $idpiso){
        $this->idpiso = $idpiso;
        $sql="SELECT h.nombre_habitacion, h.capacidad, h.estado_habitacion, h.idhabitacion, h.precio_dia, p.idpiso FROM habitacion h INNER JOIN piso_habitacion p ON h.idpiso = p.idpiso WHERE p.idpiso = '{$this->idpiso}'";
        $request = $this->listar($sql);
        return $request;
    }

    public function buscarPreciosTarifa(int $idhabitacion, int $Tarifa){
        $sql_tarifas = "SELECT p.idPrecioHabitacion, p.precio, p.dias, p.horas, p.minutos FROM preciohabitacion p INNER JOIN habitacion h ON p.idHabitacion = h.idhabitacion INNER JOIN tarifas t ON p.idTarifa = t.idTarifa WHERE h.idhabitacion = $idhabitacion AND t.idTarifa = $Tarifa AND p.estado != 0";
        $request_tarifas = $this->listar($sql_tarifas);
        return $request_tarifas;
    }

    public function buscarHabitacionDia(int $idhabitacion){
        $this->idHabitacion = $idhabitacion;
        $habitacion = "SELECT precio_dia FROM habitacion WHERE idhabitacion =  $this->idHabitacion ";
        $request_habitacion = $this->buscar($habitacion);
        return $request_habitacion;
    }
    public function buscarHabitacionExpress(int $idhabitacion){
        $this->idHabitacion = $idhabitacion;
        $habitacion = "SELECT precio_dia FROM habitacion WHERE idhabitacion =  $this->idHabitacion ";
        $request_habitacion = $this->buscar($habitacion);
        return $request_habitacion;
    }

    public function buscarHabitacionReserva(int $idhabitacion){
        $this->idHabitacion = $idhabitacion;
        $sql="SELECT h.nombre_habitacion, h.idhabitacion, e.nombre as estado_reserva, r.fecha_hora_checkIn FROM reservaciones r INNER JOIN reservaciones_estados e ON r.reservacion_estado_id = e.id_reservacionestado INNER JOIN habitacion h ON r.habitacion_id = h.idhabitacion WHERE idhabitacion =  $this->idHabitacion LIMIT 1";
        $request_habitacion = $this->buscar($sql);
        return $request_habitacion;
    }

    public function selectOriginReservation(){
        $sql = "SELECT * FROM origen_reservacion";
        $request = $this->listar($sql);
        return $request;
    }
 }

?>