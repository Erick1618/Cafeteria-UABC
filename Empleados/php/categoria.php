<?php

    include("./../db.php");

    $sql = $connection->prepare(
        "UPDATE platillos 
        SET categoria_platillo = :categoria_platillo
        WHERE id_platillo = :id_platillo"
    );

    $result = $sql->execute(
        array(
            ':categoria_platillo' => $_POST['categoria_platillo'],
            ':id_platillo' => $_POST['id_platillo']
        )
    );

?>