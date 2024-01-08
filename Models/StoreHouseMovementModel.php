<?php 

 class StoreHouseMovementModel extends Mysql{
     public $idMovimientoAlmacen;
     public $TipoMovimiento;
     public $AlmacenId;
     public $Descripcion;

     public function insertarMovimiento(int $tipo_movimiento, string $almacen, string $descripcion){
         $this->TipoMovimiento = $tipo_movimiento;
         $this->AlmacenId = $almacen;
         $this->Descripcion = $descripcion;

        
        $insert = "INSERT INTO movimiento_almacenes(tipo_movimiento,almacenid,descripcion) VALUES(?,?,?)";
        $arrData = array($this->TipoMovimiento, $this->AlmacenId, $this->Descripcion);
        $request_insert = $this->insertar($insert,$arrData);
        return $request_insert;
        
     }

     public function selectStoreHouseMovement(){
         $sql = "SELECT m.idmovimiento_almacen, m.tipo_movimiento, m.almacenid, a.nombre_almacen, m.descripcion  FROM movimiento_almacenes m INNER JOIN almacen a ON m.almacenid = a.idalmacen WHERE m.estado != 0 and m.tipo_movimiento !=3";
         $request = $this->listar($sql);
         return $request;
     }

     public function deleteMovimiento(int $idmovimiento_almacen){
        $this->idMovimientoAlmacen = $idmovimiento_almacen;
        $sql_movimiento = "SELECT * FROM detalle_movimiento_almacen WHERE movimientoid = $this->idMovimientoAlmacen";
        $request_movimiento = $this->listar($sql_movimiento);
        if(empty($request_movimiento)){
            $sql = "DELETE FROM movimiento_almacenes WHERE idmovimiento_almacen = $this->idMovimientoAlmacen";
          
            $request = $this->eliminar($sql);
            return $request;
        }
        
       
     } 

 }


?>

