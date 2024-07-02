<?php
include 'funcionesSql.php';
session_start();
$usuario = $_SESSION['usuario'];

$datosUsuario = obtenerRegionYJuzgadoUsuario($usuario);
$relacionadoConJuez = juezRelacion($usuario);
$datosUsuario['relacionadoConJuez'] = $relacionadoConJuez;

header('Content-Type: application/json');
echo json_encode($datosUsuario);
?>