<?php
require_once 'funcionesSql.php';
require_once 'sesion.php';

$usuario = $_SESSION['usuario'];
$eventos = obtenerDatos4($usuario);
echo json_encode($eventos);
?>