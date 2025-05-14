<?php
require_once 'funcionesSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ideagendas = $_POST['idE0'];
    $nombreA = $_POST['nom2']; 
    $desA = $_POST['des2']; 
    $fecha = $_POST['d100'];
    $hora = $_POST['h100']; 
    $tiempo = $_POST['hs10'];
    modificarDatos($ideagendas,$nombreA, $desA, $fecha, $hora, $tiempo);
}