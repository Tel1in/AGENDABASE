<?php
require_once 'funcionesSql.php';
require_once 'sesion.php';

$usuarioA = $_SESSION['usuario'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreA = $_POST['nom'];
    $desA = $_POST['des'];
    $fecha = $_POST['d1'];
    $hora = $_POST['h1'];
    $tiempo = $_POST['hs1'];
    $user = $usuarioA;
    insertar($nombreA, $desA, $fecha, $hora, $tiempo ,$user);
}
?>

