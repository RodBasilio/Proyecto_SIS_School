<?php 
require_once "../modelos/Grupos.php";
if (strlen(session_id())<1) 
	session_start();

$grupos = new Grupos();

$idgrupo=isset($_POST["idgrupo"])? limpiarCadena($_POST["idgrupo"]):"";
$idusuario=$_SESSION["idusuario"];
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$favorito=isset($_POST["favorito"])? 1 :0;


switch ($_GET["op"]) {
	case 'guardaryeditar':
		$idusuario = isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]) : "";
		if (empty($idgrupo)) {
		  $rspta = $grupos->insertar($nombre, $favorito, $idusuario);
		  echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		} else {
		  $rspta = $grupos->editar($idgrupo, $nombre, $favorito, $idusuario);
		  if ($rspta) {
			// Seleccionar alumn_id de todos los alumnos que coinciden con team_id del grupo cambiado
			$sql_select = "SELECT alumn_id FROM alumn_team WHERE team_id = '$idgrupo'";
			$result = ejecutarConsulta($sql_select);
			while ($row = $result->fetch_assoc()) {
			  $alumn_id = $row['alumn_id'];
			  // Cambiar user_id de los alumnos que tienen alumn_id seleccionado
			  $sql_update = "UPDATE alumn SET user_id = '$idusuario' WHERE id = '$alumn_id'";
			  ejecutarConsulta($sql_update);
			}
		  }
		  echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
		break;
	  
	  


    case 'eliminar':
        $rspta = $grupos->eliminar($idgrupo);
        echo $rspta ? "Grupo eliminado correctamente" : "No se pudo eliminar el grupo";
        break;

	case 'anular':
		$rspta=$grupos->anular($idgrupo);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$grupos->mostrar($idgrupo);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$grupos->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
                

			$data[]=array(

			"0"=>'
			<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idgrupo.')"><i class="fa fa-pencil"></i></button>'.' '.'
			<button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idgrupo.')"><i class="fa fa-close"></i></button>',
            "1"=>$reg->nombre,
            "2"=>$reg->usuario
              );
		}
		$results=array( 
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break; 
		// Agregar esta nueva opción al switch para listar usuarios
		case 'listar_usuarios':
			$usuarios = $grupos->listarUsuarios(); // Agrega un método en la clase Grupos para listar usuarios disponibles
			$select = '<option value="">Seleccione un usuario</option>';
			while ($reg = $usuarios->fetch_object()) {
			$select .= '<option value="' . $reg->idusuario . '">' . $reg->nombre . '</option>';
			}
			echo $select;
			break;
  

}
 ?> 