<?php
include('db.php');
include('function.php');
$query = '';
$output = array();
$query .= "SELECT * FROM desayuno ";
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
	$query .= 'ORDER BY id_platillo DESC ';
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
	
	if($row["tipo_platillo"] == '0')
		$tipo = 'Plato fuerte';
	if($row["tipo_platillo"] == '1')	
		$tipo = 'Guarnicion';
	if($row["tipo_platillo"] == '2')	
		$tipo = 'Entrada';
	if($row["tipo_platillo"] == '3')	
		$tipo = 'Bebida';

	$sub_array[] = $tipo;
	$sub_array[] = '<div class="text-center"> <div class="btn-group"> <button type="button" name="update" id="'.$row["id_platillo"].'" class="btn btn-sm update"><i class="material-icons">edit</i></button><button type="button" name="delete" id="'.$row["id_platillo"].'" class="btn btn-sm delete"><i class="material-icons">delete</i></button> </div> </div>';
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