<?php

    //Include Configuration File
    include('config.php');

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

            $_SESSION['id'] = 0;
        }
    }

    //Ancla para iniciar sesión
    if (!isset($_SESSION['access_token'])) {
        $login_button = '<a href="' . $google_client->createAuthUrl() . '" style=" background: #FF0000; border-radius: 5px; color: white; display: block; font-weight: bold; padding: 20px; text-align: center; text-decoration: none; width: 200px;"> Login With Google </a>';
    } else {
        // Varaibles de registro
        $correo = $_SESSION['user_email_address'];
        $nombre = $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'];

        // Conexion
        require('datos_conexion.php');

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

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> Login con Google Account </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="./estilos.css">

</head>

<body>
    <?php
    if ($login_button == '') {
        // echo '<div class="card-header">Welcome User</div><div class="card-body">';
        // echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
        // echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
        // echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
        // echo '<h3><b>ID :</b> ' . $id . '</h3>';

        if ($status == 1 && $estudiante == false) {
            // echo '<h3><b>Rol :</b> ADMINISTRADOR </h3>';
            echo "<script> 
                <!--
                window.location.replace('http://cafeteria-prueba.com/administrador/index.php');
                -->
                </script>";
        }

        if ($status == 2 && $estudiante == false) {
            //echo '<h3><b>Rol :</b> EMPLEADO </h3>';
            echo "<script> 
                <!--
                window.location.replace('http://cafeteria-prueba.com/Empleados/index.php'); 
                -->
                </script>";
        }

        if ($estudiante == true) {
            // echo '<div class="card-header">Welcome User</div><div class="card-body">';
            // echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
            // echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
            // echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
            // echo '<h3><b>ID :</b> ' . $_SESSION['id'] . '</h3>';
            // echo '<h3><b>Puntos :</b> ' . $puntos . '</h3>';
            // echo '<h3><b>Rol :</b> ESTUDIANTE </h3>';
            echo "<script> 
                <!--
                window.location.replace('http://cafeteria-prueba.com/Clientes/index.php'); 
                -->
                </script>";
        }
    } else {
        // echo '<div align="center">' . $login_button . '</div>';
        ?>
            <div class="row justify-content-center pt-5 mt-5 m-1">
                <div class="container">
                    <div class="row justify-content-center pt-5">
                        <img src="./img/logo-198x66.jfif" class="logo">
                    </div>
                </div>        

                <div class="container">
                    <div class="row justify-content-center mt-5 m-1">
                        <div class="col-10 formulario">
                            <form action="">
                                <div class="form-group text-center pt-3">
                                    <h1 class="text-light">INICIAR SESIÓN</h1>
                                </div>
                                <div class="form-group mx-sm-4 pb-2 boton">
                                    <?php
                                        echo $login_button;
                                    ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
    ?>
</body>

</html>