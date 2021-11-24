<?php

    include("./../db.php");

    $sql = $connection->prepare(
        "UPDATE platillos 
        SET mostrar_platillo = 1
        WHERE id_platillo = :id_platillo"
    );

    $result = $sql->execute(
        array(
            ':id_platillo' => $_POST['id_platillo']
        )
    );

?>