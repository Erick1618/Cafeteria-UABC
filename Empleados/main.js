$(document).ready(function(){
	$('#add_button').click(function(){
		$('#user_form')[0].reset();
		$('.modal-title').text("Nuevo producto");
		$('#action').val("Add");
		$('#operation').val("Add");
		$('#user_uploaded_image').html('');
	});
	
	var dataTable = $('#user_data').DataTable({
		"processing":true,
		"serverSide":true,
		"order":[],
		"ajax":{
			url:"fetch.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[0, 5, 6],
				"orderable":false,
			},
		],

	});

	$(document).on('submit', '#user_form', function(event){
		event.preventDefault();

		$('#user_image').prop('required',true);

		var firstName = $('#first_name').val();
		var precio = $('#precio').val();
		var extension = $('#user_image').val().split('.').pop().toLowerCase();
		if(extension != '')
		{
			if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
			{
				alert("Tipo de imagen invalida, solo .gif, .png, .jpg y .jpeg");
				$('#user_image').val('');
				return false;
			}
		}	
		if(firstName != '' && precio != '' && categoria_platillo != 0) {

			if($('#action').val() == "Add") {
				if (confirm("¿Estas seguro de agregar este producto?")) {
					$.ajax({
						url:"insert.php",
						method:'POST',
						data:new FormData(this),
						contentType:false,
						processData:false,
						success:function(data)
						{
							alert(data);
							$('#user_form')[0].reset();
							$('#userModal').modal('hide');
							dataTable.ajax.reload();
						}
					});
				}
			}

			if($('#action').val() == "Edit") {
				if (confirm("¿Estas seguro de editar este producto?")) {
					$.ajax({
						url:"insert.php",
						method:'POST',
						data:new FormData(this),
						contentType:false,
						processData:false,
						success:function(data)
						{
							alert(data);
							$('#user_form')[0].reset();
							$('#userModal').modal('hide');
							dataTable.ajax.reload();
						}
					});
				}
			}
		}
		else
		{
			alert("Precio, Nombre y Categoria obligatorios");
		}
	});
	
	$(document).on('click', '.update', function(){
		var user_id = $(this).attr("id");
		$('#user_image').prop('required',false);

		$.ajax({
			url:"fetch_single.php",
			method:"POST",
			data:{user_id:user_id},
			dataType:"json",
			success:function(data)
			{
				//console.log(data);
				$('#userModal').modal('show');
				$('#first_name').val(data.first_name);
				$('#last_name').val(data.last_name);
				$('#precio').val(data.precio);
				$('#categoria_platillo').val(data.categoria_platillo);
				$('.modal-title').text("Editar producto");
				$('#user_id').val(user_id);
				$('#user_uploaded_image').html(data.user_image);
				$('#action').val("Edit");
				$('#operation').val("Edit");
			}
		})
	});
	
	$(document).on('click', '.delete', function(){
		var user_id = $(this).attr("id");
		if(confirm("¿Seguro que desea eliminar este producto?"))
		{
			$.ajax({
				url:"delete.php",
				method:"POST",
				data:{user_id:user_id},
				success:function(data)
				{
					alert(data);
					dataTable.ajax.reload();
				}
			});
		}
		else
		{
			return false;	
		}
	});	
});