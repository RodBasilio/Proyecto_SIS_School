<?php
        class Modelo_Grafico
        {
            private $conexion2;
            function __construct(){
                require_once("../config/conexionG.php");
                $this->conexion2 = new conexionG();
                $this->conexion2->conectarG();
            }
            
            function TraerDatosGraficosES($nombreBloque)
            {
                $sql = "SELECT 
                SUM(CASE WHEN C.Estado = 'APROBADO' THEN 1 ELSE 0 END) AS Aprobados,
                SUM(CASE WHEN C.Estado = 'REPROBADO' THEN 1 ELSE 0 END) AS Reprobados
            FROM team AS T
            LEFT JOIN block AS B ON T.idgrupo = B.team_id
            LEFT JOIN calification AS C ON B.id = C.block_id
            WHERE T.nombre = '$nombreBloque';";

                $arreglo = array();

                if ($consulta = $this->conexion2->obtenerConexion()->query($sql)) {
                    while ($consulta_VU = mysqli_fetch_array($consulta)) {
                        $arreglo[] = $consulta_VU;
                    }

                    return $arreglo;
                    $this->conexion2->cerrar();
                    }
            }
            

            function TraerDatosGraficosBar($nombreBloque)
            {

                $sql = "SELECT c.val AS Calificacion, a.name AS NombreAlumno, b.name AS NombreMateria
                FROM calification c
                INNER JOIN alumn a ON c.alumn_id = a.id
                INNER JOIN block b ON c.block_id = b.id
                WHERE b.name = '$nombreBloque';";

                $arreglo = array();

                if ($consulta = $this->conexion2->obtenerConexion()->query($sql)) {
                    while ($consulta_VU = mysqli_fetch_array($consulta)) {
                        $arreglo[] = $consulta_VU;
                    }

                    return $arreglo;
                    $this->conexion2->cerrar();
                    }
            

            }
        public function Materias() {
            // Realizar una consulta para obtener los nombres de los bloques
$sql = "SELECT name FROM block";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    echo '<select id="nombreBloque" class="form-control">';
    echo '<option value="" disabled selected>Seleccione una materia</option>'; // Opción predeterminada
    while ($fila = $resultado->fetch_assoc()) {
        echo '<option value="' . $fila["name"] . '">' . $fila["name"] . '</option>';
    }
    echo '</select>';
} else {
    echo 'No se encontraron registros.';
}

// Cerrar la conexión a la base de datos
$conexion->close();
        }

            

        }


?>