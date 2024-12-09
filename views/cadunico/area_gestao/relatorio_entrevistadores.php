<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/conexao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/data_mes_extenso.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
    <link rel="stylesheet" href="/TechSUAS/css/cadunico/area_gestor/gestor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/TechSUAS/js/cadastro_unico.js"></script>
    <script src='/TechSUAS/js/personalise.js'></script>

    <title>Relatório Entrevistadores - TechSUAS</title>
</head>
<body>
<div id="comunicado_container" style="background-image: url('../../../img/cadunico/timbre_cad-amor_trabalho.png'); background-size: 760px 1105px">
</div>
        <h1>Relatório Mensal de Atividades - Entrevistadores do Cadastro Único</h1>
  <div id="esconde_form">
        <form action="" method="get" id="formComMes">

      <label for="comp_mes">Completo ou Mensal:</label>
        <select id="comp_mes" name="comp_mes"  onchange="insert_mes()">
          <option value="" disabled selected hidden>Selecione</option>
          <option value="sim">Completo</option>
          <option value="nao">Mensal</option>
        </select>

        <input type="number" name="qualmes" id="qualmes" style="display: none;" placeholder="Digite o mês">
        <input type="number" name="qualano" id="qualano" style="display: none;" placeholder="Digite o ano">

    <button type="submit" id="gerar_rel">Gerar</button>

    </form>
