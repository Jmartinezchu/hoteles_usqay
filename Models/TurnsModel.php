<?php 

 class TurnsModel extends Mysql{
     public $IdTurno;
     public $Nombre_turno;
     public $Hora_inicio;
     public $Hora_fin;

     public function insertTurn(string $nombre_turno, string $hora_inicio, string $hora_fin){
         $this->Nombre_turno = $nombre_turno;
         $this->Hora_inicio = $hora_inicio;
         $this->Hora_fin = $hora_fin;

         $sql = "SELECT * FROM turnos WHERE nombre_turno = '{$this->Nombre_turno}' ";
         $request_sql = $this->buscar($sql);

         if(empty($request_sql)){
             $insert = "INSERT INTO turnos(nombre_turno,inicio_turno,fin_turno) VALUES(?,?,?)";
             $arrData = array($this->Nombre_turno, $this->Hora_inicio, $this->Hora_fin);
             $request_insert = $this->insertar($insert,$arrData);
             $return = $request_insert;
         }else{
             $return = 'exist';
         }
         return $return;
     }
     
     public function updateTurn(int $idTurno, string $nombre_turno, string $hora_inicio, string $hora_fin){
        $this->IdTurno = $idTurno;
        $this->Nombre_turno = $nombre_turno;
         $this->Hora_inicio = $hora_inicio;
         $this->Hora_fin = $hora_fin;

            $sql = "UPDATE turnos SET nombre_turno = ?, inicio_turno = ?, fin_turno = ? WHERE idturno = $this->IdTurno";

            $arrData = array($this->Nombre_turno, $this->Hora_inicio, $this->Hora_fin);
            $request = $this->actualizar($sql,$arrData);
                  
            return $request;
    }

     public function selectTurns(){
         $sql = "SELECT *  FROM turnos WHERE estado != 0";
         $request = $this->listar($sql);
         return $request;
     }

     public function deleteTurns(int $idturno)
     {
        $this->IdTurno = $idturno;

        $sql = "DELETE FROM turnos WHERE idturno = $this->IdTurno";

        $request = $this->eliminar($sql);
        return $request;
     }

     public function selectTurnsId(int $idTurns){
        $this->IdTurno = $idTurns;
        $sql = "SELECT * 
              FROM turnos
              WHERE idturno =  $this->IdTurno";
        $request = $this->buscar($sql);
        return $request;
    }
 }


?>