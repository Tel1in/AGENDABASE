<?php
require_once 'conexion.php';
require_once 'funcionesSql.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function verificarNIP($nip) {
    $conn = conexion();
    $nombreUsuario = verificarNIPEnBD($nip);

    if ($nombreUsuario) {
        $_SESSION['usuario'] = $nombreUsuario;
        return true;
    } else {
        echo "NIP incorrecto.";
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nip'])) {
    if (verificarNIP($_POST['nip'])) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'NIP incorrecto']);
    }
    exit;
}
?>