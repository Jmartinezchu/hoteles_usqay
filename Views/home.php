<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="<?= media();?>/images/usqay-icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="<?= media();?>/plugins/bootstrap/css/bootstrap.min.css" crossorigin="anonymous">
    <title><?php echo $data['page_tag']; ?></title>

    <style>

      body{
        background-color: black;
      }

      .overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: white;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
      }
    
      .lds-ellipsis {
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
      }
      .lds-ellipsis div {
        position: absolute;
        top: 33px;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: #F25C05;
        animation-timing-function: cubic-bezier(0, 1, 1, 0);
      }
      .lds-ellipsis div:nth-child(1) {
        left: 8px;
        animation: lds-ellipsis1 0.6s infinite;
      }
      .lds-ellipsis div:nth-child(2) {
        left: 8px;
        animation: lds-ellipsis2 0.6s infinite;
      }
      .lds-ellipsis div:nth-child(3) {
        left: 32px;
        animation: lds-ellipsis2 0.6s infinite;
      }
      .lds-ellipsis div:nth-child(4) {
        left: 56px;
        animation: lds-ellipsis3 0.6s infinite;
      }
      @keyframes lds-ellipsis1 {
        0% {
          transform: scale(0);
        }
        100% {
          transform: scale(1);
        }
      }
      @keyframes lds-ellipsis3 {
        0% {
          transform: scale(1);
        }
        100% {
          transform: scale(0);
        }
      }
      @keyframes lds-ellipsis2 {
        0% {
          transform: translate(0, 0);
        }
        100% {
          transform: translate(24px, 0);
        }
      }


    </style>
  </head>
  <body>

    <!-- LOADING - USQAY  -->
    <div class="overlay">
       <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>
    

    <script>
      setTimeout(() => {
        window.location.href = "<?= base_url() ?>/login";
      }, 3000);
    </script>
    

    <script src="<?= media();?>/plugins/jquery/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="<?= media();?>/js/popper.min.js" crossorigin="anonymous"></script>
    <script src="<?= media();?>/plugins/bootstrap/js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>