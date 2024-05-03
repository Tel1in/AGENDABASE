<?php
require_once 'funcionesSql.php';

if (isset($_GET['id_tipo_expediente'])) {
    $id_tipo_expediente = $_GET['id_tipo_expediente'];
    $exp2 = expediente2($id_tipo_expediente);

    echo "<option value='' selected disabled>Seleccione</option>";

    foreach ($exp2 as $exp) {
        echo "<option value='" . $exp['valor1'] . "'>" . $exp['valor2'] . "</option>";
    }
} else {
    echo "Error: No se proporcionó el tipo de expediente.";
}
?> 