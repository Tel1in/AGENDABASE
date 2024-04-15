<?php
include 'funcionesSql.php';

if (isset($_POST['id_evento_agenda'])) {
    $id_evento_agenda = $_POST['id_evento_agenda'];
    $datosEvento = obtenerDatos2($id_evento_agenda);
    echo json_encode($datosEvento);
} else {
    echo "No se recibió el ID del evento.";
}
?>

