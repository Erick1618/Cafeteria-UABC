<?php
include('db.php');
include('function.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM comida
		WHERE id_platillo = '".$_POST["user_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["first_name"] = $row["nombre_platillo"];
		$output["last_name"] = $row["descripcion_platillo"];
		$output["tipo"] = $row["tipo_platillo"];
		if($row["foto_platillo"] != '')
		{
			$output['user_image'] = '<img src="upload/'.$row["foto_platillo"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_user_image" value="'.$row["foto_platillo"].'" />';
		}
		else
		{
			$output['user_image'] = '<input type="hidden" name="hidden_user_image" value="" />';
		}
	}
	echo json_encode($output);
}
?>