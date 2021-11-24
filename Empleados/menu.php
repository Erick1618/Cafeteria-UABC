<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="icon" type="image/png" sizes="16x16" href="assets/img/LOGOuabc.png">
	<title> Cafeteria-UABC </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="./css/main.css">
	<link rel="stylesheet" href="./css/bootstrap.min.css">
    
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
            header("Location: http://cafeteria-prueba.com/index.php");
        }

        else {
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

            if (mysqli_num_rows($resultados) == 1){
                $seleccion = mysqli_fetch_array($resultados);
                $id_empleado = $seleccion['id_empleado'];
                $id_cliente = 0;

                $_SESSION['id'] = $id_empleado;
                $status = $seleccion['status'];

                $estudiante = false;
            }

            else {
                // Validacion de cliente
                $dominio = explode("@", $correo);
                if ($dominio[1] == "uabc.edu.mx") {
                    $id_empleado = 0;

                    $estudiante = true;
                    $puntos = 0;

                    $consulta = "SELECT id_cliente FROM clientes WHERE correo_cliente = '$correo'";
                    $resultados = mysqli_query($conexion, $consulta);

                    if (mysqli_num_rows($resultados) == 1){
                        $seleccion = mysqli_fetch_array($resultados);
                        $id_cliente = $seleccion['id_cliente'];

                        $_SESSION['id'] = $id_cliente;
                    }

                    else {
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
                }

                else {
                    header ("Location: 404.html");
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

	<!-- SideBar -->
	<section class="full-box cover dashboard-sideBar" >
		<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
		<div class="full-box dashboard-sideBar-ct" style="background-color: #0e333171;">
			<!--SideBar Title -->
			<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
				Cafeteria - UABC <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
			</div>
			<title></title>
			<!-- SideBar User info -->
			<div class="full-box dashboard-sideBar-UserInfo">
				<figure class="full-box">
                    <?php
                    echo '<img src="' . $_SESSION['user_image'] . '" alt="UserIcon">';
                    echo '<figcaption class="text-center text-titles">' . $nombre . '</figcaption>'
                    ?>
				</figure>
				<ul class="full-box list-unstyled text-center">
					<li>
						<a href="#!" class="btn-exit-system">
							<i class="zmdi zmdi-power"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- SideBar Menu -->
			<ul class="list-unstyled full-box dashboard-sideBar-Menu"  >
				<li>
					<a href="./admin.php">
						<i class="zmdi zmdi-apps"></i> Scan QR
					</a>
				</li>
				<li>
                    <?php
						if($status == 1){
							echo
							'<a href="./../Administrador/index.php" >
								<i class="zmdi zmdi-accounts"></i> Empleados 
							</a>';
						}
					?>
				</li>
				<li>
					<a href="./index.php" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-cutlery"></i> Platillos
					</a>
				</li>
				<li>
					<a href="./menu.php" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-menu"></i> Menu 
					</a>
					
				</li>
                <li>
					<a href="./menu_rotativo_desayuno/index.php" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-cutlery"></i> Menu Rotativo (Desayuno)
					</a>
				</li>
                <li>
					<a href="./menu_rotativo_comida/index.php" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-cutlery"></i> Menu Rotativo (Comida)
					</a>
				</li>
				<li>
					<a href="./../Clientes/index.php" class="btn-sideBar-SubMenu">
						<i class="zmdi zmdi-shield-security zmdi-hc-fw"></i> Ver Menu
					</a>
					
				</li>
			</ul>
		</div>
	</section>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage" style="background-color: #e48a230c;" >
		<!-- NavBar -->
		<nav class="full-box dashboard-Navbar"style="background-color: #16817A;">
			<ul class="full-box list-unstyled text-right">
				<li class="pull-left">
					<a href="#!" class="btn-menu-dashboard"><i class="zmdi zmdi-more-vert"></i></a>
				</li>
				<li>
					<a href="#!" class="btn-modal-help" data-toggle="modal" data-target="#Dialog-Help">
						<i class="zmdi zmdi-help-outline"></i>
					</a>
				</li>
			</ul>
		</nav>
        
		<!-- Content page -->
		<div class="container-fluid">
			<div class="container caja">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="tablaUsuarios" class="table table-striped table-bordered table-condensed"
								style="width:100%">
								<thead class="text-center">
									<tr>
										<th>Nombre Platillo</th>
                                        <th>Categoria</th>
                                        <th>Mostrar Platillo</th>
									</tr>
								</thead>
								<tbody>
                                    <?php 
                                        $sql = "SELECT * FROM platillos";
                                        $result = mysqli_query($conexion, $sql);

                                        while($row = mysqli_fetch_array($result)){
                                            echo '<tr>';
                                                ////////////////////////////////////////////////////////////////////////////////////////////////

                                                echo '<td>' . $row['nombre_platillo'] . '</td>';

                                                ///////////////////////////////////////////////////////////////////////////////////////////////

                                                if ($row['categoria_platillo'] == 0){
                                                    echo 
                                                    '<td> 
                                                    
                                                        <select class="form-control" id="categoria_platillo" name="categoria_platillo" onchange="categoria(' . $row["id_platillo"] . ', this);">
                                                            <option value="0">Seleccione una categoria</option>
                                                            <option value="1"> Extras </option>
                                                            <option value="2"> Bebidas </option>
                                                            <option value="3"> Sandwiches </option>
                                                            <option value="4"> Desayunos </option>
                                                        </select>

                                                    </td>';
                                                }
                                                if ($row['categoria_platillo'] == 1){
                                                    echo 
                                                    '<td> 
                                                    
                                                        <select class="form-control" id="categoria_platillo" name="categoria_platillo" onchange="categoria(' . $row["id_platillo"] . ', this);">
                                                            <option value="1"> Extras </option>
                                                            <option value="2"> Bebidas </option>
                                                            <option value="3"> Sandwiches </option>
                                                            <option value="4"> Desayunos </option>
                                                        </select>

                                                    </td>';
                                                }
                                                if ($row['categoria_platillo'] == 2){
                                                    echo 
                                                    '<td> 
                                                    
                                                        <select class="form-control" id="categoria_platillo" name="categoria_platillo" onchange="categoria(' . $row["id_platillo"] . ', this);">
                                                            <option value="2"> Bebidas </option>
                                                            <option value="1"> Extras </option>
                                                            <option value="3"> Sandwiches </option>
                                                            <option value="4"> Desayunos </option>
                                                        </select>

                                                    </td>';
                                                }
                                                if ($row['categoria_platillo'] == 3){
                                                    echo 
                                                    '<td> 
                                                    
                                                        <select class="form-control" id="categoria_platillo" name="categoria_platillo" onchange="categoria(' . $row["id_platillo"] . ', this);">
                                                            <option value="3"> Sandwiches </option>
                                                            <option value="1"> Extras </option>
                                                            <option value="2"> Bebidas </option>
                                                            <option value="4"> Desayunos </option>
                                                        </select>

                                                    </td>';
                                                }
                                                if ($row['categoria_platillo'] == 4){
                                                    echo 
                                                    '<td> 
                                                    
                                                        <select class="form-control" id="categoria_platillo" name="categoria_platillo" onchange="categoria(' . $row["id_platillo"] . ', this);">
                                                            <option value="4"> Desayunos </option>    
                                                            <option value="3"> Sandwiches </option>
                                                            <option value="1"> Extras </option>
                                                            <option value="2"> Bebidas </option>
                                                        </select>

                                                    </td>';
                                                }

                                                ///////////////////////////////////////////////////////////////////////////////////////////////

                                                if ($row['mostrar_platillo'] == 0){
                                                    echo '<td>';
                                                    echo '<div class="text-center"><div class="btn-group">';
                                                    echo    '<button type="submit" id="btnON" class="btn btn-outline-secondary" onclick="mostrar(' . $row["id_platillo"] . ');"> MOSTRAR </button>';
                                                    echo    '<button type="submit" id="btnOFF" class="btn outline-danger" disabled> OCULTAR </button>';
                                                    echo '</div></div>';
                                                    echo '</td>';
                                                }

                                                if ($row['mostrar_platillo'] == 1){
                                                    echo '<td>';
                                                    echo '<div class="text-center"><div class="btn-group">';
                                                    echo    '<button type="submit" id="btnON" class="btn btn-outline-primary" disabled> MOSTRAR </button>';
                                                    echo    '<button type="submit" id="btnOFF" class="btn outline-danger" onclick="ocultar(' . $row["id_platillo"] . ');"> OCULTAR </button>';
                                                    echo '</div></div>';
                                                    echo '</td>';
                                                }

                                            echo '</tr>';
                                        }
                                    ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
			
	</section>

</div>
	<!-- Dialog help -->
	<div class="modal fade" tabindex="-1" role="dialog" id="Dialog-Help">
        <div class="modal-dialog" role="document">
		    <div class="modal-content">
			    <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				    <h4 class="modal-title">Help</h4>
			    </div>
			    <div class="modal-body">
				    <p>
                        Seccion de administracion del menu
                        <br>
                        Los platillos creados, deben ser asignados a un categoria, ademas de decidir si se muestran o no en el menu.
                        <br>
                        Platillos sin categoria, no se mostraran en el menu.
				    </p>
			    </div>
				<div class="modal-footer">
				    <button type="button" class="btn btn-primary btn-raised" data-dismiss="modal"><i class="zmdi zmdi-thumb-up"></i> Ok</button>
				</div>
		    </div>
		</div>
    </div>
	
    <!--====== Scripts -->
    <script src="./js/jquery-3.1.1.min.js"></script>
    <script src="./js/sweetalert2.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/material.min.js"></script>
    <script src="./js/ripples.min.js"></script>
    <script src="./js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="./js/main.js"></script>
    
    <script src="assets/popper/popper.min.js"></script>
    

    <!-- datatables JS -->
    <script type="text/javascript" src="./assets/datatables/datatables.min.js"></script>

    <!-- <script type="text/javascript" src="main.js"></script> -->
    <script>
        $(document).ready(function(){
            $('.btn-exit-system').on('click', function(){
                swal({
                    title: '¿Está seguro?',
                    text: "Su sesion actual sera terminada",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#03A9F4',
                    cancelButtonColor: '#F44336',
                    confirmButtonText: '<i class="zmdi zmdi-run"></i> Cerrar Sesion',
                    cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> Cancelar'
                })
                
                .then(function () {
                    window.location.href="./../logout.php";
                });
            });
        });

        function mostrar(id_platillo){
            console.log("mostrar");
            console.log(id_platillo);

            $.ajax ({
                method: 'POST',
                url: './php/mostrar.php',
                data: {
                    id_platillo: id_platillo
                },

                success: function(response){
                    location.reload();
                }
            })
        }

        function ocultar(id_platillo){
            console.log("ocultar");
            console.log(id_platillo);

            $.ajax ({
                method: 'POST',
                url: './php/ocultar.php',
                data: {
                    id_platillo: id_platillo
                },

                success: function(response){
                    location.reload();
                }
            })
        }

        function categoria(id_platillo, categoria){
            console.log("categoria");

            var categoria = categoria.value;

            console.log(id_platillo);
            console.log(categoria);

            $.ajax ({
                method: 'POST',
                url: './php/categoria.php',
                data: {
                    id_platillo: id_platillo,
                    categoria_platillo: categoria
                },

                success: function(response){
                    location.reload();
                }
            })
        }
        
    </script>

	<script>
		$.material.init();
	</script>
</body>
</html>