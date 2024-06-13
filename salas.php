<?php
include 'funcionesSql.php';
include 'sesion.php';

function obtenerHTMLSalas($usuario, $region) {
    $salasHTML = '';
    switch ($region) {
        case "TEPIC CRJP":
            $salasHTML = generarHTMLSalasTepic();
            break;
        case "TEPIC ADOL":
            $salasHTML = generarHTMLSalasAdolecentes();
            break;
        case "BAHIA BAHIA":
            $salasHTML = generarHTMLSalasBahia();
            break;
        case "TEPIC CJM":
            $salasHTML = generarHTMLSalasCJM();
            break;
        case "SANTIAGO SGO":
            $salasHTML = generarHTMLSalasSantiago();
            break;
        case "IXTLAN IXTLAN":
            $salasHTML = generarHTMLSalasIxtlan();
            break;
        case "TECUALA TEC":
            $salasHTML = generarHTMLSalasTecuala();
            break;
        case "SANPEDRO SP":
            $salasHTML = generarHTMLSalasSanPedro();
            break;
        default:
            $salasHTML = "No se encontró una región válida para el usuario.";
    }
    return $salasHTML;
}

function generarHTMLSalasTepic() {
    $html = '<div class="navbar" id="n0">
                <div class="container">
                    <P>SALAS TEPIC</P>
                    <H5>S1</H5>
                    <i class="bi bi-circle-fill" style="color:yellow;"></i>
                    <H5>S2</H5>
                    <i class="bi bi-circle-fill" style="color:red;"></i>
                    <H5>S3</H5>
                    <i class="bi bi-circle-fill" style="color:lightskyblue;"></i>
                    <H5>S4</H5>
                    <i class="bi bi-circle-fill" style="color:greenyellow;"></i>
                    <H5>S5</H5>
                    <i class="bi bi-circle-fill" style="color:pink;"></i>
                    <H5>SV 1</H5>
                    <i class="bi bi-circle-fill" style="color:blueviolet;"></i>
                    <H5>SV 2</H5>
                    <i class="bi bi-circle-fill" style="color:deepskyblue;"></i>
                    <H5>SV 3</H5>
                    <i class="bi bi-circle-fill" style="color:gray;"></i>
                    <H5>SV 4</H5>
                    <i class="bi bi-circle-fill" style="color:purple;"></i>
                    <H5>SV 16</H5>
                    <i class="bi bi-circle-fill" style="color:aquamarine;"></i>
                    <H5>SV 17</H5>
                    <i class="bi bi-circle-fill" style="color:chartreuse;"></i>
                    <H5>SV 18</H5>
                    <i class="bi bi-circle-fill" style="color:royalblue;"></i>
                    <H5>SV 19</H5>
                    <i class="bi bi-circle-fill" style="color:lightseagreen	;"></i>
                    <H5>SV 22</H5>
                    <i class="bi bi-circle-fill" style="color:fuchsia;"></i>
                    <H5>SV 23</H5>
                    <i class="bi bi-circle-fill" style="color:goldenrod;"></i>
                    <H5>SALA MOVIL</H5>
                    <i class="bi bi-circle-fill" style="color:firebrick;"></i>
                </div>               
            </div>';
    return $html;
}

// Función para generar el HTML de las salas de Adolecentes
function generarHTMLSalasAdolecentes() {
    $html = '<div class="navbar" id="n1">
                <div class="container">
                    <p>SALAS ADOLECENTES</p>
                    <H5>SALA ADOLECENTES</H5>
                    <i class="bi bi-circle-fill" style="color: yellow;"></i>
                    <H5>SALAV 5 ADOLECENTES</H5>
                    <i class="bi bi-circle-fill" style="color: red;"></i>
                    <H5>SALAV 15 ADOLECENTES</H5>
                    <i class="bi bi-circle-fill" style="color: lightskyblue;"></i>
                    <H5>SALA UAN</H5>
                    <i class="bi bi-circle-fill" style="color: blueviolet;"></i>
                </div>
            </div>';
    return $html;
}

