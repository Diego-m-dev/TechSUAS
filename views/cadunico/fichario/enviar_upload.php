<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Familiar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 1.8em;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 15px;
        }
        button:hover {
            background-color: #45a049;
        }
        .file-label {
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 4px;
        }
        .file-label:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro Familiar</h1>
        <form id="cadastroForm">
            <label for="codigoFamiliar">Código Familiar</label>
            <input type="text" id="codigoFamiliar" name="codigoFamiliar" maxlength="11" placeholder="Digite o código familiar" required>

            <label for="dataEntrevista">Data da Entrevista</label>
            <input type="date" id="dataEntrevista" name="dataEntrevista" required>

            <label for="situacaoBeneficio">Situação do Benefício</label>
            <select id="situacaoBeneficio" name="situacaoBeneficio" required>
                <option value="">Selecione</option>
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>

            <label for="observacoes">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="5" placeholder="Adicione observações..."></textarea>

            <label for="arquivo" class="file-label">Selecione um arquivo</label>
            <input type="file" id="arquivo" name="arquivo" accept=".pdf,.jpg,.png" style="display: none;">
            <p id="nomeArquivo">Nenhum arquivo selecionado</p>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const codigoFamiliar = document.getElementById("codigoFamiliar");
            const arquivoInput = document.getElementById("arquivo");
            const nomeArquivo = document.getElementById("nomeArquivo");

            // Permitir apenas números no Código Familiar
            codigoFamiliar.addEventListener("input", () => {
                codigoFamiliar.value = codigoFamiliar.value.replace(/\D/g, "");
            });

            // Exibir o nome do arquivo selecionado
            arquivoInput.addEventListener("change", () => {
                nomeArquivo.textContent = arquivoInput.files.length > 0 
                    ? arquivoInput.files[0].name 
                    : "Nenhum arquivo selecionado";
            });
        });
    </script>
</body>
</html>
