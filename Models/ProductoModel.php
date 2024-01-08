<?php

class ProductoModel  extends Mysql{

    public $IdProducto;
    public $categoriaId;
    public $sunatId;
    public $nombrePro;
    public $precioVenta;
    public $estado;
    public $unidadMedida;

    public function __construct()
    {
        parent::__construct();
    }


    public function insertProducto(int $categoriaId,int $sunatId,string $nombrePro, float $precioventa, string $unidadMedida){
        
        $this->categoriaId = $categoriaId;
        $this->sunatId = $sunatId;
        $this->nombrePro = $nombrePro;
        $this->precioVenta = $precioventa;
        $this->unidadMedida = $unidadMedida;
      
        $insert = "INSERT INTO producto(categoriaid,sunatid,nombre,precio_venta,unidadMedida) VALUES (?,?,?,?,?)";
        $arrData = array($this->categoriaId,$this->sunatId,$this->nombrePro,$this->precioVenta,$this->unidadMedida);
        $request_insert = $this->insertar($insert,$arrData);
        return $request_insert;
          
        }
        public function selectProductos()
        {
          $sql="SELECT p.idProducto, cp.descripcion as codecategoria,sc.description as codesunat ,p.nombre,p.precio_venta,p.estado
          from producto p INNER JOIN categoria_producto cp ON p.categoriaid=cp.idcategoria
          INNER JOIN sunat_codes sc ON p.sunatid=sc.id WHERE p.nombre != 'SERVICIO DE HOSPEDAJE' AND p.nombre != 'AUMENTO DE ESTADIA' AND unidadMedida = 'NIU'";
          $request = $this->listar($sql);
        
          return $request;  
        }
        public function selectServicios()
        {
          $sql="SELECT p.idProducto, cs.descripcion as codecategoria,sc.description as codesunat ,p.nombre,p.precio_venta,p.estado
          from producto p INNER JOIN categoria_servicio cs ON p.categoriaid=cs.idcategoria
          INNER JOIN sunat_codes sc ON p.sunatid=sc.id WHERE p.nombre != 'SERVICIO DE HOSPEDAJE' AND p.nombre != 'AUMENTO DE ESTADIA' AND unidadMedida = 'ZZ'";
          $request = $this->listar($sql);
        
          return $request;  
        }



        public function selectProductoCmb(){
          $sql = "SELECT * FROM producto where estado != 0";
          $request = $this->listar($sql);
          return $sql;
        }

        public function deleteProducto(int $idProducto)
        {
          $this->IdProducto = $idProducto;



          $sql = "DELETE FROM producto WHERE idProducto = $this->IdProducto";
          
          $request = $this->eliminar($sql);
          return $request;
        }

        public function actualizarproducto(int $idproducto, int $idcategoria, int $idsunat, string $nombre, float $precioventa )
        {
            $this->IdProducto = $idproducto;
            $this->categoriaId = $idcategoria;
            $this->sunatId = $idsunat;
            $this->nombrePro = $nombre;
            $this->precioVenta = $precioventa;
               
            $sql = "UPDATE producto SET categoriaid = ?,sunatid = ?,nombre = ?,precio_venta = ?  WHERE idProducto = $this->IdProducto";
            
            $arrData = array($this->categoriaId, $this->sunatId,$this->nombrePro, $this->precioVenta);
            $request = $this->actualizar($sql,$arrData);
              
            return $request;
        }

        public function selectProducto(int $idproducto) 
        {
    
            $this->IdProducto = $idproducto;
            $sql = "SELECT * FROM producto WHERE idProducto = $this->IdProducto";
            $request = $this->buscar($sql);
            return $request;
        }




      }
?>