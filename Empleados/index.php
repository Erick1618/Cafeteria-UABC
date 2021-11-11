<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/LOGOuabc.png">
    <title>Cafeteria - UABC</title>

    <!-- Custom CSS -->
    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="dist/css/style.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="main.css">

    <!--datables CSS básico-->
    <link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css" />

    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css"
        href="assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    
    <?php

        //header('Content-Type: application/json; charset=utf-8');

        //Include Configuration File
        include('../config.php');

        $login_button = '';

        if (isset($_GET["code"])) {

            $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
            if (!isset($token['error'])) {

                $google_client->setAccessToken($token['access_token']);

                $_SESSION['access_token'] = $token['access_token'];

                $google_service = new Google_Service_Oauth2($google_client);

                $data = $google_service->userinfo->get();

                if (!empty($data['given_name'])) {
                    $_SESSION['user_first_name'] = $data['given_name'];
                }

                if (!empty($data['family_name'])) {
                    $_SESSION['user_last_name'] = $data['family_name'];
                }

                if (!empty($data['email'])) {
                    $_SESSION['user_email_address'] = $data['email'];
                }

                if (!empty($data['gender'])) {
                    $_SESSION['user_gender'] = $data['gender'];
                }

                if (!empty($data['picture'])) {
                    $_SESSION['user_image'] = $data['picture'];
                }

                if (!empty($data['id'])) {
                    $_SESSION['id'] = $_GET['id'];
                }
            }
        }

        //Ancla para iniciar sesión
        if (!isset($_SESSION['access_token'])) {
            header ("Location: ../index.php");
        }

        // echo '<div class="card-header">Welcome User</div><div class="card-body">';
        // echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
        // echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
        // echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
        // echo '<h3><b>ID :</b> ' . $_SESSION['id'] . '</h3>';

    ?>

    <!-- <h1> ERES ADMINISTRADOR </h1>
    <h3><a href="./../logout.php">Logout</h3></div> -->

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                     
                    <!-- Imagen de perfil usuario -->
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="index.html">
                            <b class="logo-icon">
                                <?php
                                echo '<img img width="80" height="80" src="' . $_SESSION["user_image"] . '" sizes="" alt="homepage" class="dark-logo" />';
                                echo '<img img width="80" height="80" src="' . $_SESSION["user_image"] . '" alt="homepage" class="light-logo" />';
                                ?>
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span>
                                <?php
                                echo $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'];
                                ?>
                            </span>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->

                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                
            </nav>
        </header>
     <!-- sidebar botones -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav" >
                    <ul id="sidebarnav">
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="./../Administrador/index.php"
                                aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">Empleados</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="index.php"
                                aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                    class="hide-menu">Platillos</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="menu.html"
                                aria-expanded="false"><i data-feather="message-square" class="feather-icon"></i><span
                                    class="hide-menu">Menu</span></a></li>

                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="index.html"
                            aria-expanded="false"><i data-feather="power" class="feather-icon"></i><span
                            class="hide-menu">Scan QR code</span></a></li>   

                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="../logout.php"
                                aria-expanded="false"><i data-feather="power" class="feather-icon"></i><span
                                class="hide-menu">Logout</span></a></li>            
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        
       <!-- CRUD de informacion  -->
        <div class="page-wrapper">
          
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <button id="btnNuevo" type="button" class="btn btn-info" data-toggle="modal"><i
                                    class="material-icons">library_add</i></button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="container caja">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablaUsuarios" class="table table-striped table-bordered table-condensed"
                                    style="width:100%">
                                    <thead class="text-center">
                                        <tr>
                                            <th>id_platillo</th>
                                            <th>nombre_platillo</th>
                                            <th>descripcion_platillo</th>
                                            <th>precio_platillo</th>
                                            <th>foto_platillo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <!--Modal para CRUD-->
                    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"> Nuevo platillo </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="formUsuarios">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Nombre del platillo:</label>
                                                <input type="text" class="form-control" id="nombre_platillo">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Descripcion: </label>
                                                <input type="text" class="form-control" id="descripcion_platillo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Precio: </label>
                                                <input type="number" class="form-control" id="precio_platillo">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="" class="col-form-label">Foto: </label>
                                                <input type="file" class="" id="foto_platillo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
       
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
  
    <!-- jQuery, Popper.js, Bootstrap JS -->
   <script src="assets/jquery/jquery-3.3.1.min.js"></script>
   <script src="assets/popper/popper.min.js"></script>
   <script src="assets/bootstrap/js/bootstrap.min.js"></script>
   <!-- datatables JS -->
   <script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
   <script type="text/javascript" src="./main.js"></script>

    <!-- All Jquery -->
   
    <!-- apps -->
    <!-- apps -->
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="assets/extra-libs/c3/d3.min.js"></script>
    <script src="assets/extra-libs/c3/c3.min.js"></script>
    <script src="assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="dist/js/pages/dashboards/dashboard1.min.js"></script>


</body>
</html>