</div>
    <?php
    
    if (!isset($_GET['comp_mes'])) {
      
    } else {

      // REQUISIÇÃO DO STATUS MUNICIPIO E COORDENAÇÃO
      $munic = $_SESSION['municipio'];
      $where_sql = "";
      $stmt_coordena = "SELECT nome, id_cargo FROM operadores WHERE municipio = '$munic' AND funcao = 1";
      $stmt_coordena_query = $conn_1->query($stmt_coordena) or die("Erro " .$conn_1 - error);

      $dados_coordena = $stmt_coordena_query->fetch_assoc();

      if ($_GET['comp_mes'] == "nao") {

        if (isset($_GET['qualmes']) && $_GET['qualmes'] !='' && isset($_GET['qualano']) && $_GET['qualano'] !='') {
          $meses_esc = $_GET['qualmes'];
          $ano_esc = $_GET['qualano'];

          $where_sql .= "AND MONTH(dta_entrevista_fam) = '$meses_esc' AND YEAR(dta_entrevista_fam) = '$ano_esc'";

        } else {

        }

        $sql = "SELECT
        COUNT(CASE WHEN cod_forma_coleta_fam = 2 THEN 1 END) AS quant_visit_cad,
        COUNT(*) AS quant_cad,
        ROUND(
        (COUNT(CASE WHEN cod_forma_coleta_fam = 2 THEN 1 END) / COUNT(*)) * 100, 2
            ) AS porcento
        FROM tbl_tudo
        WHERE cod_parentesco_rf_pessoa = 1";
  
            $query = $pdo->query($sql);
            $row = $query->fetch(PDO::FETCH_ASSOC);

            $total_visitas = $row['quant_visit_cad'];
            $total_cadastro = $row['quant_cad'];
            $porcento = str_replace(".", ",", $row['porcento']);

        /* RELATÓRIO MENSAL*/

        $stmt_mensal = "SELECT 
          nom_entrevistador_fam,
          SUM(CASE 
              WHEN MONTH(dat_cadastramento_fam) = '$meses_esc' AND YEAR(dat_cadastramento_fam) = '$ano_esc' 
              THEN 1 
              ELSE 0 
          END) AS total_cadastros,
          SUM(CASE 
              WHEN MONTH(dta_entrevista_fam) = '$meses_esc' AND YEAR(dta_entrevista_fam) = '$ano_esc' 
              THEN 1 
              ELSE 0 
          END) AS total_atualizacoes
          FROM tbl_tudo
          WHERE cod_parentesco_rf_pessoa = 1 $where_sql
          GROUP BY nom_entrevistador_fam
          ORDER BY nom_entrevistador_fam ASC
          ";
        $stmt_nemsal_query = $conn->query($stmt_mensal) or die("ERRO na consulta !" . $conn->error);

        $stmt_mensal_vis = "SELECT
              vf.entrevistador,
              COUNT(DISTINCT CASE
                  WHEN MONTH(vf.data) = '$meses_esc' AND YEAR(vf.data) = '$ano_esc' THEN vf.id ELSE NULL END) AS total_visitas,
              COUNT(DISTINCT CASE
                  WHEN MONTH(tt.dta_entrevista_fam) = '$meses_esc' AND YEAR(tt.dta_entrevista_fam) = '$ano_esc' AND cod_forma_coleta_fam = 2 AND cod_parentesco_rf_pessoa = 1
                  THEN tt.id ELSE NULL END) AS com_marcacao,
              COUNT(DISTINCT CASE
                  WHEN MONTH(vf.data) = '$meses_esc' AND YEAR(vf.data) = '$ano_esc' AND acao != 5 THEN vf.id ELSE NULL END) AS sem_atualizacao
              FROM visitas_feitas vf
              LEFT JOIN tbl_tudo tt ON vf.entrevistador = tt.nom_entrevistador_fam
              GROUP BY vf.entrevistador
              ORDER BY entrevistador ASC
      ";

      $stmt_mensal_vis_query = $conn->query($stmt_mensal_vis) or die("ERRO na consulta !" . $conn->error);

      // DADOS PARA O GRÁFICO

      $visitas = [];
      $cadastros = [];
      $entrevista = [];
      
      $stmt_graficos = "SELECT 
                  t.nom_entrevistador_fam,
              COUNT(DISTINCT CASE
                  WHEN MONTH(v.data) = '$meses_esc' AND YEAR(v.data) = '$ano_esc' 
                  THEN v.id END) AS total_visitas,
              COUNT(DISTINCT CASE
                  WHEN MONTH(t.dta_entrevista_fam) = '$meses_esc' AND YEAR(t.dta_entrevista_fam) = '$ano_esc' 
                        AND t.cod_parentesco_rf_pessoa = 1
                  THEN t.id END) AS atual_visita
        FROM tbl_tudo t
        LEFT JOIN visitas_feitas v ON t.nom_entrevistador_fam = v.entrevistador
        WHERE (MONTH(t.dta_entrevista_fam) = '$meses_esc' AND YEAR(t.dta_entrevista_fam) = '$ano_esc')
              OR (MONTH(v.data) = '$meses_esc' AND YEAR(v.data) = '$ano_esc')
        GROUP BY t.nom_entrevistador_fam
        ORDER BY t.nom_entrevistador_fam ASC
      ";
      
      $stmt_graficos_query = $conn->query($stmt_graficos) or die("ERRO na consulta !" . $conn->error);
      
      if ($stmt_graficos_query->num_rows == 0) {
        echo "SEM DADOS";
      } else {
        while ($dados_graf = $stmt_graficos_query->fetch_assoc()) {
          $visitas[] = $dados_graf['total_visitas'];
          $cadastros[] = $dados_graf['atual_visita'];
          $entrevista[] = $dados_graf['nom_entrevistador_fam'];
        }
      }
      
      echo "<script>
              var entrevistadores = " . json_encode($entrevista, JSON_HEX_TAG) . ";
              var cadastros = " . json_encode($cadastros, JSON_HEX_TAG) . ";
              var visitas = " . json_encode($visitas, JSON_HEX_TAG) . ";
            </script>";

            // REFERENCIA DA ULTIMA EXTRAÇÃO DA BASE
            $a = "SELECT ref_cad FROM tbl_tudo";
            $a_q = $conn->query($a);
            $abc = $a_q->fetch_assoc();



          if ($stmt_nemsal_query->num_rows == 0) {
            echo "SEM DADOS";
          } else {
            ?>


                  <!-- STATUS DO MUNICIPIO E CORDENAÇÃO -->
            <h4>
            Município: <?php echo $cidade; ?><br>
            Data emissão: <?php echo $data_formatada_extenso; ?><br>
            Período referente à: <?php
            if (isset($_GET['qualmes']) && $_GET['qualmes'] !='') {
              echo $meses_esc. "/". $ano_esc;
            } else {/* NÃO FAZ NADA */}
            ?><br>
            Coordenação: <?php echo $dados_coordena['nome']; ?><br>
            <?php echo $dados_coordena['id_cargo']; ?>
            </h4>



            <div id="legendaGrafico"></div>
            <div class="graficos">
                <!-- Canvas para o gráfico -->
                <canvas id="graficoCadastros"></canvas>
                <canvas id="graficoVisitas"></canvas>
                <span>Este documento foi criado a partir da ultima extração da base referente a <?php echo date('d/m/Y', strtotime($abc['ref_cad'])); ?> com <?php echo $total_cadastro; ?> cadastros ativos no V7.</span>
            </div>


            <div class="introduction">
            <h3>Introdução</h3>

            <p>Este relatório apresenta o desempenho dos entrevistadores do Cadastro Único no município de <?php echo $cidade; ?> durante o mês de <strong><?php if (isset($_GET['qualmes']) && $_GET['qualmes'] !='') {
                                                          echo $meses_esc. "/". $ano_esc;
                                                        } else {
                                                          echo " ?";
                                                        }
            ?>
            </strong>. Com grande competência e responsabilidade, os entrevistadores exercem uma função crucial na coleta e atualização dos dados das famílias inscritas no Cadastro Único. Seu trabalho assegura que as informações sejam mantidas constantemente atualizadas, viabilizando o acesso contínuo dessas famílias aos programas sociais disponíveis.</p>

            <h4>Inclusão e Atualização Cadastral:</h4>
            <p>Durante o mês em questão, os entrevistadores foram responsáveis pela realização de novos cadastros e pela atualização de cadastros existentes. Abaixo, um resumo dessas atividades:</p>

            <table border="1">
            <tr>
              <th>Entrevistador</th>
              <th>Novos Cadastros</th>
              <th>Atualizações</th>
              <th>Total</th>
            </tr>
            
            <?php
            while ($dados_rel = $stmt_nemsal_query->fetch_assoc()) {

              ?>
              <tr>
                <td><?php echo $dados_rel['nom_entrevistador_fam']; ?></td>
                <td><?php echo $dados_rel['total_cadastros']; ?></td>
                <td><?php echo $dados_rel['total_atualizacoes'] - $dados_rel['total_cadastros']; ?></td>
                <td><?php echo $dados_rel['total_atualizacoes']; ?></td>

              </tr>
              <?php
            }
            ?>

            </table>
            <p>Dados extraídos do Cecad referente a 
              <?php 
              echo date('d/m/Y', strtotime($abc['ref_cad']));
              ?>.</p>
            <p><strong>Novos Cadastros:</strong> Refere-se à inclusão de famílias que ainda não constavam no sistema, sendo identificadas para terem acesso aos benefícios dos programas sociais.</p>
            <p><strong>Atualizações de Cadastros:</strong> Consiste na revisão e correção de informações já existentes no sistema. É importante garantir que os dados das famílias estejam sempre atualizados, para que possam continuar recebendo os benefícios a que têm direito.</p>
            <h4>Visitas Domiciliares:</h4>
            <p>As visitas domiciliares são parte fundamental do processo de coleta de dados do Cadastro Único, especialmente quando a família não consegue comparecer aos pontos de atendimento.</p>
            <table border="1">
              <tr>
                <th>Entrevistador</th>
                <th>Com Atualizadas</th>
                <th>Sem Atualização</th>
                <th>Visitas Total</th>
              </tr>
              <?php
          if ($stmt_mensal_vis_query->num_rows == 0) {
            ?>
            <tr>
              <td colspan="4">Nenhum resultado...</td>
            </tr>
            </table>
            <?php
          } else {
            while ($dados_vis = $stmt_mensal_vis_query->fetch_assoc()) {

              ?>
              <tr>
                <td><?php echo $dados_vis['entrevistador']; ?></td>
                <td><?php echo $dados_vis['com_marcacao']; ?></td>
                <td><?php echo $dados_vis['sem_atualizacao']; ?></td>
                <td><?php echo $dados_vis['total_visitas']; ?></td>

              </tr>
              <?php
            }
              ?>

            </table>
            <p>Dados extraídos do Cecad referente a
            <?php 
              $a = "SELECT ref_cad FROM tbl_tudo";
              $a_q = $conn->query($a);
              $abc = $a_q->fetch_assoc();
              echo date('d/m/Y', strtotime($abc['ref_cad']));
              ?> e do TechSUAS.</p>
<?php
          }
            ?>
            <p></p>
            <p><strong>Importância das Visitas Domiciliares:</strong> As visitas domiciliares desempenham um papel vital no processo de inclusão e acompanhamento das famílias inscritas no Cadastro Único, especialmente aquelas em situação de vulnerabilidade social. Atualmente o município tem <strong><?php echo $total_visitas; ?></strong> cadastros marcados com visitas, sendo <strong><?php echo $porcento; ?>%</strong> de todos os cadastros deste município. Muitas dessas famílias enfrentam dificuldades de acesso aos centros de atendimento, seja por questões geográficas, financeiras ou de saúde, o que torna as visitas uma ferramenta indispensável para garantir que esses grupos não sejam excluídos dos benefícios sociais.</p>

            <p>Ao visitar diretamente os domicílios, os entrevistadores têm a oportunidade de coletar informações detalhadas e atualizadas sobre as condições socioeconômicas das famílias. Esse contato in loco permite uma avaliação mais precisa de aspectos que não podem ser plenamente captados apenas por registros ou entrevistas à distância. É possível verificar as condições de moradia, o contexto em que essas famílias vivem e, assim, compreender de maneira mais profunda suas necessidades.</p>

            <p>Além disso, as visitas não só beneficiam as famílias que não têm condições de comparecer aos postos de atendimento, como também são um instrumento valioso nas situações de deslocamento de famílias e nas averiguações cadastrais solicitadas pelo governo. Quando uma família muda de endereço ou há suspeitas de desatualização dos dados, a visita domiciliar garante que as informações sejam atualizadas com precisão, assegurando a continuidade e a adequação dos benefícios sociais.</p>

            <p>Assim, a estratégia das visitas domiciliares reflete um compromisso direto com a justiça social e a inclusão, sendo um dos pilares centrais para que o Cadastro Único desempenhe seu papel de forma eficiente e equitativa. Por meio delas, é possível garantir que os programas sociais alcancem efetivamente quem mais precisa, promovendo um impacto positivo e transformador na vida dessas famílias.</p>

            <h4>Atendimentos:</h4>

            <table border="1">
              <tr>
                <th></th>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table>

            <h4>Folha de ponto:</h4>

<?php



?>

            <h3>Conclusão</h3>

            <p>Este relatório mensal visa não apenas avaliar o desempenho dos entrevistadores do Cadastro Único, mas também destacar a importância crucial de suas atividades no acompanhamento contínuo das famílias cadastradas no município. As ações realizadas, incluindo novos cadastros, atualizações de dados e visitas domiciliares, refletem o compromisso com a inclusão social e a equidade, fundamentais para assegurar que os programas sociais atinjam as populações mais vulneráveis de forma eficaz.</p>
            <p>A continuidade do monitoramento e do aperfeiçoamento dos processos de cadastramento, atualização e visitas domiciliares será essencial para garantir que essas famílias continuem a ter acesso aos benefícios sociais de forma justa e adequada. O papel dos entrevistadores, nesse sentido, é vital para a construção de uma rede de proteção social eficiente e alinhada às reais necessidades da população, promovendo impactos sociais transformadores</p>
            </div>
            <?php
          }
      } else {

        /* RELATÓRIO COMPLETO*/

      }
    }

    ?>
    <script>
      function insert_mes() {
        var select = document.getElementById("comp_mes")
        var campoTexto = document.getElementById("qualmes")
        var campoAno = document.getElementById("qualano")

      if (select.value == "nao") {
          // Se a opção 'Outros' for selecionada, mostra o campo de texto
          campoTexto.style.display = "block"
          campoAno.style.display = "block"
      } else {
          // Caso contrário, oculta o campo de texto
          campoTexto.style.display = "none"
          campoAno.style.display = "none"
      }
    }

    </script>


    <script>
