var tabla;

// Agregar esta función para cargar la lista de usuarios
function cargarUsuarios() {
  $.post("../ajax/grupos.php?op=listar_usuarios", function (data) {
    $("#idusuario").html(data);
  });
}

// Modificar la función mostrar(idgrupo) para cargar y seleccionar el usuario asociado
function mostrar(idgrupo) {
  $.post("../ajax/grupos.php?op=mostrar", { idgrupo: idgrupo }, function (data) {
    data = JSON.parse(data);
    mostrarform(true);

    $("#nombre").val(data.nombre);
    if (data.favorito == 1) {
      $("#favorito").prop('checked', true);
    } else {
      $("#favorito").prop('checked', false);
    }
    // Cargar la lista de usuarios y seleccionar el usuario asociado
    cargarUsuarios();
    $("#idusuario").val(data.idusuario);
    $("#idgrupo").val(data.idgrupo);
  });
}

// Modificar la función init() para cargar la lista de usuarios al iniciar la página
function init() {
  mostrarform(false);
  cargarUsuarios(); // Cargar la lista de usuarios al iniciar
  listar();

  $("#formulario").on("submit", function (e) {
    guardaryeditar(e);
  });
}

//funcion limpiar
function limpiar(){
	$("#idgrupo").val("");
	$("#nombre").val("");
	$("#favorito").val(""); 
}
 
//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdf'
		],
		"ajax":
		{
			url:'../ajax/grupos.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":10,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../ajax/grupos.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		bootbox.alert(datos);
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

function mostrar(idgrupo){
	$.post("../ajax/grupos.php?op=mostrar",{idgrupo : idgrupo},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#nombre").val(data.nombre);
			if (data.favorito==1) {
				$("#favorito").prop('checked', true);
			}else{
				$("#favorito").prop('checked', false);
			}
			$("#idgrupo").val(data.idgrupo);
		})
}

function eliminar(idgrupo) {
  bootbox.confirm("¿Está seguro de eliminar este grupo?", function (result) {
    if (result) {
      $.post("../ajax/grupos.php?op=eliminar", { idgrupo: idgrupo }, function (e) {
        bootbox.alert(e);
        tabla.ajax.reload();
      });
    }
  });
}

//funcion para desactivar
function desactivar(idgrupo){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../ajax/grupos.php?op=desactivar", {idgrupo : idgrupo}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idgrupo){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../ajax/grupos.php?op=activar" , {idgrupo : idgrupo}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();