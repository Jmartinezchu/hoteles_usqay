<?php

class DashboardModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cantidadRoles()
    {
        $sql = "SELECT COUNT(*) as total from rol where estado != 0";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function roomsDisponibles()
    {
        $sql = "SELECT COUNT(*) as total FROM habitacion where estado_habitacion = 'Disponible' ";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function roomsOcupadas()
    {
        $sql = "SELECT COUNT(*) as total FROM habitacion where estado_habitacion = 'Ocupada' ";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function roomsMantenimiento()
    {
        $sql = "SELECT COUNT(*) as total FROM habitacion where estado_habitacion = 'Mantenimiento' ";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function cantidadVentas()
    {
        $sql_config = "SELECT fecha_cierre FROM configuracion where id = 1";
        $request_confg = $this->buscar($sql_config);
        $sql = "SELECT COUNT(*) as total FROM venta where venta_estado_id = 2  AND DATE_FORMAT(created_at, '%Y-%m-%d')= '" . $request_confg["fecha_cierre"] . "' ";
        $request = $this->buscar($sql);

        $total = $request['total'];
        return $total;
    }

    public function cantidadReservas()
    {
        $sql_config = "SELECT fecha_cierre FROM configuracion where id = 1";
        $request_confg = $this->buscar($sql_config);
        $sql =  "SELECT COUNT(*) as total  FROM reservaciones WHERE reservacion_estado_id != 4 and  DATE_FORMAT(created_at,'%Y-%m-%d')= '" . $request_confg["fecha_cierre"] . "' ";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }
    public function cantidadUsuarios()
    {
        $sql = "SELECT COUNT(*) as total from usuario where estado != 0";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function selectVentasMes(int $anio, int $mes)
    {
        $totalVentasMes = 0;
        $arrVentasDias = array();
        $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $n_dia = 1;
        for ($i = 0; $i < $dias; $i++) {
            $date = date_create($anio . "-" . $mes . "-" . $n_dia);
            $fechaVenta = date_format($date, "Y-m-d");
            $sql = "SELECT DAY(created_at) as dia, COUNT(*) as cantidad, SUM(total_venta) as total FROM venta WHERE venta_estado_id = 2 and DATE(created_at) = '$fechaVenta' ";
            $ventaDia = $this->buscar($sql);
            //  var_dump($ventaDia);exit;
            $ventaDia['dia'] = $n_dia;
            $ventaDia['total'] = $ventaDia['total'] == "" ? 0 : $ventaDia['total'];
            $totalVentasMes += $ventaDia['total'];
            array_push($arrVentasDias, $ventaDia);
            $n_dia++;
        }
        $meses = Meses();
        $arrData = array('anio' => $anio, 'mes' => $meses[intval($mes - 1)], 'total' => $totalVentasMes, 'ventas' => $arrVentasDias);
        return $arrData;
    }

    public function selectReservasMes(int $anio, int $mes)
    {
        $totalReservasMes = 0;
        $arrReservasDias = array();
        $dias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $n_dia = 1;
        for ($i = 0; $i < $dias; $i++) {
            $date = date_create($anio . "-" . $mes . "-" . $n_dia);
            $fechaReserva = date_format($date, "Y-m-d");
            $sql = "SELECT DAY(created_at) as dia, COUNT(*) as tiempo, SUM(total) as total FROM reservaciones WHERE reservacion_estado_id = 1 and DATE(created_at) = '$fechaReserva' ";
            $ReservaDia = $this->buscar($sql);
            $ReservaDia['dia'] = $n_dia;
            $ReservaDia['total'] = $ReservaDia['total'] == "" ? 0 : $ReservaDia['total'];
            $totalReservasMes += $ReservaDia['total'];
            array_push($arrReservasDias, $ReservaDia);
            $n_dia++;
        }
        $meses = Meses();
        $arrData = array('anio' => $anio, 'mes' => $meses[intval($mes - 1)], 'total' => $totalReservasMes, 'reservas' => $arrReservasDias);
        return $arrData;
    }

    public function ultimosUsuarios()
    {
        $sql = "SELECT * FROM usuario WHERE estado != 0 and nombres != '' order by idusuario desc limit 3 ";
        $request = $this->listar($sql);
        return $request;
    }

    public function ultimasReservas()
    {
        $sql = "SELECT r.id_reservacion, r.reservacion_estado_id, u.nombres as cliente, e.nombre, DATE_FORMAT(r.fecha_inicio, '%d %M %Y') as fechainicio, DATE_FORMAT(r.fecha_fin,'%d %M %Y') as fechafin FROM reservaciones r  INNER JOIN reservaciones_estados e ON r.reservacion_estado_id = e.id_reservacionestado INNER JOIN usuario u ON r.cliente = u.idusuario WHERE r.reservacion_estado_id != 4 ORDER BY r.id_reservacion DESC LIMIT 5";
        $request = $this->listar($sql);
        return $request;
    }


    public function mountDayCash()
    {
        $date = date("Y-m-d");
        $sql = "SELECT SUM(monto) as total FROM movimiento_caja where created_at = $date";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }
}
