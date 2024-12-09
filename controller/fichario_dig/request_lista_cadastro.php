<?php
 include $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
 include $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/models/cadunico/model_request.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consulta = $_POST['consulta'];

    $model = new ConsultaModel($conn);
    $result = $model->consultarFamilia($consulta);

    include $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/views/cadunico/fichario/lista_cadastros.php';

    $conn->close();
}

