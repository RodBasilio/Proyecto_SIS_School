<?php
require '../modelos/modelo_grafico.php';

// Verificar si se recibió el nombre del bloque desde la solicitud AJAX
if (isset($_POST['nombreBloque'])) {
    $nombreBloque = $_POST['nombreBloque'];
    $MG = new Modelo_Grafico();
    
    // Pasar el nombre del bloque como parámetro a la función TraerDatosGraficosBar
    $consulta = $MG->TraerDatosGraficosBar($nombreBloque);

    echo json_encode($consulta);
} else {
    echo "Error: Nombre de bloque no proporcionado en la solicitud.";
}
?>