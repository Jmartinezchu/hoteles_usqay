<?php
 
 class DetailStoreHouseMovementModel extends Mysql{

    public $idDetalleMovimiento;
    public $idmovimiento;
    public $almacenid;
    public $productoid;
    public $cantidad_retirada;
    public $usuario;
    public $descripcion;

    public function __construct(){
        parent::__construct();
    }

    public function insertarDetalleMovimiento(int $movimiento, int $almacen, int $producto, int $cantidad, string $user, string $descripcion){
        $this->idmovimiento = $movimiento;
        $this->almacenid = $almacen;
        $this->productoid = $producto;
        $this->cantidad_retirada = $cantidad;
        $this->usuario = $user;
        $this->descripcion = $descripcion;

        $sql = "SELECT tipo_movimiento FROM movimiento_almacenes WHERE idmovimiento_almacen = $this->idmovimiento";
        $tipo = $this->listar($sql);
       
        $insert = "INSERT INTO detalle_movimiento_almacen(movimientoid,almacenid,productoid,cantidad_retirada,usuario,descripcion) 
                   VALUES(?,?,?,?,?,?)";
        $arrData = array($this->idmovimiento, $this->almacenid, $this->productoid, $this->cantidad_retirada, $this->usuario, $this->descripcion);
        $request_insert = $this->insertar($insert,$arrData);

        if($tipo[0]['tipo_movimiento'] == "2"){
            $cantidad = $cantidad*-1; 
        }
        
        $insert = "INSERT INTO movimiento_producto(productoid,cantidad,tipo_movimiento,almacenid,movimientoid) 
                   VALUES (?,?,?,?,?)";
        $arrData1 = array($this->productoid,$cantidad,$tipo[0]['tipo_movimiento'],$this->almacenid, $this->idmovimiento);
        
      
        $request_insert = $this->insertar($insert,$arrData1);
        return $request_insert;

    }

    public function deleteDetalleMovimiento(int $iddetalle)
    {
        $this->idDetalleMovimiento = $iddetalle;
        $sql = "DELETE FROM detalle_movimiento_almacen WHERE iddetalle_movimiento = $this->idDetalleMovimiento";
        $request = $this->eliminar($sql);
        return $request;

    }

    
    public function selectDetailStoreHouseMovement(int $idmovimiento){
        $this->idmovimiento = $idmovimiento;
        $sql = "SELECT d.iddetalle_movimiento, p.nombre, d.cantidad_retirada, d.descripcion, d.fecha 
                FROM detalle_movimiento_almacen d 
                INNER JOIN producto p 
                ON d.productoid = p.idProducto 
                WHERE d.estado != 0 AND d.movimientoid = $this->idmovimiento";
        $request = $this->listar($sql);
        return $request;
    }
 }


?>