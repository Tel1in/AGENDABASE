<?php
require_once 'funcionesSql.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['modal']) && $_POST['modal'] == '1') {
        $id_evento_agenda = $_POST['idE'];
        $tipoAud = $_POST['s30'];
        $sala = $_POST['sala1'];
        $juez = $_POST['juez1'];
        $solicitante = $_POST['sol11'];
        $fecha = $_POST['d10'];
        $hora = $_POST['h10'];
        modificarDatos($id_evento_agenda, $tipoAud, $sala, $juez, $solicitante, $fecha, $hora);
    } 

    else if (isset($_POST['modal']) && $_POST['modal'] == '2') {
        $id_evento_agenda = $_POST['idE0'];
        $tipoAud = $_POST['s300']; 
        $sala = $_POST['sala10']; 
        $juez = $_POST['juez10']; 
        $solicitante = $_POST['sol111'];
        $fecha = $_POST['d100'];
        $hora = $_POST['h100']; 
        modificarDatos($id_evento_agenda, $tipoAud, $sala, $juez, $solicitante, $fecha, $hora);
    }
}