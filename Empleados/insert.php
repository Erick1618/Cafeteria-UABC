<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$image = '';
		$categortia = 0;
		$mostrar = 0;
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		$statement = $connection->prepare("
			INSERT INTO platillos (nombre_platillo, descripcion_platillo, precio_platillo, categoria_platillo, foto_platillo, mostrar_platillo) 
			VALUES (:first_name, :last_name, :precio, :categoria, :image, :mostrar)
		");
		$result = $statement->execute(
			array(
				':first_name'	=>	$_POST["first_name"],
				':last_name'	=>	$_POST["last_name"],
				':precio'	=>	$_POST["precio"],
				':categoria'	=>	$_POST["categoria_platillo"],
				':image'		=>	$image,
				':mostrar'		=>	$mostrar
			)
		);
		if(!empty($result))
		{
			echo 'Platillo creado';
		}
	}
	if($_POST["operation"] == "Edit")
	{
		$image = '';
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		else
		{
			$image = $_POST["hidden_user_image"];
		}
		$statement = $connection->prepare(
			"UPDATE platillos 
			SET nombre_platillo = :first_name, descripcion_platillo = :last_name, precio_platillo = :precio, categoria_platillo = :categoria_platillo, foto_platillo = :image  
			WHERE id_platillo = :id
			"
		);
		$result = $statement->execute(
			array(
				':first_name'	=>	$_POST["first_name"],
				':last_name'	=>	$_POST["last_name"],
				':precio'	=>	$_POST["precio"],
				':categoria_platillo'	=>	$_POST["categoria_platillo"],
				':image'		=>	$image,
				':id'			=>	$_POST["user_id"]
			)
		);
		if(!empty($result))
		{
			echo 'Platillo actualizado';
		}
	}
}

?>