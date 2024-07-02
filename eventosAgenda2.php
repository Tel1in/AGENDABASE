<?php
require_once 'funcionesSql.php';
require_once 'sesion.php';

$usuario = $_SESSION['usuario'];
$usuarioRegion = obtenerRegionYJuzgadoUsuario($usuario);
$regionEA = $usuarioRegion["region"];
$tipoEA = $usuarioRegion["tipo"];

$eventos = obtenerDatos4($regionEA, $usuario, $tipoEA);
echo json_encode($eventos);
?>