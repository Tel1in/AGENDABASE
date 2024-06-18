<?php
require_once 'funcionesSql.php';
require_once 'sesion.php';

$usuario = $_SESSION['usuario'];
$usuarioRegion = obtenerRegionYJuzgadoUsuario($usuario);
$regionEA = $usuarioRegion["region"];

$eventos = obtenerDatos4($regionEA);
echo json_encode($eventos);
?>