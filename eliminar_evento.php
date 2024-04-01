<?php
require_once 'funcionesSql.php';

if(isset($_GET['id_evento_agenda'])) {
    $id_evento_agenda = $_GET['id_evento_agenda'];

    $response = eliminarDatos($id_evento_agenda);
    
    echo $response;
} else {
    echo "Error: No se proporcionó el identificador del evento.";
}
?>