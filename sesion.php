<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuario = "Pepe";
$_SESSION['usuario'] = $usuario;
?>
