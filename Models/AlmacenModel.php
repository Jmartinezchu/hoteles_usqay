<?php
 
 class AlmacenModel extends Mysql{

    public $idAlmacen;
    public $nombreAlmacen;
    public $ubicacionAlmacen;
    public $descripcionAlmacen;
    public $estado;


    public function __construct()
		{
			parent::__construct();
		}	

    public function insertAlmacen(string $nombre, string $ubicacion, string $descripcion){
        $return = "";
        $this->nombreAlmacen = $nombre;
        $this->ubicacionAlmacen = $ubicacion;
        $this->descripcionAlmacen = $descripcion;
        $sql = "SELECT * FROM almacen WHERE nombre_almacen = '{$this->nombreAlmacen}' ";
        $request_sql = $this->listar($sql);


        if(empty($request_sql)){
            $insert = "INSERT INTO almacen(nombre_almacen, ubicacion_almacen, descripcion_almacen) VALUES (?,?,?)";
            $arrData = array($this->nombreAlmacen, $this->ubicacionAlmacen, $this->descripcionAlmacen);
            $request_insert = $this->insertar($insert,$arrData);
            $return = $request_insert;
        }else{
            $return = 'exist';
        }
        return $return;
        }

    public function selectAlmacen(int $idalmacen){
        $this->idAlmacen = $idalmacen;
        $sql = "SELECT * FROM almacen WHERE idalmacen = $this->idAlmacen";
        $request = $this->buscar($sql);
        return $request;
        }

    public function selectAlmacenes(){  
        $sql = "SELECT * FROM almacen";
        $request = $this->listar($sql);
        return $request;
        }

    public function deleteAlmacen(int $idAlmacen){
          $this->idAlmacen = $idAlmacen;

          $sql = "DELETE FROM almacen WHERE idalmacen = $this->idAlmacen";
          
          $request = $this->eliminar($sql);
          return $request;
        }
    public function updateAlmacen(int $idalmacen, string $nombre, string $ubicacion, string $descripcion){
            $this->idAlmacen = $idalmacen;
            $this->nombreAlmacen = $nombre;
            $this->ubicacionAlmacen = $ubicacion;
            $this->descripcionAlmacen = $descripcion;

            $sql = "UPDATE almacen SET nombre_almacen = ?, ubicacion_almacen = ?, descripcion_almacen = ? WHERE idalmacen = $this->idAlmacen";
            $arrData = array($this->nombreAlmacen, $this->ubicacionAlmacen, $this->descripcionAlmacen);
            $request = $this->actualizar($sql,$arrData);              
            return $request;
        }
    }
?>