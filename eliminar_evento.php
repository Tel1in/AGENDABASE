<?php
require_once 'funcionesSql.php';

if(isset($_GET['ideagendas'])) {
    $ideagendas = $_GET['ideagendas'];

    $response = eliminarDatos($ideagendas);
    
    echo $response;
} else {
    echo "Error: No se proporcionó el identificador del evento.";
}
?>