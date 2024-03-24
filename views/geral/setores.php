<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/config/sessao.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/Suas-Tech/cadunico/controller/acesso_user/dados_usuario.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="website icon" type="png" href="../cadunico/img/logo.png">
    <link rel="stylesheet" href="css/style-cadast-setores.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../../cadunico/js/cpfvalid.js"></script>

    <script>

        // Função para preencher o CPF no campo após a busca
        function preencheCPF(cpf){
            $("#cpf").val(cpf);
        }
        </script>


    <title>Cadastro de setores</title>
</head>
<body>
<div class="img">
    <h1 class="titulo-com-imagem">
        <img class="titulo-com-imagem" src="../cadunico/img/h1-setores.svg" alt="Titulocomimagem">
    </h1>
</div>
<div class="container">
    <div class="blocott">
        <div class="bloco1">
                <form method="post" action="controller/salva_setor.php">
                <div>
                    <label>CPF da Coordenação: </label>
                    <input type="text" name="cpf_coord" onblur="validarCPF(this)" maxlength="14" id="cpf" placeholder="Usar enter após digitar." required >
                </div>
                <div>
                    <label>INSTITUIÇÃO: </label>
                    <input type="text" name="instituicao" placeholder="Segmento." required>
                </div>
                <div >
                    <label>Logradouro: </label>
                    <input class="inpu" type="text" name="rua" placeholder="Rua, Avenida, Rodovia." required>
                </div>   
                <div>
                    <label>Código Contrato: </label>
                    <input type="text" name="cod_contrato" required>
                </div>
                <div>
                    <label>Contato: </label>
                    <input type="text" name="contato" placeholder="Apenas números." required>
                </div> 
        </div>
        <div class="bloco1">
            <div>
                <label>Nome do Responsável: </label>
                <input type="text" class="inpu"  id="nomeCoordenador" name="nome_coord_resp" placeholder="Nome completo do coordenador" required>
            </div>
            <div>    
                <label>NOME DA INSTITUIÇÃO: </label>
                <input type="text" name="nome_instit" placeholder="Digite o nome da instituição." required>
            </div>
            <div>   
                <label>Número: </label>
                <input type="text" name="num" required>
                <label>Bairro: </label>
                <input type="text" name="bairro" required>
            </div>
            <div> 
                <label>E-mail Institucional: </label>
                <input class="inpu" type="email" name="emailInstit" required>
            </div>  
            <div>    
                <label>Código Institucional: </label>
                <input type="text" name="cod_instit " placeholder="Caso tenha..">
            </div>   
        </div>
    </div>
    <div class="btns">
            <div class="blocob">
                <button type="submit">SALVAR</button>
            </div>
            <div class="bloco">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i> Voltar ao menu
                </a>
                </form>
            </div>
    </div>
</div>
    <script src="../cadunico/js/cpfvalid.js"></script>
    <script src="../cadunico/js/personalise.js"></script>
    <script src='../controller/back.js'></script>
</body>

</html>

    <script src='../controller/back.js'></script>
