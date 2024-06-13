<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuario = "sinuso";
$_SESSION['usuario'] = $usuario;
?>
