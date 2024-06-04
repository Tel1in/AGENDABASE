<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuario = "an";
$_SESSION['usuario'] = $usuario;
?>
