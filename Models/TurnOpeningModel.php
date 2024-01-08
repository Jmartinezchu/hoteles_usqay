<?php
 
 class TurnOpeningModel extends Mysql{

    public $IdAperturaCaja;
    public $CajaId;
    public $TurnoId;
    public $MontoInicial;

    public function __construct(){
        parent::__construct();
    }

    public function insertTurnOpening(int $cajas, int $turnos, float $monto_inicial){
        $this->CajaId = $cajas;
        $this->TurnoId = $turnos;
        $this->MontoInicial = $monto_inicial;

        $insert = "INSERT INTO movimiento_caja(monedaid,tipomovimientocaja_id,cajaid,turnoid,mediopagoid,usuarioid,monto,descripcion) VALUES(?,?,?,?,?,?,?,?)";
        $arrData = array(1,1,$this->CajaId,$this->TurnoId,3,$_SESSION['userData']['idusuario'],$this->MontoInicial,'Ingreso de monto inicial');
        $request_insert = $this->insertar($insert,$arrData);
        return $request_insert;
        
    }

 }


?>