// Función para generar el HTML de las salas de Bahía
function generarHTMLSalasBahia() {
    $html = '<div class="navbar" id="n2">
                <div class="container">
                    <P>SALAS BAHIA</P>
                    <H5>S1 BAHIA</H5>
                    <i class="bi bi-circle-fill" style="color: yellow;"></i>
                    <H5>S2 BAHIA</H5>
                    <i class="bi bi-circle-fill" style="color: red;"></i>
                    <H5>S10 BAHIA</H5>
                    <i class="bi bi-circle-fill" style="color: lightskyblue;"></i>
                    <H5>SV11 BAHIA</H5>
                    <i class="bi bi-circle-fill" style="color: greenyellow;"></i>
                    <H5>SV CJM BAHIA</H5>
                    <i class="bi bi-circle-fill" style="color: pink;"></i>
                    <H5>SV14 CJM BAHIA</H5>
                    <i class="bi bi-circle-fill" style="color: blueviolet;"></i>
                </div>
            </div>';
    return $html;
}

// Función para generar el HTML de las salas de CJM
function generarHTMLSalasCJM() {
    $html = '<div class="navbar" id="n3">
                <div class="container">
                    <P>SALAS CJM</P>
                    <H5>SALA DE MUJER TEPIC</H5>
                    <i class="bi bi-circle-fill" style="color: yellow;"></i>
                    <H5>SV13 CJM TEPIC</H5>
                    <i class="bi bi-circle-fill" style="color: red;"></i>
                    <H5>SALA EJECUCION</H5>
                    <i class="bi bi-circle-fill" style="color: lightskyblue;"></i>
                    <H5>SV20 CJM TEPIC</H5>
                    <i class="bi bi-circle-fill" style="color: greenyellow;"></i>
                </div>
            </div>';
    return $html;
}

// Función para generar el HTML de las salas de Santiago
function generarHTMLSalasSantiago() {
    $html = '<div class="navbar" id="n4">
                <div class="container">
                    <P>SALAS SANTIAGO</P>
                    <H5>SV6 SANTIAGO</H5>
                    <i class="bi bi-circle-fill" style="color: yellow;"></i>
                    <H5>SV12 SANITAGO</H5>
                    <i class="bi bi-circle-fill" style="color: blue;"></i>
                    <H5>SALA SANTIAGO</H5>
                    <i class="bi bi-circle-fill" style="color: red;"></i>
                </div>
            </div>';
    return $html;
}

// Función para generar el HTML de las salas de Ixtlán
function generarHTMLSalasIxtlan() {
    $html = '<div class="navbar" id="n5">
                <div class="container">
                    <P>SALAS IXTLAN</P>
                    <H5>SALA VIRTUAL 8 IXTLAN</H5>
                    <i class="bi bi-circle-fill" style="color: yellow;"></i>
                    <H5>SALA IXTLAN</H5>
                    <i class="bi bi-circle-fill" style="color: red;"></i>                </div>
            </div>';
    return $html;
}

// Función para generar el HTML de las salas de Tecuala
function generarHTMLSalasTecuala() {
    $html = '<div class="navbar" id="n6">
                <div class="container">
                    <P>SALAS TECUALA</P>
                    <H5>SALA VIRTUAL 7 TECUALA</H5>
                    <i class="bi bi-circle-fill" style="color: yellow;"></i>
                    <H5>SALA TECUALA</H5>
                    <i class="bi bi-circle-fill" style="color: red;"></i>
                </div>
            </div>';
    return $html;
}

// Función para generar el HTML de las salas de San Pedro
function generarHTMLSalasSanPedro() {
    $html = '<div class="navbar" id="n7">
                <div class="container">
                    <P>SALAS SAN PEDRO</P>
                    <H5>SALA VIRTUAL 8 SAN PEDRO</H5>
                    <i class="bi bi-circle-fill" style="color: yellow;"></i>
                    <H5>SALA SAN PEDRO</H5>
                    <i class="bi bi-circle-fill" style="color: red;"></i>
                    <H5>SALA MOVIL SP</H5>
                    <i class="bi bi-circle-fill" style="color: lightskyblue;"></i>
                </div>
            </div>';
    return $html;
}

function generarSala(){
    $usuario = $_SESSION['usuario'];
    $regionJuzgado = obtenerRegionUsuario($usuario);
    $salasHTML = obtenerHTMLSalas($usuario, $regionJuzgado);
    echo $salasHTML;
}

generarSala();
session_destroy();
?>