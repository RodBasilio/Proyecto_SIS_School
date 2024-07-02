<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
//require __DIR__ . "/../config/Conexion.php"; //agregado para phpunit

class Conducta{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
	public function insertar($kind_id, $date_at, $alumn_id, $team_id,$comments){
	$sql = "INSERT INTO behavior (kind_id, date_at, alumn_id, team_id, comments) VALUES ('$kind_id', '$date_at', '$alumn_id', '$team_id', '$comments')";
	return ejecutarConsulta($sql);
}

	public function editar($id, $kind_id, $date_at, $alumn_id, $team_id,$comments){
	$sql = "UPDATE behavior SET kind_id='$kind_id', date_at='$date_at', alumn_id='$alumn_id', team_id='$team_id', comments='$comments' WHERE id='$id'";
	return ejecutarConsulta($sql);
}


public function verificar($date_at,$alumn_id,$team_id){
	$sql="SELECT * FROM behavior WHERE date_at='$date_at' AND alumn_id='$alumn_id' AND team_id='$team_id'";
	return ejecutarConsultaSimpleFila($sql);
}

public function desactivar($id){
	$sql="UPDATE behavior SET condicion='0' WHERE id='$id'";
	return ejecutarConsulta($sql);
}
public function activar($id){
	$sql="UPDATE behavior SET condicion='1' WHERE id='$id'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id){
	$sql="SELECT * FROM behavior WHERE id='$id'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM behavior";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM behavior WHERE condicion=1";
	return ejecutarConsulta($sql);
}
}

 ?>
