<!-- INICIO DE SESION -->

<!-- Algoritmo de carrito -->
<?php

    $mensaje = '';

    if (isset($_POST['btnAccion'])){
        switch ($_POST['btnAccion']) {
            case 'Agregar':
                if (is_numeric($_POST['id']))
                    $id = $_POST['id'];

                if (is_string($_POST['nombre']))
                    $nombre = $_POST['nombre'];

                if (is_numeric($_POST['precio']))
                    $precio = $_POST['precio'];

                if (is_numeric($_POST['cantidad']))
                    $cantidad = $_POST['cantidad'];

                if (!isset($_SESSION['carrito'])){
                    $producto = array(
                        'ID' => $id,
                        'NOMBRE' => $nombre,
                        'PRECIO' => $precio,
                        'CANTIDAD' => $cantidad
                    );

                    $_SESSION['carrito'][0] = $producto;
                    $mensaje = 'Platillo agregado a pedidos<br><br>';
                }

                else {
                    $idProductos = array_column($_SESSION['carrito'], 'ID');

                    if (in_array($id, $idProductos)) {
                        foreach ($_SESSION['carrito'] as $indice => $producto) {
                            if ($producto['ID'] == $id) {
                                $_SESSION['carrito'][$indice]['CANTIDAD'] += $cantidad;
                                $mensaje = 'Platillo agregado a pedidos<br>';
                                $mensaje .= "Cantidad: " . $_SESSION['carrito'][$indice]['CANTIDAD'] . " de este mismo platillo<br><br>";
                            }
                        }
                    }

                    else {
                        $numeroProductos = count($_SESSION['carrito']);
                        $producto = array(
                            'ID' => $id,
                            'NOMBRE' => $nombre,
                            'PRECIO' => $precio,
                            'CANTIDAD' => $cantidad
                        );

                        $_SESSION['carrito'][$numeroProductos] = $producto;
                        $mensaje = 'Platillo agregado a pedidos<br><br>';
                    }
                }

            break;

            case "Eliminar":

                if ($_POST['id'] != null){
                    $id = $_POST['id'];

                    foreach ($_SESSION['carrito'] as $indice => $producto) {
                        if ($producto['ID'] == $id) {
                            unset($_SESSION['carrito'][$indice]);
                            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                            echo '<script>alert("Platillo eliminado de pedidos")</script>';
                            break;
                        }
                    }
                }

                else
                    break;

            break;
        }
    }

?>