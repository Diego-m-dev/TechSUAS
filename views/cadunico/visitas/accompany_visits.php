<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
if ($_SESSION['funcao'] != '1') {
    echo '<script>window.history.back()</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Visitas</title>
</head>
<body>
    <h1>CONTROLE DE VISITAS</h1>

    <div class="filters-container">
        <label for="codigoFamiliar">Código Familiar</label>
        <input type="text" id="codigoFamiliar">
        
        <div class="date-container">
            <label for="dateFilter">Data:</label>
            <input type="date" id="dateFilter">
        </div>

        <label for="statusFilter">Status:</label>
        <select id="statusFilter">
            <option value="">Todos</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>

        <label for="nameFilter">Nome do Entrevistador:</label>
        <input type="text" id="nameFilter">

        <label for="startDateFilter">Data Início:</label>
        <input type="date" id="startDateFilter">

        <label for="endDateFilter">Data Fim:</label>
        <input type="date" id="endDateFilter">

        <button onclick="filterData()">Filtrar</button>
    </div>
    
    <!-- Tabela para exibir os dados -->
    <table border="1">
        <thead>
            <tr>
                <th>Código</th>
                <th>Data</th>
                <th>Status</th>
                <th>Nome</th>
            </tr>
        </thead>
        <tbody id="dataBody">
        </tbody>
    </table>

    <?php
    $sql_acomp_visit = "SELECT cod_fam, data, acao, entrevistador FROM visitas_feitas";
    $sql_query_acomp_visit = $conn->query($sql_acomp_visit);

    if (!$sql_query_acomp_visit) {
        die("ERRO na consulta: " . $conn->error);
    }

    $dados = $sql_query_acomp_visit->fetch_all(MYSQLI_NUM);
    $conn->close();
    ?>

    <script>
        // Passar dados do PHP para JavaScript
        const data = <?php echo json_encode($dados); ?>;

        function renderTable(filteredData) {
            const tableBody = document.getElementById('dataBody');
            tableBody.innerHTML = '';
            filteredData.forEach(row => {
                const tr = document.createElement('tr');
                for (let i = 0; i < 4; i++) {
                    const td = document.createElement('td');
                    td.textContent = row[i];
                    tr.appendChild(td);
                }
                tableBody.appendChild(tr);
            });
        }

        function filterData() {
            const nameFilter = document.getElementById('nameFilter').value.toLowerCase();
            const startDateFilter = document.getElementById('startDateFilter').value;
            const endDateFilter = document.getElementById('endDateFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const codigoFamiliar = document.getElementById('codigoFamiliar').value;

            const filteredData = data.filter(row => {
                const nameMatches = nameFilter ? row[3].toLowerCase().includes(nameFilter) : true;
                const dateMatches = startDateFilter && endDateFilter 
                    ? (row[1] >= startDateFilter && row[1] <= endDateFilter) 
                    : true;
                const statusMatches = statusFilter ? row[2] == statusFilter : true;
                const codigoFamiliarMatches = codigoFamiliar ? row[0] == codigoFamiliar : true;

                return nameMatches && dateMatches && statusMatches && codigoFamiliarMatches;
            });

            renderTable(filteredData);
        }

        // Render the full table initially
        renderTable(data);
    </script>
</body>
</html>
