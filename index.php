<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$sesionActiva = isset($_SESSION['usuario']);

if ($sesionActiva) {
    header('Location: agenda.php');
    exit;
} else {
    include 'nip.php';
}
?>