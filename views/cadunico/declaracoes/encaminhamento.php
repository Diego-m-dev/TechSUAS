<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Texto de Encaminhamento</title>
</head>
<body>
    <h1>Gerar Encaminhamento</h1>
    <textarea id="inputText" rows="4" cols="50" placeholder="Digite seu texto aqui..."></textarea><br>
    <button onclick="melhorarTexto()">Melhorar Texto</button>
    <h2>Texto Melhorado</h2>
    <p id="melhoradoText"></p>

    <script>
        async function melhorarTexto() {
            const inputText = document.getElementById('inputText').value;
            const response = await fetch('/melhorar-texto', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ text: inputText })
            });
            const data = await response.json();
            document.getElementById('melhoradoText').innerText = data.melhoradoText;
        }
    </script>
</body>
</html>
