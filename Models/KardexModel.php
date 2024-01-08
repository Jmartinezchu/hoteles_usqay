<?php
 
 class KardexModel extends Mysql{

     public $idAlmacen;
     public $idKardex;
     public $idProducto;

     public function __construct(){
         parent::__construct();
     }

     public function selectKardex(int $idalmacen){
        $this->idAlmacen = $idalmacen;
        $sql = "SELECT d.idmovimiento_producto, d.productoid, p.nombre, a.nombre_almacen,sum(d.cantidad) as stock
                FROM movimiento_producto d 
                INNER JOIN producto p on d.productoid = p.idProducto 
                INNER JOIN almacen a ON d.almacenid = a.idalmacen 
                WHERE d.almacenid = $this->idAlmacen
                GROUP BY p.nombre";
        $request = $this->listar($sql);
        return $request;
     }

     public function selectkardexSeguimiento(int $idproducto){
         $this->idProducto = $idproducto;
            $sql = "SELECT d.idmovimiento_producto, SUM(d.cantidad * p.precio_venta) as total,  
            d.productoid, p.nombre, a.nombre_almacen, d.cantidad,  d.tipo_movimiento,
            d.fecha, mp.descripcion
            FROM movimiento_producto d 
            LEFT JOIN producto p on d.productoid = p.idProducto 
            LEFT JOIN almacen a ON d.almacenid = a.idalmacen
            LEFT JOIN detalle_movimiento_almacen mp ON d.movimientoid = mp.movimientoid
            WHERE d.productoid = $this->idProducto
            GROUP BY d.idmovimiento_producto
            ORDER BY d.idmovimiento_producto DESC";
         $request = $this->listar($sql);
         return $request;
     }


     

     
 }

?>