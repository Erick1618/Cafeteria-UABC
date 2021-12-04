<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="./images/LOGOuabc.png">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:100,300,300i,400,500,600,700,900%7CRaleway:500">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/style.css">

    <title> MENU </title>

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
                                <div class="rd-navbar-brand"><a class="brand" href="index.php"><img class="brand-logo-dark" src="images/logo-198x66.jfif" alt="" width="198" height="66" /></a></div>
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
                                        <li class="rd-nav-item active"><a class="rd-nav-link" href="index.php">Inicio</a>
                                        </li>
                                        <li class="rd-nav-item"><a class="rd-nav-link" href="#">Código QR</a>
                                        </li>
                                        <li class="rd-nav-item"><a class="rd-nav-link" href="./verPedidos.php">Pedidos</a>
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
        <!-- Swiper-->
        <!-- <section class="section swiper-container swiper-slider swiper-slider-2 swiper-slider-3" data-loop="true" data-autoplay="5000" data-simulate-touch="false" data-slide-effect="fade">
            <div class="swiper-wrapper text-sm-left">
                <div class="swiper-slide context-dark" data-slide-bg="https://cheforopeza.com.mx/wp-content/uploads/2020/01/hotcakes-fruta.jpg">
                    <div class="swiper-slide-caption section-md">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-9 col-md-8 col-lg-7 col-xl-7 offset-lg-1 offset-xxl-0">
                                    <h1 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInUp" data-caption-delay="0"> DESAYUNO DEL DIA </span></h1>
                                    <a class="button button-lg button-primary button-winona button-shadow-2" href="./desayuno/index.php" data-caption-animate="fadeInUp" data-caption-delay="300"> Ver opciones para desayuno </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide context-dark" data-slide-bg="https://cdn.computerhoy.com/sites/navi.axelspringer.es/public/styles/1200/public/media/image/2020/08/hamburguesa-2028707.jpg?itok=ujl3qgM9">
                    <div class="swiper-slide-caption section-md">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-8 col-lg-7 offset-lg-1 offset-xxl-0">
                                    <h1 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInDown" data-caption-delay="0"> COMIDA DEL DIA </span></h1>
                                    <div class="button-wrap oh"><a class="button button-lg button-primary button-winona button-shadow-2" href="./comida/index.php" data-caption-animate="slideInUp" data-caption-delay="0"> Ver opciones para comida </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination" data-bullet-custom="true"></div>
            <div class="swiper-button-prev">
                <div class="preview">
                    <div class="preview__img"></div>
                </div>
                <div class="swiper-button-arrow"></div>
            </div>
            <div class="swiper-button-next">
                <div class="swiper-button-arrow"></div>
                <div class="preview">
                    <div class="preview__img"></div>
                </div>
            </div>
        </section> -->
        <!-- What We Offer-->
        <section class="section section-md bg-default">
            <div class="container">
                <h3 class="oh-desktop"><span class="d-inline-block wow slideInDown">CATEGORIAS</span></h3>
                <div class="row row-md row-30">
                    <div class="col-sm-6 col-lg-4">
                        <div class="oh-desktop">
                            <!-- Services Terri-->
                            <article class="services-terri wow slideInDown">
                                <div class="services-terri-figure"><a href="./desayunos.php"><img src="https://th.bing.com/th/id/R.dd075f3b7c48b874996d459e1337c8ab?rik=HH9XTVv%2fh4hYYw&pid=ImgRaw&r=0" alt="" width="370" height="278" /></a>
                                </div>
                                <div class="services-terri-caption"><span class="services-terri-icon linearicons-leaf" onclick="location.href='./desayunos.php'"></span>
                                    <h5 class="services-terri-title"><a href="./desayunos.php">DESAYUNOS</a></h5>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="oh-desktop">
                            <!-- Services Terri-->
                            <article class="services-terri wow slideInDown">
                                <div class="services-terri-figure"><a href="./sandwiches.php"><img src="https://th.bing.com/th/id/OIP.uO0-OLKeN-mFusDZfFerPgHaEU?pid=ImgDet&rs=1" alt="" width="370" height="278" /></a>
                                </div>
                                <div class="services-terri-caption"><span class="services-terri-icon linearicons-hamburger" onclick="location.href='./sandwiches.php'"></span>
                                    <h5 class="services-terri-title"><a href="./sandwiches.php">SANDWICHES</a></h5>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="oh-desktop">
                            <!-- Services Terri-->
                            <article class="services-terri wow slideInDown">
                                <div class="services-terri-figure"><a href="burritos.php"><img src="https://th.bing.com/th/id/OIP.BOUmKr7pKB03ntsKy07FxwHaEH?pid=ImgDet&rs=1" alt="" width="370" height="278" /></a>
                                </div>
                                <div class="services-terri-caption"><span class="services-terri-icon linearicons-steak" onclick="location.href='./burritos.php'"></span>
                                    <h5 class="services-terri-title"><a href="burritos.php">BURRITOS</a></h5>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="oh-desktop">
                            <!-- Services Terri-->
                            <article class="services-terri wow slideInDown">
                                <div class="services-terri-figure"><a href="./bebidas.php"><img src="https://i2.zst.com.br/images/tipos-de-bebidas-e-variacoes-do-cafe-photo24127313-44-1f-16.jpg" alt="" width="370" height="278" /></a>
                                </div>
                                <div class="services-terri-caption"><span class="services-terri-icon linearicons-coffee-cup" onclick="location.href='./bebidas.php'"></span>
                                    <h5 class="services-terri-title"><a href="./bebidas.php">BEBIDAS</a></h5>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="oh-desktop">
                            <!-- Services Terri-->
                            <article class="services-terri wow slideInDown">
                                <div class="services-terri-figure"><a href="./extras.php"><img src="https://th.bing.com/th/id/OIP.uVJFc2B0KS5Uke_Hhd-FAwHaEV?pid=ImgDet&rs=1" alt="" width="370" height="278" /></a>
                                </div>
                                <div class="services-terri-caption"><span class="services-terri-icon linearicons-ice-cream" onclick="location.href='./extras.php'"></span>
                                    <h5 class="services-terri-title"><a href="./extras.php">EXTRAS</a></h5>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <br>

        <!-- Section CTA-->
        <section class="primary-overlay section parallax-container" data-parallax-img="https://radanoticias.info/wp-content/uploads/2019/01/Restaurante-Escuela-Sauzal-3.jpg">
            <div class="parallax-content section-xl context-dark text-md-left">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-sm-8 col-md-7 col-lg-5">
                            <div class="cta-modern">
                                <h3 class="cta-modern-title wow fadeInRight">El Mejor Ambiente</h3>
                                <p class="lead">Contamos con grandes instalaciones que te haran sentir muy comodo junto a la gran comunidad cimarrona.</p>
                                <p class="cta-modern-text oh-desktop" data-wow-delay=".1s"><span class="cta-modern-decor wow slideInLeft"></span><span class="d-inline-block wow slideInDown">Segun el Jonas</span></p><a class="button button-md button-secondary-2 button-winona wow fadeInUp" href="#" data-wow-delay=".2s">VISITANOS</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Services  Last section-->
        <section class="section section-sm bg-default">
            <div class="container">
                <div class="owl-carousel owl-style-11 dots-style-2" data-items="1" data-sm-items="1" data-lg-items="2" data-xl-items="4" data-margin="30" data-dots="true" data-mouse-drag="true" data-rtl="true">
                    <article class="box-icon-megan wow fadeInUp">
                        <div class="box-icon-megan-header">
                            <div class="box-icon-megan-icon linearicons-bag"></div>
                        </div>
                        <h5 class="box-icon-megan-title"><a href="#">Promociones</a></h5>
                        <p class="box-icon-megan-text">Contamos con puntos que se iran acumulando con todas tus compras.</p>
                    </article>
                    <article class="box-icon-megan wow fadeInUp" data-wow-delay=".05s">
                        <div class="box-icon-megan-header">
                            <div class="box-icon-megan-icon linearicons-map2"></div>
                        </div>
                        <h5 class="box-icon-megan-title"><a href="#">Buena Ubicacion</a></h5>
                        <p class="box-icon-megan-text">El restaurante esta ubicado en una zona centrica entre las Facultades De UABC Unidad Sauzal.</p>
                    </article>
                    <article class="box-icon-megan wow fadeInUp" data-wow-delay=".1s">
                        <div class="box-icon-megan-header">
                            <div class="box-icon-megan-icon linearicons-radar"></div>
                        </div>
                        <h5 class="box-icon-megan-title"><a href="#">Wi-Fi</a></h5>
                        <p class="box-icon-megan-text">Contamos con red Cimarron Al alcance de tu Mesa!</p>
                    </article>
                    <article class="box-icon-megan wow fadeInUp" data-wow-delay=".15s">
                        <div class="box-icon-megan-header">
                            <div class="box-icon-megan-icon linearicons-thumbs-up"></div>
                        </div>
                        <h5 class="box-icon-megan-title"><a href="#">El Mejor Servicio</a></h5>
                        <p class="box-icon-megan-text">Contamos con grandes cocineros que garantizaran el mejor servicio para el cliente..</p>
                    </article>
                </div>
            </div>
        </section>

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

    <!-- <h1> ERES CLIENTE </h1>
    <h3><a href="./../logout.php">Logout</h3></div> -->

</body>

</html>