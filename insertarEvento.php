<?php
require_once 'funcionesSql.php';
require_once 'sesion.php';

$usuario = $_SESSION['usuario'];
$usuarioRegion = obtenerRegionYJuzgadoUsuario($usuario);
$region = $usuarioRegion["region"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_expediente = $_POST['s1'];
    $numero = $_POST['valorAInsertar'];
    $imputados = explode(',', $_POST['s12']); // Convertir la cadena en un arreglo
    $tipoAud = $_POST['s3'];
    $sala = $_POST['sala'];
    $juez = $_POST['juez'];
    $solicitante = $_POST['sol1'];
    $fecha = $_POST['d1'];
    $hora = $_POST['h1'];
    $regionI = $region; // se toma la region 
    insertar($nom_expediente, $numero, implode(',', $imputados), $tipoAud, $sala, $juez, $solicitante, $fecha, $hora, $regionI);
}
?>

