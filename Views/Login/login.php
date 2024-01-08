<!DOCTYPE html>
<html lang="es">

    <head>
	<meta charset="UTF-8">

		<title><?= $data['page_title']; ?></title>

		<!--Favicon -->
		<link rel="icon" href="<?= media(); ?>/images/.png" type="image/x-icon"/>


		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="<?= media(); ?>/plugins/bootstrap/css/bootstrap.min.css">

		<!--Icons css-->
		<link rel="stylesheet" href="<?= media(); ?>/css/icons.css">


		<!--Style css-->
		<link rel="stylesheet" href="<?= media(); ?>/css/style.css">

		<link rel="stylesheet" href="<?= media(); ?>/css/estilos.css">

		<!--mCustomScrollbar css-->
		<link rel="stylesheet" href="<?= media(); ?>/plugins/scroll-bar/jquery.mCustomScrollbar.css">

		<!--Sidemenu css-->
		<link rel="stylesheet" href="<?= media(); ?>/plugins/toggle-menu/sidemenu.css">





        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= media(); ?>/images/usqay-icon.svg">

        <!-- App css -->
        <link href="<?= media(); ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= media(); ?>/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?= media(); ?>/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />

    </head>

    <body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <!-- <div class="auth-brand text-center "> -->
                        <div class=" text-center ">
                            <a href="index.html" class="logo-dark">
                                <span><img src="<?= media(); ?>/images/logo.png" alt="" height="104"></span>
                            </a>
                            <!-- <a href="index.html" class="logo-light">
                                <span><img src="assets/images/logo.png" alt="" height="64"></span>
                            </a> -->
                        </div>
                        <br>
                        <!-- title-->
                        <!-- <h4 class="mt-0">Sign In</h4> -->
                        <p class="text-muted mb-4">Ingresa un correo y una contraseña para acceder.</p>

                        <!-- form -->
                        <form id="formlogin" name="formlogin"  action="">
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Correo electrónico</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="ejemplo@example.com">
                            </div>
                            <div class="mb-3">
                                <!-- <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Forgot your password?</small></a> -->
                                <label for="password" class="form-label">Contraseña</label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="*****">
                            </div>
                            <!-- <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div> -->
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Acceder </button>
                            </div>
                            <!-- social-->
                            <!-- <div class="text-center mt-4">
                                <p class="text-muted font-16">Sign in with</p>
                                <ul class="social-list list-inline mt-3">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div> -->
                        </form>
                        <!-- end form-->

                        <!-- Footer-->
                        <!-- <footer class="footer footer-alt">
                            <p class="text-muted">Don't have an account? <a href="pages-register-2.html" class="text-muted ms-1"><b>Sign Up</b></a></p>
                        </footer> -->

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                    <!-- <h2 class="mb-3">Central telefónica: (01) 642 9247</h2> -->
                    <p class="lead">Central telefónica: <b class="mb-3">(01) 642 9247</b>

                    <br>
                        Visitanos en <b class="mb-3 ">www.sistemausqay.com</b>


                    </p>
                    <!-- <p>
                        - Hyper Admin User
                    </p> -->
                </div> <!-- end auth-user-testimonial-->
            </div>
            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="<?= media();?>/js/vendor.min.js"></script>
        <script src="<?= media();?>/js/app.min.js"></script>

		<script>
			const base_url = "<?= base_url(); ?>";
		</script>
		<!--Jquery.min js-->
		<script src="<?= media(); ?>/js/jquery.min.js"></script>

		<!--popper js-->
		<script src="<?= media(); ?>/js/popper.js"></script>

		<!--Tooltip js-->
		<script src="<?= media(); ?>/js/tooltip.js"></script>

		<!--Bootstrap.min js-->
		<script src="<?= media(); ?>/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!--Jquery.nicescroll.min js-->
		<script src="<?= media(); ?>/plugins/nicescroll/jquery.nicescroll.min.js"></script>

		<!--Scroll-up-bar.min js-->
		<script src="<?= media(); ?>/plugins/scroll-up-bar/dist/scroll-up-bar.min.js"></script>

		<script src="<?= media(); ?>/js/moment.min.js"></script>

		<!--mCustomScrollbar js-->
		<script src="<?= media(); ?>/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
		
		<!--Othercharts js-->
		<script src="<?= media(); ?>/plugins/othercharts/jquery.knob.js"></script>
		<script src="<?= media(); ?>/plugins/othercharts/jquery.sparkline.min.js"></script>
		
		<!--Sidemenu js-->
		<script src="<?= media(); ?>/plugins/toggle-menu/sidemenu.js"></script>

		<!--Scripts js-->
		<script src="<?= media(); ?>/js/scripts.js"></script>

		<script src="<?= media(); ?>/plugins/cloudflare/sweetalert.min.js"></script>

		<script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>



    </body>

</html>



