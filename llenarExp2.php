<?php
require_once 'funcionesSql.php';

if (isset($_GET['id']) && isset($_GET['id_tipo_expediente'])) {
    $id = $_GET['id'];
    $id_tipo_expediente = $_GET['id_tipo_expediente'];
    $exp3 = expediente3($id, $id_tipo_expediente);
    foreach ($exp3 as $exp) {
        echo "<option value='" . $exp['idinvolucrado'] . "'>" . $exp['nombreInputado'] . "</option>";
    }
} else {
    echo "Error: No se proporcionó el ID o el tipo de expediente.";
}
?>