<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php

        //Include Configuration File
        include('../config.php');

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
            }
        }

        $id_cliente = $_SESSION['id'];

        // Conexion
        require('../datos_conexion.php');

        $conexion = mysqli_connect($db_host, $db_usuario, $db_contra);

        if (mysqli_connect_errno()) {
            echo "Fallo al conectar con la BBDD";
            exit();
        }

        mysqli_select_db($conexion, $db_nombre) or die("No se encontro la BBDD");
        mysqli_set_charset($conexion, "utf8");

        //Ancla para iniciar sesión
        if (!isset($_SESSION['access_token'])) {
            header ("Location: ../index.php");
        }

        $consulta = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
        $resultados = mysqli_query($conexion, $consulta);
        $seleccion = mysqli_fetch_array($resultados);
        $puntos = $seleccion['puntos'];

        echo '<div class="card-header">Welcome User</div><div class="card-body">';
        echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
        echo '<h3><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
        echo '<h3><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h3>';
        echo '<h3><b>ID :</b> ' . $_SESSION['id'] . '</h3>';
        echo '<h3><b>Puntos :</b> ' . $puntos . '</h3>';

    ?>

    <h1> ERES CLIENTE </h1>
    <h3><a href="./../logout.php">Logout</h3></div>
    
</body>
</html>