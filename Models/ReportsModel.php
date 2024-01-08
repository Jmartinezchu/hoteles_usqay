<?php
 
 class ReportsModel extends Mysql {
     public function __construct(){
         parent::__construct();
     }

     public function selectReservasMes(int $anio, int $mes)
     {
         $totalReservasMes = 0;
         $arrReservasDias = array();
         $dias = cal_days_in_month(CAL_GREGORIAN,$mes,$anio);
         $n_dia = 1;
         for($i=0; $i < $dias; $i++){
             $date = date_create($anio."-".$mes."-".$n_dia);
              $fechaReserva = date_format($date,"Y-m-d");
              $sql = "SELECT DAY(created_at) as dia, COUNT(*) as tiempo, SUM(total) as total FROM reservaciones WHERE reservacion_estado_id = 1 and DATE(created_at) = '$fechaReserva' ";
              $ReservaDia = $this->buscar($sql);
              $ReservaDia['dia'] = $n_dia;
              $ReservaDia['total'] = $ReservaDia['total'] == "" ? 0 : $ReservaDia['total'];
              $totalReservasMes += $ReservaDia['total'];
              array_push($arrReservasDias, $ReservaDia);
              $n_dia++;
         }
         $meses = Meses();
         $arrData = array('anio' => $anio, 'mes' => $meses[intval($mes-1)],'total' => $totalReservasMes, 'reservas' => $arrReservasDias);
         return $arrData;
 
     }

 public function selectReservaciones(){
        $sql = "SELECT r.id_reservacion as id, r.habitacion_id as resourceId, r.fecha_inicio as start, r.fecha_fin as end, u.nombres as title, u.identificacion as documento, u.email_user as direccion, r.reservacion_estado_id as estado, p.descripcion as observacion from reservaciones r LEFT JOIN usuario u ON r.cliente = u.idusuario LEFT JOIN reservaciones_payments p ON r.id_reservacion=p.reservacionid";
        $request = $this->listar($sql);
        return $request;
    }
     public function montoInicialDay(){
         $date= date("Y-m-d");
         $sql = "SELECT SUM(monto) as total FROM movimiento_caja WHERE tipomovimientocaja_id = 1 AND created_at = $date;
         ";
         $request = $this->buscar($sql);
         $total = $request['total'];
         return $total;
     }

     public function medioPagoEfectivo(){
        $date= date("Y-m-d");
        $sql = "SELECT SUM(monto) as total FROM movimiento_caja WHERE mediopagoid = 1 AND created_at = $date";
         $request = $this->buscar($sql);
         $total = $request['total'];
         return $total;
     }


     public function medioPagoYape(){
        $date= date("Y-m-d");
        $sql = "SELECT SUM(monto) as total FROM movimiento_caja WHERE mediopagoid = 5 AND created_at = $date";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
     }

     public function medioPagoVisa(){
        $date= date("Y-m-d");
        $sql = "SELECT SUM(monto) as total FROM movimiento_caja WHERE mediopagoid = 2  AND created_at = $date";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
     }
     
        public function selecthabitacion()
    {  
        $sql = "SELECT h.idhabitacion as id, h.nombre_habitacion as title FROM habitacion h";
        $request = $this->listar($sql);
        return $request;
    }

     public function tipoIngreso(){
        $date= date("Y-m-d");
        $sql = "SELECT SUM(monto) as total FROM `movimiento_caja` WHERE tipomovimientocaja_id = 11 AND created_at = $date";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

     public function totalEgresos(){
         $date= date("Y-m-d");
         $sql = "SELECT SUM(monto) as total FROM `movimiento_caja` WHERE tipomovimientocaja_id = 12 AND created_at = $date";
         $request = $this->buscar($sql);
         $total = $request['total'];
         return $total;
     }

     public function medioPagoPlin(){
        $date= date("Y-m-d");
        $sql = "SELECT SUM(monto) as total FROM movimiento_caja WHERE mediopagoid = 6 AND created_at = $date";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
     }
     
    public function mountDayCash(){
        $date= date("Y-m-d");
        $sql = "SELECT SUM(monto) as total FROM movimiento_caja WHERE created_at = $date";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }


    public function roomsDisponibles(){
        $sql = "SELECT COUNT(*) as total FROM habitacion where estado_habitacion = 'Disponible' ";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function roomsOcupadas(){
        $sql = "SELECT COUNT(*) as total FROM habitacion where estado_habitacion = 'Ocupada' ";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function roomsMantenimiento(){
        $sql = "SELECT COUNT(*) as total FROM habitacion where estado_habitacion = 'Mantenimiento' ";
        $request = $this->buscar($sql);
        $total = $request['total'];
        return $total;
    }

    public function selectVentasMes(int $anio, int $mes)
    {
        $totalVentasMes = 0;
        $arrVentasDias = array();
        $dias = cal_days_in_month(CAL_GREGORIAN,$mes,$anio);
        $n_dia = 1;
        for($i=0; $i < $dias; $i++){
            $date = date_create($anio."-".$mes."-".$n_dia);
             $fechaVenta = date_format($date,"Y-m-d");
             $sql = "SELECT DAY(created_at) as dia, COUNT(*) as cantidad, SUM(monto) as total FROM movimiento_caja WHERE DATE(created_at) = '$fechaVenta' and tipomovimientocaja_id = 3 and estado = 1";
             $ventaDia = $this->buscar($sql);
             $ventaDia['dia'] = $n_dia;
             $ventaDia['total'] = $ventaDia['total'] == "" ? 0 : $ventaDia['total'];
             $totalVentasMes += $ventaDia['total'];
             array_push($arrVentasDias, $ventaDia);
             $n_dia++;
        }
        $meses = Meses();
        $arrData = array('anio' => $anio, 'mes' => $meses[intval($mes-1)],'total' => $totalVentasMes, 'ventas' => $arrVentasDias);
        return $arrData;

    }


    public function selectMedioPago(int $anio, int $mes){
        $sql = "SELECT m.idmediopago, m.nombre as medios_pagos, COUNT(*) as cantidad, SUM(c.monto) as total FROM movimiento_caja c
        INNER JOIN medio_pago m ON c.mediopagoid = m.idmediopago 
        WHERE MONTH(c.created_at) = $mes AND YEAR(c.created_at) = $anio GROUP BY c.mediopagoid";
        $mediopago = $this->listar($sql);
        $meses = Meses();
        $arrData = array('anio' => $anio, 'mes' => $meses[intval($mes-1)], 'medios_pagos' => $mediopago);
        return $arrData;
    }

    public function selectTopProductos(int $anio, int $mes){
        $sql = "SELECT d.idarticulo, p.nombre, SUM(cantidad) as cantidad, SUM(v.total_venta) as total FROM detalle_venta d INNER JOIN venta v ON d.ventaid = v.idventa INNER JOIN producto p ON d.idarticulo = p.idProducto WHERE MONTH(d.created_at) = $mes AND YEAR(d.created_at) = $anio GROUP BY d.idarticulo LIMIT 5";
        $topProductos = $this->listar($sql);
        $meses = Meses();
        $arrData = array('anio' => $anio, 'mes' => $meses[intval($mes-1)], 'productos' => $topProductos);
        return $arrData;
    }
 }


?>