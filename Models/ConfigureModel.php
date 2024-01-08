<?php 
 
 class ConfigureModel extends Mysql{

     public $idConfig;
     public $nombreEmpresa;
     public $ruc;
     public $razon_social;
     public $direccion;
     public $telefono;
     public $correo;
     public $serie_boleta;
     public $serie_factura;
     public $token;
     public $ruta;
     public $Id_detraccion;
     public $TipoEstadia;

     public function __construct(){
         parent::__construct();
     }

     public function selectConfigShow(int $idconfig){
        $this->idConfig = $idconfig;
        $sql = "SELECT * FROM configuracion WHERE id = $this->idConfig";
        $request_sql = $this->buscar($sql);
        return $request_sql;
     }

     public function insertConfigure(int $idconfig,  $nombreEmpresa,  $ruc,  $direccion,   $telefono, $razon_social,  $serie_boleta, $serie_factura,  $correo,  $ruta,  $token, $iddetraccion,$tipoEstadia){
         
        $this->idConfig = $idconfig;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->ruc = $ruc;
        $this->razon_social = $razon_social;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->serie_boleta = $serie_boleta;
        $this->serie_factura = $serie_factura;
        $this->ruta = $ruta;
        $this->token = $token;
        $this->Id_detraccion = $iddetraccion;
        $this->TipoEstadia = $tipoEstadia;


        $insert = "UPDATE configuracion SET nombre_negocio = ?, ruc = ?,direccion = ?,telefono = ?,razon_social = ?,serie_boleta = ?,serie_factura = ?,correoElectronico = ?, ruta =?,token = ?, id_detraccion = ?, estadia_dias_horas = ? WHERE id = $this->idConfig";
        $arrData = array(
                         $this->nombreEmpresa,
                         $this->ruc,
                         $this->razon_social,
                         $this->direccion,
                         $this->telefono,
                         $this->serie_boleta,
                         $this->serie_factura,
                         $this->correo,
                         $this->ruta,   
                         $this->token,
                         $this->Id_detraccion,
                         $this->TipoEstadia
                        );
        $request_insert = $this->actualizar($insert,$arrData);
        

        $sql="SELECT estadia_dias_horas FROM configuracion WHERE id = $this->idConfig";
        $request_sql = $this->buscar($sql);
        
        $estadia = intval($request_sql['estadia_dias_horas']);
        if($estadia == 0){
            $sql_update = "UPDATE tarifas SET estado = ? WHERE idTarifa = 1 OR idTarifa = 2";
            $arrData_update = array(0);
            $request_update = $this->actualizar($sql_update, $arrData_update);
        }else{
            $sql_update = "UPDATE tarifas SET estado = ? WHERE idTarifa = 1 OR idTarifa = 2";
            $arrData_update = array(1);
            $request_update = $this->actualizar($sql_update, $arrData_update);
        }
        return $request_insert and $request_update;
     }
 }

?>