<?php 

	class PermisosModel extends Mysql
	{
        public $intIdpermisos;
        public $intTipoUsuarioId;
        public $intModuloid;
        public $read;
        public $write;
        public $update;
        public $delete;

		public function __construct()
		{
			parent::__construct();
		}	

        public function selectModulos()
        {
            $sql = "SELECT * FROM modulo WHERE estado != 0";
            $request = $this->listar($sql);
            return $request;
        }
        
        public function selectPermisosRol(int $idtipousuario)
        {
            $this->intTipoUsuarioId = $idtipousuario;
            $sql = "SELECT * FROM permisos WHERE rolid = $this->intTipoUsuarioId";
            $request = $this->listar($sql);
            return $request;
        }

        public function deletePermisos(int $idtipousuario)
        {
            $this->intTipoUsuarioId = $idtipousuario;
            $sql = "DELETE FROM permisos WHERE rolid = $this->intTipoUsuarioId";
            $request = $this->eliminar($sql);
            return $request;
        }

        public function insertarPermiso(int $idtipousuario, int $idmodulo, int $r, int $w, int $u, int $d)
        {
            $this->intTipoUsuarioId = $idtipousuario;
            $this->intModuloid      = $idmodulo;
            $this->read             = $r;
            $this->write            = $w;
            $this->update           = $u;
            $this->delete           = $d;
            $query_insert = "INSERT INTO permisos(rolid,moduloid,r,w,u,d) VALUES(?,?,?,?,?,?)";
            $arrData = array(
                $this->intTipoUsuarioId,
                $this->intModuloid,
                $this->read,
                $this->write,
                $this->update,
                $this->delete,
            );
            $request_insert = $this->insertar($query_insert,$arrData);
            return $request_insert;
        }


        public function permisosModulo(int $idrol)
        {
            $this->intTipoUsuarioId = $idrol;
            $sql = "SELECT p.rolid, p.moduloid, p.r, p.w, p.u, p.d
                    FROM permisos p 
                    INNER JOIN modulo m
                    ON p.moduloid = m.idmodulo
                    WHERE p.rolid = $this->intTipoUsuarioId";
            $request = $this->listar($sql);
            $arrPermisos = array();
            for($i=0;  $i < count($request); $i++){
                $arrPermisos[$request[$i]['moduloid']] = $request[$i];
            }
            return $arrPermisos;
        }


	}
 ?>