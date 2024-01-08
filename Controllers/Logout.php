<?php
    	class Logout
        {
            public function __construct()
            {
                session_start();
                session_unset(); //limpiamos variables de session
                session_destroy(); //destruir
                header('location: '.base_url().'/login');
            }
        }
?>