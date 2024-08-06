<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["cod_familiar"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nome_pess"]) . "</td>";
        echo "<td>"  . htmlspecialchars($row["status"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["data_atualizacao"]) . "</td>";
        echo "<td>
                <button class='icon-btn mais-btn' data-codfamiliar='{$row['cod_familiar']}'><i class='fas fa-plus'></i></button>
              </td>";
        echo "</tr>";
    }
} else {
    echo "Nenhum resultado encontrado";
}
?>