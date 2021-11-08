$(document).ready(function () {
    var id_empleado, opcion;
    opcion = 4;

    tablaUsuarios = $('#tablaUsuarios').DataTable({
        "ajax": {
            "url": "bd/crud.php",
            "method": 'POST', //usamos el metodo POST
            "data": { opcion: opcion }, //enviamos opcion 4 para que haga un SELECT
            "dataSrc": ""
        },

        "columns": [
            { "data": "id_empleado" },
            { "data": "nombre_empleado" },
            { "data": "correo_empleado" },
            { "data": "telefono_empleado" },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>" }
        ]
    });

    var fila; //captura la fila, para editar o eliminar

    //submit para el Alta y Actualización
    $('#formUsuarios').submit(function (e) {
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

        let nombre_empleado = $.trim($('#nombre_empleado').val());
        let correo_empleado = $.trim($('#correo_empleado').val());
        let telefono_empleado = $.trim($('#telefono_empleado').val());
        console.log(nombre_empleado);
        console.log(correo_empleado);
        console.log(telefono_empleado);

        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            datatype: "json",
            data: { id_empleado: id_empleado, nombre_empleado: nombre_empleado, correo_empleado: correo_empleado, telefono_empleado: telefono_empleado, opcion: opcion },

            success: function (data) {
                tablaUsuarios.ajax.reload(null, false);
            }
        });

        $('#modalCRUD').modal('hide');
    });

    //para limpiar los campos antes de dar de Alta una Persona
    $("#btnNuevo").click(function () {
        opcion = 1; //alta           
        id_empleado = null;

        $("#formUsuarios").trigger("reset");
        $(".modal-header").css("background-color", "#17a2b8");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Alta de Usuario");
        $('#modalCRUD').modal('show');
    });

    //Editar        
    $(document).on("click", ".btnEditar", function () {
        opcion = 2;//editar

        let fila = $(this).closest("tr");

        id_empleado = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
        let nombre_empleado = fila.find('td:eq(1)').text();
        let correo_empleado = fila.find('td:eq(2)').text();
        let telefono_empleado = fila.find('td:eq(3)').text();

        $("#nombre_empleado").val(nombre_empleado);
        $("#correo_empleado").val(correo_empleado);
        $("#telefono_empleado").val(telefono_empleado);

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Usuario");
        $('#modalCRUD').modal('show');
    });

    //Borrar
    $(document).on("click", ".btnBorrar", function () {
        let fila = $(this);

        id_empleado = parseInt($(this).closest('tr').find('td:eq(0)').text());
        nombre_empleado = ($(this).closest('tr').find('td:eq(1)').text());
        opcion = 3; //eliminar      

        var respuesta = confirm("¿Está seguro de borrar el registro de " + nombre_empleado + "?");
        if (respuesta) {
            $.ajax({
                url: "bd/crud.php",
                type: "POST",
                datatype: "json",
                data: { opcion: opcion, id_empleado: id_empleado },
                success: function () {
                    tablaUsuarios.row(fila.parents('tr')).remove().draw();
                }
            });
        }
    });

});    