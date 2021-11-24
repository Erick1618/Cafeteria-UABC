<?php
    
    include("./../db.php");

    $precio = $_POST['precio'];

    $sql = $connection->prepare(
        "UPDATE menu_rotativo
        SET precio = :precio
        WHERE menu = :menu"
    );

    $result = $sql->execute(
        array(
            ':precio' => $precio,
            ':menu' => 'comida'
        )
    );


?>