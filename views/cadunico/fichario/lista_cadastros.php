<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["cod_familiar_fam"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nom_pessoa"]) . "</td>";
        echo "<td> ATIVO </td>";
        echo "<td>" . htmlspecialchars($row["dat_atual_fam"]) . "</td>";
        echo "<td>
                <button class='icon-btn mais-btn' data-codfamiliar='{$row['cod_familiar_fam']}'><i class='fas fa-plus'></i></button>
              </td>";
        echo "</tr>";
    }
} else {
    echo "Nenhum resultado encontrado";
}
?>