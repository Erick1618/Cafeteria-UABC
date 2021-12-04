<!DOCTYPE html>
<html class="wide wow-animation" lang="en">

<head>
    <title> PEDIDOS </title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/LOGOuabc.png">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:100,300,300i,400,500,600,700,900%7CRaleway:500">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Agregar estilo -->
    <link href="./css/responsive-tables.css" type="text/css" media="screen" rel="stylesheet"/>
    <!-- Agregar el plugin JS -->   
    <script type="text/javascript" src="./js/responsive-tables.js"></script>
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="js/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>

    <?php

        //header('Content-Type: application/json; charset=utf-8');

        //Include Configuration File
        include('../config.php');
        include('./pedidos.php');

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
            header("Location: http://cafeteria-prueba.com/index.php");
        } else {
            // Varaibles de registro
            $correo = $_SESSION['user_email_address'];
            $nombre = $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];

            // Conexion
            require('./../datos_conexion.php');

            $conexion = mysqli_connect($db_host, $db_usuario, $db_contra);

            if (mysqli_connect_errno()) {
                echo "Fallo al conectar con la BBDD";
                exit();
            }

            mysqli_select_db($conexion, $db_nombre) or die("No se encontro la BBDD");
            mysqli_set_charset($conexion, "utf8");

            $consulta = "SELECT * FROM EMPLEADOS WHERE CORREO_EMPLEADO = '$correo'";
            $resultados = mysqli_query($conexion, $consulta);

            if (mysqli_num_rows($resultados) == 1) {
                $seleccion = mysqli_fetch_array($resultados);
                $id_empleado = $seleccion['id_empleado'];
                $id_cliente = 0;

                $_SESSION['id'] = $id_empleado;
                $status = $seleccion['status'];

                $estudiante = false;
            } else {
                // Validacion de cliente
                $dominio = explode("@", $correo);
                if ($dominio[1] == "uabc.edu.mx") {
                    $id_empleado = 0;

                    $status = 0;
                    $estudiante = true;
                    $puntos = 0;

                    $consulta = "SELECT id_cliente FROM clientes WHERE correo_cliente = '$correo'";
                    $resultados = mysqli_query($conexion, $consulta);

                    if (mysqli_num_rows($resultados) == 1) {
                        $seleccion = mysqli_fetch_array($resultados);
                        $id_cliente = $seleccion['id_cliente'];

                        $_SESSION['id'] = $id_cliente;
                    } else {
                        echo "La consulta no encontro al cliente";

                        $consulta = "INSERT INTO clientes (nombre_cliente, correo_cliente, puntos) VALUE ('$nombre', '$correo', '$puntos')";
                        $resultados = mysqli_query($conexion, $consulta);

                        $consulta = "SELECT id_cliente FROM clientes WHERE correo_cliente = '$correo'";
                        $resultados = mysqli_query($conexion, $consulta);
                        echo "Consulta: " . $consulta;

                        $seleccion = mysqli_fetch_array($resultados);
                        $id_cliente = $seleccion['id_cliente'];

                        $_SESSION['id'] = $id_cliente;
                        $_SESSION['puntos'] = $puntos;
                    }
                } else {
                    header("Location: 404.html");
                }
            }
        }

        $nombre = $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];

        // echo '<div class="card-header">Welcome User</div><div class="card-body">';
        // echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
        // echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
        // echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
        // echo '<h3><b>ID :</b> ' . $_SESSION['id'] . '</h3>';

    ?>

    <div class="preloader">
        <div class="wrapper-triangle">
            <div class="pen">
                <div class="line-triangle">
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                </div>
                <div class="line-triangle">
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                </div>
                <div class="line-triangle">
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                    <div class="triangle"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="page">
        <!-- Page Header-->
        <header class="section page-header">
            <!-- RD Navbar-->
            <div class="rd-navbar-wrap">
                <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="56px" data-xl-stick-up-offset="56px" data-xxl-stick-up-offset="56px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                    <div class="rd-navbar-inner-outer">
                        <div class="rd-navbar-inner">
                            <!-- RD Navbar Panel-->
                            <div class="rd-navbar-panel">
                                <!-- RD Navbar Toggle-->
                                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                                <!-- RD Navbar Brand-->
                                <div class="rd-navbar-brand">
                                    <a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo-198x66.jfif" alt="" width="198" height="66" /></a>
                                </div>
                            </div>
                            <div class="rd-navbar-right rd-navbar-nav-wrap">
                                <div class="rd-navbar-aside">
                                    <article class="team-modern"><a class="team-modern-figure" href="#"><img src=<?php echo '"' . $_SESSION['user_image'] . '"' ?> class="img-circle" alt="" width="140" height="140" /></a>
                                        <div class="team-modern-caption">
                                            <h6 class="team-modern-name"><a href="#"> <?php echo $nombre ?> </a></h6>
                                        </div>
                                    </article>
                                </div>
                                <div class="rd-navbar-main">
                                    <!-- RD Navbar Nav-->
                                    <ul class="rd-navbar-nav">
                                        <li class="rd-nav-item"><a class="rd-nav-link" href="index.php">Inicio</a>
                                        </li>
                                        <li class="rd-nav-item"><a class="rd-nav-link" href="#">Código QR</a>
                                        </li>
                                        <li class="rd-nav-item active"><a class="rd-nav-link" href="./verPedidos.php">Pedidos</a>
                                        </li>
                                        <li class="rd-nav-item"><a class="rd-nav-link" href="./../logout.php">Cerrar Sesión</a>
                                        </li>
                                        <?php
                                        if ($status == 1 || $status == 2) {
                                            echo '<li class="rd-nav-item"><a class="rd-nav-link" href="./../Empleados/index.php"> Volver a administrador </a>
                                            </li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <?php

            if ($_POST){
                $total = 0;
                $sid = session_id();

                foreach ($_SESSION['carrito'] as $indice => $producto) {
                    $total = $total + ($producto['CANTIDAD'] * $producto['PRECIO']);
                }

                // $sentencia = "INSERT INTO ventas (clave_transaccion, paypal_datos, fecha, total, status)
                //               VALUES ('$sid', '', NOW(), $total, pendiente)";

                // $resultado = mysqli_query($conexion, $sentencia);

                // $idVenta = mysqli_insert_id($conexion);

                // foreach ($_SESSION['carrito'] as $indice => $producto) {
                //     $sentencia = "INSERT INTO detalle_venta (id_venta, id_producto, precio_unitario, cantidad)
                //                   VALUES ($idVenta, $producto[ID], $producto[PRECIO], $producto[CANTIDAD])";

                //     $resultado = mysqli_query($conexion, $sentencia);
                // }
            }

            //echo "<h3> Total: $" . number_format($total, 2) . "</h3>";

        ?>

        <div class="p-5 bg-light text-center">
            <div class="container"> 
                <h1 class="display-4"> ¡Paso Final ! </h1>
                <hr class="my-4">
                <p class="lead"> 
                    Estas a punto de pagar con paypal la cantida de: 
                    <h4>$<?php echo number_format($total, 2); ?>  </h4>
                </p>

                <!-- Set up a container element for the button -->
                <div id="paypal-button-container"></div>

                    <!-- Include the PayPal JavaScript SDK -->
                    <script src="https://www.paypal.com/sdk/js?client-id=Aa42K8UAcyt5z9_Yx3TWyuqjkszdkNEkBZLtYrtSst9mqxnj9CeM0S9Ym3Uco0kDcbqV9aCVezsOP6eI&currency=MXN"></script>

                    <script>
                        // Render the PayPal button into #paypal-button-container
                        paypal.Buttons({
                            style: {
                                layout: 'horizontal'
                            },

                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: '<?php echo $total; ?>',
                                            currency: 'MXN'
                                        }
                                    }]
                                });
                            },

                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(details) {
                                    // Show a success message to the buyer
                                    alert('PAGO REALIZADO!');
                                    location.href = './pagoCompleto.php';
                                });
                            }
                        }).render('#paypal-button-container');
                    </script>
            </div>
        </div>

        <!-- Page Footer-->
        <footer class="section footer-modern context-dark footer-modern-2">
            <div class="container">
                <div class="row row-3">
                    <div class="footer-modern-line-3">
                        <div class="container">
                            <div class="row row-10 justify-content-between">
                                <div class="col-md-6"><span>Carr. Transpeninsular 3917, U.A.B.C., 22860 Ensenada, B.C.</span></div>
                                <div class="col-md-auto">
                                    <!-- Rights-->
                                    <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span><span></span><span>.&nbsp;</span><span>Todos los Derechos Reservados.</span><span> Diseñado&nbsp;por&nbsp;<a href="https://www.facebook.com/pedrito.yepiz">El Mejor Equipo Admin</a></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
        </footer>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="js/core.min.js"></script>
    <script src="js/script.js"></script>
    <!-- coded by Himic-->
</body>

</html>