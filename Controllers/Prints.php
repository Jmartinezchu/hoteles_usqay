<?php 
 
 class Prints extends Controllers{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    
    public function ticketres(){
        $data['page_title'] =  "Imprimir Ticket Reserva";
        $this->views->getView($this,"ticketres",$data);
    }

    public function boletares(){
        $data['page_title'] =  "Imprimir Boleta Reserva";
        $this->views->getView($this,"boletares",$data);
    }

    public function facturares(){
        $data['page_title'] =  "Imprimir Factura Reserva";
        $this->views->getView($this,"facturares",$data);
    }

    public function ticketsales(){
        $data['page_title'] =  "Imprimir Ticket Benta";
        $this->views->getView($this,"ticketsales",$data);
    }

    public function boletasales(){
        $data['page_title'] =  "Imprimir Boleta Venta";
        $this->views->getView($this,"boletasales",$data);
    }

    public function facturasales(){
        $data['page_title'] =  "Imprimir Factura Venta";
        $this->views->getView($this,"facturasales",$data);
    }

    public function cortesia(){
        $data['page_title'] =  "Imprimir cortesia reserva";
        $this->views->getView($this,"cortesia",$data);
    }

    public function precuenta(){
        $data['page_title'] =  "Precuenta ";
        $this->views->getView($this,"precuenta",$data);
    }
    
    public function comanda(){
        $data['page_title'] =  "COMANDA";
        $this->views->getView($this,"comanda",$data);
    }

    public function reimpresion(){
        $data['page_title'] =  "Reimprimir Reserva";
        $this->views->getView($this,"reimpresion",$data);
    }

    public function qrgen(){
        $data['page_title'] =  "Generador QR";
        $this->views->getView($this,"qrgen",$data);
    }

    public function closeBox(){
        $data['page_title'] = "Cierre de caja";
        $this->views->getView($this,"closebox",$data);
    }

 }


?>