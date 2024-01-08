<?php 
 
 class TicketsModel extends Mysql{
   
    public $idBoleta;

    public function selectTickets(){
        $fechaInicio = date('Y-m-d');
        $fechaFin = date('Y-m-d');
        $sql = "SELECT b.id as id_boleta, b.serie, v.idventa, v.usuario, v.subtotal, v.total_impuestos, v.venta_estado_id as estado, v.total_venta, v.created_at  FROM venta v INNER JOIN boleta b ON v.idventa = b.id_venta WHERE v.created_at BETWEEN '". $fechaInicio ." 00:00:00' AND '".$fechaFin." 23:59:59'";
        // $sql = "SELECT b.id as id_boleta, b.serie, v.idventa, v.usuario, v.subtotal, v.total_impuestos, v.venta_estado_id as estado, v.total_venta, v.created_at  FROM venta v INNER JOIN boleta b ON v.idventa = b.id_venta ";
        $request_sql = $this->listar($sql);
        return $request_sql;
    }

    public function selectIdTicket(int $id_boleta){
        $this->idBoleta = $id_boleta;
        $sql = "SELECT * FROM boleta WHERE id = $this->idBoleta ";
        $request_sql = $this->buscar($sql);
        $sql_config = "SELECT * FROM configuracion WHERE id = 1";
        $request_sql_config = $this->buscar($sql_config);
        $serie = $request_sql_config['serie_boleta'];
        $ruta = $request_sql_config["ruta"];
        $token = $request_sql_config["token"];
        $cabecera = array();
        $cabecera["operacion"] = "consultar_comprobante";
        $cabecera["tipo_de_comprobante"] = "2";
        $cabecera["serie"] = $serie;
        $cabecera["numero"] = $id_boleta;
        $cabecera["motivo"] = "ERROR DEL SISTEMA";
        $cabecera["codigo_unico"] = "";
        $data_json = json_encode($cabecera);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
                $ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Token token="'.$token.'"',
                'Content-Type: application/json',
                )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        // var_dump($respuesta);exit;
        return $respuesta;
    }


    public function deleteTicket(int $id_boleta)
    {
        $this->idBoleta = $id_boleta;
        $sql = "SELECT * FROM boleta WHERE id = $this->idBoleta ";
        $request_sql = $this->buscar($sql);
       
        $idventa = $request_sql['id_venta'];
  
       
        // var_dump($request_update);
        $sql_config = "SELECT * FROM configuracion WHERE id = 1";
        $request_sql_config = $this->buscar($sql_config);
        $serie = $request_sql_config['serie_boleta'];
        $ruta = $request_sql_config["ruta"];
        $token = $request_sql_config["token"];

        $cabecera = array();
        $cabecera["operacion"] = "generar_anulacion";
        $cabecera["tipo_de_comprobante"] = "2";
        $cabecera["serie"] = $serie;
        $cabecera["numero"] = $id_boleta;
        $cabecera["motivo"] = "ERROR DEL SISTEMA";
        $cabecera["codigo_unico"] = "";
        $data_json = json_encode($cabecera);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Authorization: Token token="' . $token . '"',
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $respuesta  = curl_exec($ch);
        if (intval(curl_errno($ch)) === 0) {
            curl_close($ch);

            $leer_respuesta = json_decode($respuesta, true);
            if (!isset($leer_respuesta['errors'])) {
                $sql_update = "UPDATE venta SET tipo_comprobante = ?, venta_estado_id = ? WHERE idventa = $idventa ";
                $arrData = array(6,4);
                $request_update = $this->actualizar($sql_update,$arrData);
                 return  $respuesta and $request_update ;
                
            }
        }else{
            curl_close($ch);
        }

        
    }
  
 }

?>