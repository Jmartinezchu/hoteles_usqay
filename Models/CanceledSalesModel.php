<?php 
 
 class CanceledSalesModel extends Mysql{
   
    public function selectCanceledSales(){
        
        $sql = "SELECT v.idventa, u.nombres as cliente, v.created_at, v.tipo_comprobante, v.medio_pago_id,  v.total_venta, v.venta_estado_id as estado  FROM venta v INNER JOIN usuario u ON v.clienteid=u.idusuario  WHERE v.venta_estado_id = 3 and u.nombres != '' ";
        $request_sql = $this->listar($sql);

        // var_dump($request_sql);
        return $request_sql;
    }
  

 }
?>