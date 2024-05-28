<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuario = "raquel";
$_SESSION['usuario'] = $usuario;
?>
