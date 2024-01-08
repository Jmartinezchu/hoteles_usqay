<?php
 
 class RolModel extends Mysql{

    public $idRol;
    public $nombreRol;
    public $estado;


    public function __construct()
		{
			parent::__construct();
		}	

    public function insertRol(string $nombrerol){
        $return = "";
        $this->nombreRol = $nombrerol;

        $sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->nombreRol}' ";
        $request_sql = $this->buscar($sql);


        if(empty($request_sql)){
            $insert = "INSERT INTO rol(nombre_rol) VALUES (?)";
            $arrData = array($this->nombreRol);
            $request_insert = $this->insertar($insert,$arrData);
            $return = $request_insert;
        }else{
            $return = 'exist';
        }
        return $return;

    }

    public function updateRol(int $idRol, string $nombrerol){
        $return = "";
        $this->idRol = $idRol;
        $this->nombreRol = $nombrerol;

        $sql = "UPDATE rol SET nombre_rol = ? WHERE idrol = $this->idRol";
        $arrData = array($this->nombreRol);
        $request = $this->actualizar($sql,$arrData);
        return $return;

    }

    public function selectRolShow(int $idrol)
    {
        $this->idRol = $idrol;
        $sql = "SELECT * FROM rol WHERE idrol = $this->idRol";
        $request = $this->buscar($sql);
        return $request;
    }

    public function selectRoles()
    {  
        $sql = "SELECT * FROM rol WHERE estado != 0";
        $request = $this->listar($sql);
        return $request;
    }

    public function deleteRol(int $idrol)
        {
            $this->idRol = $idrol;
           
            $sql = "SELECT * FROM usuario WHERE rolid = $this->idRol";
            $request = $this->listar($sql);
  
            if(empty($request))
            {
                $sql = "DELETE FROM rol WHERE idrol = $this->idRol";
                $request = $this->eliminar($sql);
                if($request)
                {
                    $request = 'ok';
                }else{
                    $request = 'error';
                }
            }else{
                $request = 'exist';
            }
            return $request;

        }


 }

?>