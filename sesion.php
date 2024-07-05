<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuario = "inhabilitada";
$_SESSION['usuario'] = $usuario;
?>
