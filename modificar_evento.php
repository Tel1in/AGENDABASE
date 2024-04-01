<?php
require_once 'funcionesSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_evento_agenda = $_POST['idE'];
    $tipoAud = $_POST['s30'];
    $sala = $_POST['sala1'];
    $juez = $_POST['juez1'];
    $fecha = $_POST['d10'];
    $hora = $_POST['h10'];
    $evento = $_POST['evento1'];
    modificarDatos($id_evento_agenda, $tipoAud, $sala, $juez, $fecha, $hora, $evento);
}
?>

