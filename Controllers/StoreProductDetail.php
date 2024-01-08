<?php
 
 class StoreProductDetail extends Controllers{
     public function __construct(){
        session_start();
        if(empty($_SESSION['login']))
        {
            header('Location: '.base_url().'/login');
        }
        parent::__construct();
     }

     public function storeproductdetail(){
         
     }
 }


?>