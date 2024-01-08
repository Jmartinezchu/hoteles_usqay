<?php
require_once("Libraries/Core/Mysql.php");

Trait TProducto {
    private $con;
	private $strCategoria;
	private $intIdcategoria;
	private $intIdProducto;
	private $strProducto;
	private $cant;
	public function getProductoIDT(int $idproducto){
		$this->con = new Mysql();
		$this->intIdProducto = $idproducto;
		// $sql = "SELECT p.idProducto, p.nombre, p.categoriaid, c.descripcion as categoria, p.precio_venta FROM producto p INNER JOIN categoria_producto c ON p.categoriaid = c.idcategoria WHERE p.estado != 0 AND p.idproducto = $this->intIdProducto";
        $sql = "SELECT d.idmovimiento_producto,d.productoid, p.nombre,  p.precio_venta, a.nombre_almacen,sum(d.cantidad) as stock FROM movimiento_producto d INNER JOIN producto p on d.productoid = p.idProducto INNER JOIN almacen a ON d.almacenid = a.idalmacen WHERE d.almacenid = 1 AND d.productoid = $this->intIdProducto GROUP BY p.nombre";
		$request = $this->con->buscar($sql);
				
		return $request;
	}
}


?>