// Gráfico de Cadastros
const ctxCadastros = document.getElementById('graficoCadastros').getContext('2d')
const graficoCadastros = new Chart(ctxCadastros, {
    type: 'bar', // Tipo de gráfico (barras)
    data: {
        labels: entrevistadores.map(() => ''), // Nomes dos entrevistadores
        datasets: [
            {
                label: 'Cadastros',
                data: cadastros,
                backgroundColor: [
                  '#13294b', '#065f33', '#8b0000', '#cd5c5c', '#008080', 
                  '#2e8b57', '#00ff00', '#ff9900', '#4682b4', '#b22222', 
                  '#ff4500', '#6a5acd', '#32cd32', '#d2691e', '#5f9ea0', 
                  '#ff6347', '#6495ed', '#daa520', '#7b68ee', '#20b2aa'
                ],
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2
            }
        ]
    },
    options: {
        scales: {
            y: {
              beginAtZero: true // Iniciar o gráfico no valor 0
            },
            x: {
              grid: {
                display: false
              }
            }
        }
    }
})

// Gráfico de Visitas
const ctxVisitas = document.getElementById('graficoVisitas').getContext('2d')
const graficoVisitas = new Chart(ctxVisitas, {
    type: 'bar', // Tipo de gráfico (barras)
    data: {
        labels: entrevistadores.map(() => ''), // Nomes dos entrevistadores
        datasets: [
            {
                label: 'Visitas',
                data: visitas,
                backgroundColor: [
                  '#13294b', '#065f33', '#8b0000', '#cd5c5c', '#008080', 
                  '#2e8b57', '#00ff00', '#ff9900', '#4682b4', '#b22222', 
                  '#ff4500', '#6a5acd', '#32cd32', '#d2691e', '#5f9ea0', 
                  '#ff6347', '#6495ed', '#daa520', '#7b68ee', '#20b2aa'
                ],
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true // Iniciar o gráfico no valor 0
            },
            x: {
              grid: {
                display: false
              }
            }
        }
    }
})

function legendaGrafico(entrevistadores, cores) {
  let legendaHTML = '<ul>'
  entrevistadores.forEach((nome, index) => {
    legendaHTML += `<li><span style="background-color: ${cores[index]};"></span> ${nome}</li>`
  });
  legendaHTML += '</ul>'
  document.getElementById('legendaGrafico').innerHTML = legendaHTML
}

const cores = [
                  '#13294b', '#065f33', '#8b0000', '#cd5c5c', '#008080', 
                  '#2e8b57', '#00ff00', '#ff9900', '#4682b4', '#b22222', 
                  '#ff4500', '#6a5acd', '#32cd32', '#d2691e', '#5f9ea0', 
                  '#ff6347', '#6495ed', '#daa520', '#7b68ee', '#20b2aa'
                ]

  legendaGrafico(entrevistadores, cores)
</script>


    <?php
    $conn->close();
    $conn_1->close();
    ?>
</body>
</html>

