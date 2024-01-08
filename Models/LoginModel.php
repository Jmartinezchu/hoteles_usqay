<?php 

	class LoginModel extends Mysql
	{
        private $IdUsuario;
        private $Usuario;
        private $Password;
        private $Token;


		public function __construct()
		{
			parent::__construct();
		}	

        public function loginUser(string $usuario, string $password)
        {
            $this->Usuario  = $usuario;
            $this->Password = $password;

            $sql = "SELECT idusuario, estado FROM usuario WHERE
                    email_user = '$this->Usuario' and password = '$this->Password' and
                    estado != 0";
            $request = $this->buscar($sql);
            return $request;

        }

        public function sessionLogin(int $idusuario)
        {
            $this->IdUsuario = $idusuario;

            //BUSCAR ROL
            $sql = "SELECT u.idusuario, u.identificacion, u.nombres, u.apellidos, u.telefono, u.email_user, r.idrol, r.nombre_rol, u.estado FROM usuario u INNER JOIN rol r ON u.rolid = r.idrol WHERE u.idusuario = $this->IdUsuario";
            $request = $this->buscar($sql);
            return $request;
        }
	}
 ?>