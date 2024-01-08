<?php
 
 class RoomsCategoryModel extends Mysql{

 

    public function __construct()
		{
			parent::__construct();
		}	

    

    public function selectRoomsCategory()
    {  
        $sql = "SELECT * FROM categoria_habitacion WHERE estado != 0";
        $request = $this->listar($sql);
        return $request;
    }

    

 }

?>