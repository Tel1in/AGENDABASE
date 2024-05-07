<?php
require_once 'funcionesSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_expediente = $_POST['s1'];
    $numero = $_POST['s11'];
    $inputado = $_POST['s12'];
    $tipoAud = $_POST['s3'];
    $sala = $_POST['sala'];
    $juez = $_POST['juez'];
    $solicitante = $_POST['sol1'];
    $fecha = $_POST['d1'];
    $hora = $_POST['h1'];
    $evento = $_POST['evento'];
    insertar($nom_expediente, $numero, $inputado, $tipoAud, $sala, $juez, $solicitante, $fecha, $hora, $evento);
}
?>

