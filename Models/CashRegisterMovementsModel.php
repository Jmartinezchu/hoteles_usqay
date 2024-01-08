<?php

 class cashregistermovementsModel extends Mysql{

     public $idCashRegisterMovement;
     public $TipoMovimiento;
     public $Cajas;
     public $Moneda;
     public $UsuarioId;
     public $TurnoId;
     public $MetodoPago;
     public $Monto;
     public $Descripcion;

     public function __construct(){
         parent::__construct();
     }

     public function selectTipoMovimiento(){
        $sql = "SELECT id_tipomovimientocaja,nombre FROM `tipo_movimiento_caja`
                where id_tipomovimientocaja BETWEEN  11 and 12";
        $request = $this->listar($sql);
        return $request;
     }

     
     public function selectMonedas(){
        $sql = "SELECT * FROM `monedas` where id_moneda = 1";
        $request = $this->listar($sql);
        return $request;
     }

     public function selectMediosPago(){
        $sql = "SELECT * FROM `medio_pago` where estado  != 0";
        $request = $this->listar($sql);
        return $request;
     }

     public function insertCashMovement( int $moneda, int $tipo_movimiento, int $cajas,int $turnoid, int $metodo_pago,int $usuario, float $monto, string $descripcion){
        $this->Moneda = $moneda;
        $this->TipoMovimiento = $tipo_movimiento;
        $this->Cajas = $cajas;
        $this->TurnoId = $turnoid;
        $this->MetodoPago = $metodo_pago;
        $this->UsuarioId = $usuario;
        $this->Monto = $monto;
        $this->Descripcion = $descripcion;

        $sql = "SELECT id_tipomovimientocaja FROM tipo_movimiento_caja WHERE id_tipomovimientocaja = $this->TipoMovimiento";
        $tipo = $this->listar($sql);
        $estado = 1;

        if($tipo[0]['id_tipomovimientocaja'] == 12){
            $monto = $monto*-1; 
            $estado = 2;
        }
       

        $insert = "INSERT INTO movimiento_caja(monedaid,tipomovimientocaja_id,cajaid,turnoid,mediopagoid,usuarioid,monto,descripcion,estado) VALUES (?,?,?,?,?,?,?,?,?)";
        $arrData = array($this->Moneda,$tipo[0]['id_tipomovimientocaja'],$this->Cajas,$this->TurnoId,$this->MetodoPago,$this->UsuarioId,$monto,$this->Descripcion,$estado);

      //   var_dump($arrData);

        $request_insert = $this->insertar($insert,$arrData);
        return $request_insert;
     }

     public function selectCashRegisterMovements(){
        $sql = "SELECT c.id_movimientocaja, 
                DATE_FORMAT(c.created_at,'%d %M %Y %H:%i') as fecha, 
                t.nombre, c.descripcion,
                c.monto FROM movimiento_caja c
                INNER JOIN tipo_movimiento_caja t 
                ON c.tipomovimientocaja_id = t.id_tipomovimientocaja";
        $request_sql = $this->listar($sql);
        return $request_sql;
     }
 }


?>