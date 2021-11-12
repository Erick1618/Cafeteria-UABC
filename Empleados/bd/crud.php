<?php
    include_once '../bd/conexion.php';

    $objeto = new Conexion();
    $conexion = $objeto->Conectar();

    $nombre_empleado = (isset($_POST['nombre_empleado'])) ? $_POST['nombre_empleado'] : '';
    $correo_empleado = (isset($_POST['correo_empleado'])) ? $_POST['correo_empleado'] : '';
    $telefono_empleado = (isset($_POST['telefono_empleado'])) ? $_POST['telefono_empleado'] : '';
    
    $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
    $id_empleado = (isset($_POST['id_empleado'])) ? $_POST['id_empleado'] : '';

    switch($opcion){
        // Insertar
        case 1:
            $status = 2;
            $consulta = "INSERT INTO empleados (nombre_empleado, correo_empleado, telefono_empleado, status) VALUES('$nombre_empleado', '$correo_empleado', '$telefono_empleado', '$status') ";			
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(); 
            
            $consulta = "SELECT * FROM empleados ORDER BY id_empleados DESC LIMIT 1";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);       
            break;   

        // Actualizar
        case 2:        
            $consulta = "UPDATE empleados SET nombre_empleado='$nombre_empleado', correo_empleado='$correo_empleado', telefono_empleado='$telefono_empleado' WHERE id_empleado='$id_empleado' ";		
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();        
            
            $consulta = "SELECT * FROM empleados WHERE id_empleado='$id_empleado' ";       
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            break;

        // Eliminar
        case 3:        
            $consulta = "DELETE FROM empleados WHERE id_empleado='$id_empleado' ";		
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();                           
            break;

        // Listar
        case 4:    
            $consulta = "SELECT * FROM empleados";
            $resultado = $conexion->prepare($consulta);
            $resultado->execute();        
            $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
            break;
    }

    print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
    $conexion=null;

?>