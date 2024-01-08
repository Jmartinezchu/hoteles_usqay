<?php
 
 require 'Libraries/html2pdf/vendor/autoload.php';
 use Spipu\Html2Pdf\Html2Pdf;
 use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
 
 class PrintSale extends Controllers{
     public function __construct()
     {
         parent::__construct();
         session_start();
     }

     public function reprintSale($idventa)
     {
       if(is_numeric($idventa)){
            ob_start();
            error_reporting(E_ALL & ~E_NOTICE);
            ini_set('display_errors', 0);
            ini_set('log_errors', 1);
           $idpersona = "";
           $data = $this->model->selectVenta($idventa,$idpersona);
           $idventa = $data['venta']['id'];
           ob_end_clean(); //eliminar buffer de salida
           $html = getFile("Template/Modals/copyprintSale",$data); //vista
           $html2pdf = new Html2Pdf('P','A4','es','true','UTF-8',0);
           $html2pdf->pdf->SetDisplayMode('fullpage');
           $html2pdf->writeHTML($html);
           $html2pdf->output('Venta -'.$idventa.'.pdf');
           // dep($data);
       }else{
           echo "dato no valido";
       }
     }
 }


?>