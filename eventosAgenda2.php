<?php
require_once 'funcionesSql.php';

$eventos = obtenerDatos4();
echo json_encode($eventos);
?>