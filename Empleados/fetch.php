<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM platillos ";
if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE nombre_platillo LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR descripcion_platillo LIKE "%'.$_POST["search"]["value"].'%" ';
}
if(isset($_POST["order"]))
{
$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
$query .= 'ORDER BY nombre_platillo DESC ';
}
if($_POST["length"] != -1)
{
$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	$image = '';
	if($row["foto_platillo"] != '')
	{
		$image = '<img src="upload/'.$row["foto_platillo"].'" class="img-thumbnail" width="50" height="35" />';
	}
	else
	{
		$image = '';
	}
	$sub_array = array();
	$sub_array[] = $image;
	$sub_array[] = $row["nombre_platillo"];
	$sub_array[] = $row["descripcion_platillo"];

	if ($row["categoria_platillo"] == 1)
		$categoria = "Extras";
	if ($row["categoria_platillo"] == 2)
		$categoria = "Bebidas";
	if ($row["categoria_platillo"] == 3)
		$categoria = "Sandwiches";
	if ($row["categoria_platillo"] == 4)
		$categoria = "Desayunos";
	if ($row["categoria_platillo"] == 5)
		$categoria = "Burritos";

	$sub_array[] = $categoria;
	$sub_array[] = "$" . $row["precio_platillo"] . ".00";
	$sub_array[] = '<div class="text-center"> <div class="btn-group"> <button type="button" name="update" id="'.$row["id_platillo"].'" class="btn btn-sm update"><i class="material-icons">edit</i></button><button type="button" name="delete" id="'.$row["id_platillo"].'" class="btn btn-sm delete"><i class="material-icons">delete</i></button> </div> </div>';

	if ($row["mostrar_platillo"] == 1)
		$sub_array[] = '<div class="text-center"> <div class="btn-group"><button onclick="ocultar(' . $row["id_platillo"] . ');"> <img src="./assets/img/eye-solid.jpg" width="25px" height="20px"> </button></div> </div>';
	if ($row["mostrar_platillo"] == 0)
		$sub_array[] = '<div class="text-center"> <div class="btn-group"><button onclick="mostrar(' . $row["id_platillo"] . ');"> <img src="./assets/img/eye-slash-solid.jpg" width="25px" height="20px"> </button></div> </div>';

	$data[] = $sub_array;
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records(),
	"data"				=>	$data
);
echo json_encode($output);
?>
