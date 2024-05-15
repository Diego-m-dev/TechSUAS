<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <title>Apostilamento</title>
</head>

<body>
    <div class="img">
        <h1 class="titulo-com-imagem">
            <img src="apostilamento.svg" alt="Titulocomimagem">
        </h1>
    </div>
    <div class="container">

        <form action="salvar_pedido.php" method="post">
            <div>
                <label for="num_contrato">NUMERO DO CONTRATO:</label>
                <input type="text" id="numero_contrato" name="numero_contrato">
                <br>
                <label for="nome_contrato">NOME DO FORNECEDOR:</label>
                <input type="text" id="fornecedor" name="fornecedor">
            </div>
            <div>
                <label for="valor">VALOR TOTAL A SER APOSTILADO:</label>
                <input type="text" id="valor_total" name="valor">
            </div>
            <div class="anular">
                <label for="local">ANULAR DA DOTAÇÃO:</label>
                <input type="text" id="valor_anular" name="valor">
                <select>
                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos">
                        <option value="Recurso Próprio-368.13002.801-1.56-4.4.90.52">Recurso Próprio</option>
                        <option value="Recursos FNAS-410.13002.802.-1.74-4.4.90.52">Recursos FNAS</option>
                        <option value="Recursos Próprios-408.13002.802.-1.74-4.4.90.52">Recursos Próprios</option>
                    </optgroup>

                    <optgroup label="Manutenção da Assistência Social">
                        <option value="Material de Consumo (Recursos Próprios)-376.13002.801.-2.101-3.3.90.30">Material de Consumo (Recursos Próprios)</option>
                        <option value="Serviço de PJ (Recursos Próprios)-376.13002.801.-2.101-3.3.90.39">Serviço de PJ (Recursos Próprios)</option>
                        <option value="Serviço de PF (Recursos Próprios)-376.13002.801.-2.101-3.3.90.36">Serviço de PF (Recursos Próprios)</option>
                    </optgroup>

                    <optgroup label="Benefícios Eventuais">
                        <option value="Recursos Próprios-386.13002.803-2.161-3.3.90.32">Recursos Próprios</option>
                        <option value="Recursos do FEAS-387.13002.803-2.161-3.3.90.32">Recursos do FEAS</option>
                        <option value="Recursos Próprios-616.13002.801-2.192.3.3.90.39">Recursos Próprios</option>
                    </optgroup>

                    <optgroup label="Manutenção do Conselho Tutelar">
                        <option value="Material de Consumo (Recursos Próprios)-388.13002.801-2.74-3.3.90.30">Material de Consumo (Recursos Próprios)</option>
                        <option value="Serviço de PJ (Recursos Próprios)-388.13002.801-2.74-3.3.90.39">Serviço de PJ (Recursos Próprios)</option>
                        <option value="Serviço de PF (Recursos Próprios)-388.13002.801-2.74-3.3.90.36">Serviço de PF (Recursos Próprios)</option>
                    </optgroup>

                    <optgroup label="Manutenção do SCFV – Serviço de Convivência">
                        <option value="Material de Consumo (Recursos FNAS)-402.13002.802.-2.118-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-402.13002.802.-2.118-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-402.13002.802.-2.118-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Manutenção Abrigo Institucional">
                        <option value="Material de Consumo (Recursos FMAS)-405.13002.804-2.183.3.3.90.30">Material de Consumo (Recursos FMAS)</option>
                        <option value="Material de Consumo (Recursos FEAS)-407.13002.804-2.183.3.3.90.30">Material de Consumo (Recursos FEAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-405.13002.804-2.183.3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FEAS)-407.13002.804-2.183-3.3.90.39">Serviço de PJ (Recursos FEAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-405.13002.804-2.183.3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FEAS)-407.13002.804-2.183-3.3.90.36">Serviço de PF (Recursos FEAS)</option>
                    </optgroup>

                    <optgroup label="Manutenção Criança Feliz – Primeira Infância no SUAS">
                        <option value="Material de Consumo (Recursos FNAS)-683.13002.805.-2.224-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-683.13002.805.-2.224-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-683.13002.805.-2.224-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao CRAS/PAIF/SCFV e outros">
                        <option value="Recursos FNAS-410.13002.802.-1.74-4.4.90.52">Recursos FNAS</option>
                        <option value="Recursos Próprios-408.13002.802.-1.74-4.4.90.52">Recursos Próprios</option>
                    </optgroup>

                    <optgroup label="Manutenção do CRAS/PAIF">
                        <option value="Material de Consumo (Recursos FNAS)-423.13002.802.-2.112-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Material de Consumo (Recursos FEAS)-424.13002.802.-2.112-3.3.90.30">Material de Consumo (Recursos FEAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-423.13002.802.-2.112-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FEAS)-424.13002.802.-2.112-3.3.90.39">Serviço de PJ (Recursos FEAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-423.13002.802.-2.112-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FEAS)-424.13002.802.-2.112-3.3.90.36">Serviço de PF (Recursos FEAS)</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao CREAS/ABRIGO">
                        <option value="Recursos FNAS-631.13002.803-1.143-4.4.90.52">Recursos FNAS</option>
                    </optgroup>

                    <optgroup label="Manutenção do CREAS/PAEFI">
                        <option value="Material de Consumo (Recursos FNAS)-441.13002.803-2.121-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-441.13002.803-2.121-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-441.13002.803-2.121-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao Criança Feliz">
                        <option value="Recursos FNAS-635.13002.805-1.144-4.4.90.52">Recursos FNAS</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao IGD">
                        <option value="Recursos FNAS-448.13002.806-1.62-4.4.90.52">Recursos FNAS</option>
                    </optgroup>

                    <optgroup label="Manutenção do Bolsa Família – IGD">
                        <option value="Material de Consumo (Recursos FNAS)-449.13002.806-2.102-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-449.13002.806-2.102-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-449.13002.806-2.102-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Manutenção Segurança Alimentar e Nutricional">
                        <option value="Material de Consumo (Recursos FNAS)-466.13002.810-2.116-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-466.13002.810-2.116-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-466.13002.810-2.116-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>
                </select>

            </div>
            <div class="suplementar">
                <label for="local">PARA SUPLEMENTAR A DOTAÇÃO:</label>
                <input type="text" id="valor_suplementar" name="valor">
                <select>
                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos">
                        <option value="Recurso Próprio-368.13002.801-1.56-4.4.90.52">Recurso Próprio</option>
                        <option value="Recursos FNAS-410.13002.802.-1.74-4.4.90.52">Recursos FNAS</option>
                        <option value="Recursos Próprios-408.13002.802.-1.74-4.4.90.52">Recursos Próprios</option>
                    </optgroup>

                    <optgroup label="Manutenção da Assistência Social">
                        <option value="Material de Consumo (Recursos Próprios)-376.13002.801.-2.101-3.3.90.30">Material de Consumo (Recursos Próprios)</option>
                        <option value="Serviço de PJ (Recursos Próprios)-376.13002.801.-2.101-3.3.90.39">Serviço de PJ (Recursos Próprios)</option>
                        <option value="Serviço de PF (Recursos Próprios)-376.13002.801.-2.101-3.3.90.36">Serviço de PF (Recursos Próprios)</option>
                    </optgroup>

                    <optgroup label="Benefícios Eventuais">
                        <option value="Recursos Próprios-386.13002.803-2.161-3.3.90.32">Recursos Próprios</option>
                        <option value="Recursos do FEAS-387.13002.803-2.161-3.3.90.32">Recursos do FEAS</option>
                        <option value="Recursos Próprios-616.13002.801-2.192.3.3.90.39">Recursos Próprios</option>
                    </optgroup>

                    <optgroup label="Manutenção do Conselho Tutelar">
                        <option value="Material de Consumo (Recursos Próprios)-388.13002.801-2.74-3.3.90.30">Material de Consumo (Recursos Próprios)</option>
                        <option value="Serviço de PJ (Recursos Próprios)-388.13002.801-2.74-3.3.90.39">Serviço de PJ (Recursos Próprios)</option>
                        <option value="Serviço de PF (Recursos Próprios)-388.13002.801-2.74-3.3.90.36">Serviço de PF (Recursos Próprios)</option>
                    </optgroup>

                    <optgroup label="Manutenção do SCFV – Serviço de Convivência">
                        <option value="Material de Consumo (Recursos FNAS)-402.13002.802.-2.118-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-402.13002.802.-2.118-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-402.13002.802.-2.118-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Manutenção Abrigo Institucional">
                        <option value="Material de Consumo (Recursos FMAS)-405.13002.804-2.183.3.3.90.30">Material de Consumo (Recursos FMAS)</option>
                        <option value="Material de Consumo (Recursos FEAS)-407.13002.804-2.183.3.3.90.30">Material de Consumo (Recursos FEAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-405.13002.804-2.183.3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FEAS)-407.13002.804-2.183-3.3.90.39">Serviço de PJ (Recursos FEAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-405.13002.804-2.183.3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FEAS)-407.13002.804-2.183-3.3.90.36">Serviço de PF (Recursos FEAS)</option>
                    </optgroup>

                    <optgroup label="Manutenção Criança Feliz – Primeira Infância no SUAS">
                        <option value="Material de Consumo (Recursos FNAS)-683.13002.805.-2.224-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-683.13002.805.-2.224-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-683.13002.805.-2.224-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao CRAS/PAIF/SCFV e outros">
                        <option value="Recursos FNAS-410.13002.802.-1.74-4.4.90.52">Recursos FNAS</option>
                        <option value="Recursos Próprios-408.13002.802.-1.74-4.4.90.52">Recursos Próprios</option>
                    </optgroup>

                    <optgroup label="Manutenção do CRAS/PAIF">
                        <option value="Material de Consumo (Recursos FNAS)-423.13002.802.-2.112-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Material de Consumo (Recursos FEAS)-424.13002.802.-2.112-3.3.90.30">Material de Consumo (Recursos FEAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-423.13002.802.-2.112-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FEAS)-424.13002.802.-2.112-3.3.90.39">Serviço de PJ (Recursos FEAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-423.13002.802.-2.112-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FEAS)-424.13002.802.-2.112-3.3.90.36">Serviço de PF (Recursos FEAS)</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao CREAS/ABRIGO">
                        <option value="Recursos FNAS-631.13002.803-1.143-4.4.90.52">Recursos FNAS</option>
                    </optgroup>

                    <optgroup label="Manutenção do CREAS/PAEFI">
                        <option value="Material de Consumo (Recursos FNAS)-441.13002.803-2.121-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-441.13002.803-2.121-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-441.13002.803-2.121-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao Criança Feliz">
                        <option value="Recursos FNAS-635.13002.805-1.144-4.4.90.52">Recursos FNAS</option>
                    </optgroup>

                    <optgroup label="Aquisição de Veículos, Móveis, Máquinas e Equipamentos Diversos destinados ao IGD">
                        <option value="Recursos FNAS-448.13002.806-1.62-4.4.90.52">Recursos FNAS</option>
                    </optgroup>

                    <optgroup label="Manutenção do Bolsa Família – IGD">
                        <option value="Material de Consumo (Recursos FNAS)-449.13002.806-2.102-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-449.13002.806-2.102-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-449.13002.806-2.102-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>

                    <optgroup label="Manutenção Segurança Alimentar e Nutricional">
                        <option value="Material de Consumo (Recursos FNAS)-466.13002.810-2.116-3.3.90.30">Material de Consumo (Recursos FNAS)</option>
                        <option value="Serviço de PJ (Recursos FNAS)-466.13002.810-2.116-3.3.90.39">Serviço de PJ (Recursos FNAS)</option>
                        <option value="Serviço de PF (Recursos FNAS)-466.13002.810-2.116-3.3.90.36">Serviço de PF (Recursos FNAS)</option>
                    </optgroup>
                </select>

            </div>
            <div>
                <button type="button" id="add-divs-btn">Adicionar Divs</button>
                <!--button type="submit">Enviar Pedido</button-->
            </div>
            <button type="button" id="add-divs-btn">Adicionar Divs</button>
        </form>
<script src="scripts.js"></script>

        <?php
        if (isset($_GET['msg'])) {
            echo "<p>{$_GET['msg']}</p>";
        }
        ?>
    </div>
    <footer><img src="footer.svg" alt=""></footer>
</body>

</html>