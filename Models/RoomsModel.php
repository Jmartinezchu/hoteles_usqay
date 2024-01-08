<?php
 
 class RoomsModel extends Mysql{

    public $idHabitacion;
    public $nombreHabitacion;
    public $categoria;
    public $estado;
    public $capacidad;
    public $precio_dia;
    public $precio_hora;
    public $descripcion;
    public $piso;

    public function __construct()
    {
        parent::__construct();
    }	

    public function updateHabitacion(int $idhabitacion, string $nombre,int $categoria,string $estado,int $capacidad,string $descripcion, int $piso){
        $this->idHabitacion = $idhabitacion;
        $this->nombreHabitacion =  $nombre;
        $this->categoria = $categoria;
        $this->estado = $estado;
        $this->capacidad = $capacidad;
        $this->descripcion = $descripcion;
        $this->piso = $piso;

        $sql_habitacion = "SELECT * FROM habitacion WHERE idhabitacion = $this->idHabitacion";

        $request_sql = $this->buscar($sql_habitacion);
        if($request_sql['estado_habitacion'] != 'Ocupada'){
            $sql = "UPDATE habitacion SET nombre_habitacion = ?, categoriahabitacionid = ?,estado_habitacion = ?, capacidad = ?, descripcion = ?, idpiso = ? WHERE idhabitacion = $this->idHabitacion ";

            $arrData = array($this->nombreHabitacion, $this->categoria,$this->estado,$this->capacidad,$this->descripcion, $this->piso);
            $request = $this->actualizar($sql,$arrData);
                  
            return $request;
        }
        

    }
    public function updateEstadoHabitacion(int $idhabitacion, string $nombreHabitacion, string $estado){
        $this->idHabitacion = $idhabitacion;
        $this->nombreHabitacion = $nombreHabitacion;
        $this->estado = $estado;

        $sql_habitacion = "SELECT * FROM habitacion WHERE idhabitacion = $this->idHabitacion";

        $request_sql = $this->buscar($sql_habitacion);
        if($request_sql['estado_habitacion'] != 'Ocupada'){
            $sql = "UPDATE habitacion SET nombre_habitacion = ?, estado_habitacion = ? WHERE idhabitacion = $this->idHabitacion ";

            $arrData = array($this->nombreHabitacion, $this->estado);
            $request = $this->actualizar($sql,$arrData);
                  
            return $request;
        }
    }

    public function selectRoomsId(int $idhabitacion){
        $this->idHabitacion = $idhabitacion;
        $sql = "SELECT * 
              FROM habitacion
              WHERE idhabitacion =  $this->idHabitacion";
        $request = $this->buscar($sql);
        return $request;
    }

    public function inserthabitacion(string $nombreHabitacion,int $id_categoria, string $estado_habitacion,int $capacidad, string $descripcion, int $piso){
        $return = "";
        $this->nombreHabitacion = $nombreHabitacion;
        $this->categoria = $id_categoria;
        $this->estado = $estado_habitacion;
        $this->capacidad = $capacidad;
        $this->descripcion = $descripcion;
        $this->piso = $piso;
        
        $sql = "SELECT * FROM habitacion WHERE nombre_habitacion = '{$this->nombreHabitacion}' ";
        $request_sql = $this->buscar($sql);


        if(empty($request_sql)){
            $insert = "INSERT INTO habitacion(nombre_Habitacion,categoriahabitacionid,estado_habitacion, capacidad, descripcion, idpiso) VALUES (?,?,?,?,?,?)";
            $arrData = array($this->nombreHabitacion, $this->categoria, $this->estado, $this->capacidad, $this->descripcion, $this->piso);
            $request_insert = $this->insertar($insert,$arrData);
            $return = $request_insert;
        }else{
            $return = 'exist';
        }
        return $return;

    }


    public function selecthabitacion()
    {  
        $sql = "SELECT h.idhabitacion, h.nombre_habitacion, c.nombre_categoria_habitacion, h.estado_habitacion, h.capacidad  FROM habitacion h INNER JOIN categoria_habitacion c ON h.categoriahabitacionid = c.id_categoria_habitacion";
        $request = $this->listar($sql);
        return $request;
    }


    public function deleteRooms(int $idhabitacion){

        $this->idHabitacion = $idhabitacion;
        $sql = "SELECT * FROM habitacion WHERE idhabitacion = $this->idHabitacion";
        $request_sql = $this->buscar($sql);
        $idhabitacion = $request_sql['idhabitacion'];

        if($request_sql['estado_habitacion'] != 'Ocupada'){
             $sql_delete = "DELETE FROM habitacion WHERE idhabitacion = $this->idHabitacion";
             $request_delete = $this->eliminar($sql_delete);
             return $request_delete;
        }

    }
    public function TodoRooms()
    {
        $sql = "SELECT idhabitacion, nombre_habitacion FROM habitacion";
        $request = $this->listar($sql);
        return $request;

    }
    public function selectVariasHabitacion(){
        $sql="SELECT * FROM habitacion WHERE estado != 0 ORDER BY nombre_habitacion ASC";
        $request = $this->listar($sql);
        return $request;
    }
    

 }

?>