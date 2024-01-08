<?php 
 
 class PrintSaleModel extends Mysql {

    public function __construct()
    {
        parent::__construct();
        
    }

    public function selectVenta(int $idventa)
    {
        $request = array();
        $sql = "SELECT v.idventa, v.clienteid as nombres,  DATE_FORMAT(v.created_at, '%d %M %Y %h:%i') as fecha, e.nombre, m.nombre as mediopago, tc.descripcion, v.usuario FROM venta v  INNER JOIN ventas_estado e ON v.venta_estado_id = e.id_venta_estado INNER JOIN medio_pago m ON v.medio_pago_id = m.idmediopago INNER JOIN tipo_comprobante_sunat tc ON v.tipo_comprobante = tc.id_tipo_comprobante WHERE v.idventa =  $idventa";
        $requestVenta = $this->buscar($sql);
        if(!empty($requestVenta))
        {
           $sql_detalle = "SELECT d.id_detalle_venta, d.ventaid, p.nombre, d.cantidad, d.precio_venta FROM detalle_venta d 
           INNER JOIN producto p ON d.idarticulo = p.idProducto
           INNER JOIN venta v ON d.ventaid = v.idventa
           WHERE d.ventaid = $idventa";
           $requestProductos = $this->listar($sql_detalle);
           $request = array(
                             'venta' => $requestVenta,
                             'detalle' => $requestProductos
                           );
           var_dump($request);
        }
        return $request;
    }
 }


?>