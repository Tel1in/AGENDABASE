<?php
include 'funcionesSql.php';

if (isset($_POST['ideagendas'])) {
    $ideagendas = $_POST['ideagendas'];
    $datosEvento = obtenerDatos2($ideagendas);
    echo json_encode($datosEvento);
} else {
    echo "No se recibió el ID del evento.";
}
?>

