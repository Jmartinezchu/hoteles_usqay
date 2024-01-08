<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jeason Cueva">
    <meta name="theme-color" content="#283940">
    <link rel="shortcut icon" href="<?= media(); ?>/images/usqay-icon.svg" type="image/x-icon">
    <title>404. Página no encontrada - Usqay Hoteles</title>
    <!-- Main CSS-->
    
 
    <link rel="stylesheet" href="<?= media(); ?>/css/vendor/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="<?= media();?>/js/datepicker/jquery-ui.min.css"> 
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }




        .bg_animate{
            width: 100%;
            height: 100vh;
            background: linear-gradient(to right, #2c364c, #28265f);
            position: relative;
            overflow: hidden;
        }

        .header_nav{
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .header_nav .contenedor{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }



        .banner_title a:hover
        {  
            color: rgb(255, 255, 255);
            background:#577acb;
        }
        .banner{
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .banner_title h2{
            color: rgb(255, 255, 255);
            font-size: 60px;
            font-weight: 800;
            margin-bottom: 20px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }


        .banner_title .manual{

            

            text-decoration: none;
            padding: 10px;
            font-weight: 600;
            font-size: 20px;    
            color: #ffffff;
            background-color: #292ba4;
            border-radius: 6px;
            border: none;
            display: inline-block;
            
            
        }

        .banner_img{
            animation: movimiento 2.5s linear infinite;
            text-align:center;
            margin-right: 800px;
        }
        .contenedor{
            width: 90%;
            max-width: 1500px;
            margin: auto;

            margin-left: 20%;
        }

        .banner_img img{
            width: 900px;
            display: block;
        }

        /* burbujas */

        .burbuja{
            border-radius: 50%;
            background: rgb(255, 255, 255);
            opacity: .3;

            position: absolute;
            bottom: -150;
            
            animation: burbujas 3s linear infinite ;
        }

        .burbuja:nth-child(1){
            width: 80px;
            height: 80px;
            left: 5%;
            animation-duration: 3s;
            animation-delay: 3s;
        }

        .burbuja:nth-child(2){
            width: 100px;
            height: 100px;
            left: 35%;
            animation-duration: 3s;
            animation-delay: 5s;
        }

        .burbuja:nth-child(3){
            width: 20px;
            height: 20px;
            left: 15%;
            animation-duration: 1.5s;
            animation-delay: 7s;
        }

        .burbuja:nth-child(4){
            width: 50px;
            height: 50px;
            left: 90%;
            animation-duration: 6s;
            animation-delay: 3s;
        }

        .burbuja:nth-child(5){
            width: 70px;
            height: 70px;
            left: 65%;
            animation-duration: 3s;
            animation-delay: 1s;
        }

        .burbuja:nth-child(6){
            width: 20px;
            height: 20px;
            left: 50%;
            animation-duration: 4s;
            animation-delay: 5s;
        }

        .burbuja:nth-child(7){
            width: 20px;
            height: 20px;
            left: 50%;
            animation-duration: 4s;
            animation-delay: 5s;
        }

        .burbuja:nth-child(8){
            width: 100;
            height: 100px;
            left: 52%;
            animation-duration: 5s;
            animation-delay: 5s;
        }

        .burbuja:nth-child(9){
            width: 65px;
            height: 65px;
            left: 51%;
            animation-duration: 3s;
            animation-delay: 2s;
        }

        .burbuja:nth-child(10){
            width: 40px;
            height: 40px;
            left: 35%;
            animation-duration: 3s;
            animation-delay: 4s;
        }


        @keyframes burbujas{
            0%{
                bottom: 0;
                opacity: 0;
            }
            30%{
                transform: translateX(30px);
            }
            50%{
                opacity: .4;
            }
            100%{
                bottom: 100vh;
                opacity: 0;
            }
        }

        @keyframes movimiento{
            0%{
                transform: translateY(0);
            }
            50%{
                transform: translateY(30px);
            }
            100%{
                transform: translateY(0);
            }
        }
    </style>

<script src="main.js"></script>
</head>

<!--End of Tawk.to Script-->
<body  background="01.webp">
<header class="bg_animate">
        
       
        <section class="banner contenedor">
            
            <div class="banner_img">
                <a href="<?= base_url(); ?>/dashboard"><img src="<?= media(); ?>/images/05.png" alt=""></a>
                
            </div>

        </section>

        
        <div class="burbujas">
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
            <div class="burbuja"></div>
        </div>
        
    </header>  

</body>
</html>