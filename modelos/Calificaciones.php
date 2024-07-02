<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Calificaciones{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($val, $alumn_id, $block_id) {
    // Determinar el valor de estado en función de val
    $estado = ($val > 51) ? "APROBADO" : "REPROBADO";

    $sql = "INSERT INTO calification (val, estado, alumn_id, block_id) VALUES ('$val', '$estado', '$alumn_id', '$block_id')";
    return ejecutarConsulta($sql);
}
/*public function insertar($val,$Estado,$alumn_id,$block_id){
	
	$sql="INSERT INTO calification (val,Estado,alumn_id,block_id) VALUES ('$val','$Estado','$alumn_id','$block_id')";
	return ejecutarConsulta($sql);
}2*/

public function editar($id,$val,$alumn_id,$block_id){
	$estado = ($val > 51) ? "APROBADO" : "REPROBADO";
	$sql="UPDATE calification SET val='$val',estado ='$estado',alumn_id='$alumn_id',block_id='$block_id' 
	WHERE id='$id'";
	return ejecutarConsulta($sql);
}


public function verificar($alumn_id,$block_id){
	$sql="SELECT * FROM calification WHERE alumn_id='$alumn_id' AND block_id='$block_id'";
	return ejecutarConsultaSimpleFila($sql);
}

public function listar_calificacion($idalumno,$idcurso){
	$sql="SELECT * FROM calification WHERE alumn_id='$idalumno' AND block_id='$idcurso'";
		return ejecutarConsulta($sql);
}

public function desactivar($id){ 
	$sql="UPDATE calification SET condicion='0' WHERE id='$id'";
	return ejecutarConsulta($sql);
}
public function activar($id){
	$sql="UPDATE calification SET condicion='1' WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id){
	$sql="SELECT * FROM calification WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}
 
//listar registros
public function listar(){
	$sql="SELECT * FROM calification";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM calification WHERE condicion=1";
	return ejecutarConsulta($sql);
}
}

 ?>
