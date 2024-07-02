<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuario = "Yoana";
$_SESSION['usuario'] = $usuario;
?>
