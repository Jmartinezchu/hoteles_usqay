<?php
  
 class UsersModel extends Mysql{
 
    public $idUsuario;
    public $Identificacion;
    public $Nombres;
    public $Apellidos;
    public $Telefono;
    public $Email_user;
    public $Password;
    public $Token;
    public $Rolid;
    public $Estado;

     
    
    public function __construct(){
         parent::__construct();
    }

    public function selectUsers(){
          $sql = "SELECT u.idusuario, u.nombres, u.email_user, u.rolid
          FROM usuario u 
          WHERE u.estado != 0 AND u.idusuario != 1 AND u.rolid != 7";
          $request = $this->listar($sql);
          return $request; 
    }

    public function insertUser(string $identificacion, string $nombre, string $apellido, int $telefono, string $email,  string $password, int $roles ){

      $this->Identificacion = $identificacion;
      $this->Nombres = $nombre;
      $this->Apellidos = $apellido;
      $this->Telefono = $telefono;
      $this->Email_user = $email;
      $this->Password = $password;
      $this->Rolid = $roles;

      $sql = "SELECT * FROM usuario WHERE email_user = '{$this->Email_user}' or identificacion = '{$this->Identificacion}'";
      $request = $this->listar($sql);
      if(empty($request))
      {
            $query_insert = "INSERT INTO usuario(identificacion,nombres,apellidos,telefono,email_user,password,rolid) VALUES(?,?,?,?,?,?,?)";
            $arrData = array( $this->Identificacion,
                              $this->Nombres,
                              $this->Apellidos,
                              $this->Telefono,
                              $this->Email_user,
                              $this->Password,
                              $this->Rolid
                              );
            $request_insert = $this->insertar($query_insert,$arrData);
            $return = $request_insert;
      }else{
            $return = "exist";
      }
      return $return;
    }


    public function updateUser(int $idUsuario, string $identificacion, string $nombre, string $apellido, int $telefono, string $email, string $password, int $roles)
    {
      $this->idUsuario = $idUsuario;
      $this->Identificacion = $identificacion;
      $this->Nombres = $nombre;
      $this->Apellidos = $apellido;
      $this->Telefono = $telefono;
      $this->Email_user = $email;
      $this->Password = $password;
      $this->Rolid = $roles;
      $sql = "SELECT * FROM usuario WHERE (email_user = '{$this->Email_user}' AND idusuario != $this->idUsuario)
      OR (identificacion = '{$this->Identificacion}' AND idusuario != $this->idUsuario) ";
      $request = $this->buscar($sql);

      if(empty($request))
      {
            if($this->Password != "")
            {
                  $sql = "UPDATE usuario SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, password=?, rolid=?WHERE idusuario = $this->idUsuario";
                  $arrData = array($this->Identificacion,
                                   $this->Nombres,
                                   $this->Apellidos,
                                   $this->Telefono,
                                   $this->Email_user,
                                   $this->Password,
                                   $this->Rolid);
            }else{
                  $sql = "UPDATE usuario SET identificacion=?, nombres=?, apellidos=?, telefono=?, email_user=?, rolid=?WHERE idusuario = $this->idUsuario";
                  $arrData = array($this->Identificacion,
                                   $this->Nombres,
                                   $this->Apellidos,
                                   $this->Telefono,
                                   $this->Email_user,
                                   $this->Rolid);
            }
            $request = $this->actualizar($sql,$arrData);
      }else{
            $request = "exist";
      }
      return $request;
    }


    public function deleteUser(int $iduser){
       $this->idUsuario = $iduser;
       
       $sql = "UPDATE usuario SET estado = ? WHERE idusuario = $this->idUsuario ";
       $arrData = array(0);
       $request = $this->actualizar($sql,$arrData);
       return $request;

    }


    public function selectUserShow(int $idusuario){
      $this->idUsuario = $idusuario;
      $sql = "SELECT p.idusuario, p.identificacion, p.nombres, p.apellidos, p.telefono, p.email_user, r.idrol, r.nombre_rol
            FROM usuario p
            INNER JOIN rol r
            ON p.rolid = r.idrol
            WHERE p.idusuario = $this->idUsuario";
      $request = $this->buscar($sql);
      return $request;
    }
 
}


?>