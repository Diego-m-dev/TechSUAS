<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/sessao.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/css_ind.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/permissao_cadunico.php';
  ?>
  <link rel="stylesheet" href="/TechSUAS/css/cadunico/style_index_cad.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="website icon" type="png" href="/TechSUAS/img/geral/logo.png">
</head>


<body>
  <div class="img">
    <h1 class="titulo-com-imagem">
      <img class="titulo-com-imagem" src="/TechSUAS/img/cadunico/h1-menu.svg" alt="Título com imagem">
    </h1>
  </div>

  <div class="apelido">
    <h3>Bem-vindo(a) <?php echo $_SESSION['apelido']; ?>.</h3>
  </div>

  <div class="tudo">
    <div class="container">
      <div class="menu">
        <nav>
          <div class="formularios">
            <a class="menu-button" href="/TechSUAS/views/cadunico/forms/index">
              <span class="material-symbols-outlined">forms_add_on</span>
              Formulários, Termos E fichas
            </a>
          </div>

          <div class="visit">
            <a class="menu-button" href="/TechSUAS/views/cadunico/visitas/index">
              <span class="material-symbols-outlined">location_away</span>
              Visitas
            </a>
          </div>

          <div class="folha">
            <a class="menu-button" href="/TechSUAS/views/cadunico/folha/folha">
              <span class="material-symbols-outlined">request_quote</span>
              Folha de Pagamento
            </a>
          </div>

          <div class="dec_enc">
            <a class="menu-button" href="/TechSUAS/views/cadunico/declaracoes/index">
              <span class="material-symbols-outlined">quick_reference_all</span>
              Declarações e Encaminhamentos
            </a>
          </div>

          <div class="links">
            <a class="menu-button" href="/TechSUAS/views/cadunico/links">
              <span class="material-symbols-outlined">link</span>
              Links Úteis
            </a>
          </div>

          <!-- "/TechSUAS/views/cadunico/msn_cad/index" -->
          <div class="msg_cad">
            <a class="menu-button" href="#">
              <span class="material-symbols-outlined">forward_to_inbox</span>
              Mensagens do CadÚnico
            </a>
          </div>

          <div class="painel">
            <a class="menu-button" href="/TechSUAS/views/cadunico/dashboard">
              <span class="material-symbols-outlined">admin_panel_settings</span>
              Painel do Entrevistador
            </a>
          </div>

          <div class="fichario">
            <a class="menu-button" href="/TechSUAS/views/cadunico/fichario/index">
              <span class="material-symbols-outlined">folder_shared</span>
              Fichário
            </a>
          </div>
          <?php
          if ($_SESSION['funcao'] == '1' || $_SESSION['funcao'] == '0') {
          ?>
            <div class="area_gestor">
              <a class="menu-button" href="/TechSUAS/views/cadunico/area_gestao/index">
                <span class="material-symbols-outlined">shield_person</span>
                Área do Gestor
              </a>
            </div>
        </nav>
      <?php
          }
      ?>
      </div>
    </div>
    <div class="calend">
      <div class="calendendario">
        
        <table>
            <thead>
              <tr>
                <th colspan="13">CALENDÁRIO DE PAGAMENTO 2025</th>
              </tr>
                <tr>
                    <th>FINAL DO NIS</th>
                    <th>JAN</th>
                    <th>FEV</th>
                    <th>MAR</th>
                    <th>ABR</th>
                    <th>MAI</th>
                    <th>JUN</th>
                    <th>JUL</th>
                    <th>AGO</th>
                    <th>SET</th>
                    <th>OUT</th>
                    <th>NOV</th>
                    <th>DEZ</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>20</td><td>17</td><td>18</td><td>15</td><td>19</td><td>16</td><td>18</td><td>18</td><td>17</td><td>20</td><td>14</td><td>10</td></tr>
                <tr><td>2</td><td>21</td><td>18</td><td>19</td><td>16</td><td>20</td><td>17</td><td>21</td><td>19</td><td>18</td><td>21</td><td>17</td><td>11</td></tr>
                <tr><td>3</td><td>22</td><td>19</td><td>20</td><td>17</td><td>21</td><td>18</td><td>22</td><td>20</td><td>19</td><td>22</td><td>18</td><td>12</td></tr>
                <tr><td>4</td><td>23</td><td>20</td><td>21</td><td>22</td><td>22</td><td>20</td><td>23</td><td>21</td><td>22</td><td>23</td><td>19</td><td>15</td></tr>
                <tr><td>5</td><td>24</td><td>21</td><td>24</td><td>23</td><td>23</td><td>23</td><td>24</td><td>22</td><td>23</td><td>24</td><td>21</td><td>16</td></tr>
                <tr><td>6</td><td>27</td><td>24</td><td>25</td><td>24</td><td>26</td><td>24</td><td>25</td><td>24</td><td>25</td><td>27</td><td>24</td><td>17</td></tr>
                <tr><td>7</td><td>28</td><td>25</td><td>26</td><td>25</td><td>27</td><td>25</td><td>26</td><td>25</td><td>26</td><td>28</td><td>25</td><td>18</td></tr>
                <tr><td>8</td><td>29</td><td>26</td><td>27</td><td>28</td><td>28</td><td>26</td><td>29</td><td>27</td><td>29</td><td>29</td><td>26</td><td>19</td></tr>
                <tr><td>9</td><td>30</td><td>27</td><td>28</td><td>29</td><td>29</td><td>27</td><td>30</td><td>28</td><td>30</td><td>30</td><td>27</td><td>22</td></tr>
                <tr><td>0</td><td>31</td><td>28</td><td>31</td><td>30</td><td>30</td><td>30</td><td>31</td><td>30</td><td>31</td><td>31</td><td>28</td><td>23</td></tr>
            </tbody>
        </table>

        <!-- <img class="calendario" src="/TechSUAS/img/cadunico/calend.svg" alt="Calendário"> -->
      </div>
    </div>
  </div>
  </div>



  </div>
  <!-- FOOTER DA PAGINA -->
  <!-- <?php //include_once $_SERVER['DOCUMENT_ROOT'] . '/TechSUAS/config/footer.php'; ?> -->

  <div class="drop-all">
    <div class="menu-drop">
      <button class="logout" type="button" name="drop">
        <span class="material-symbols-outlined">settings</span>
      </button>
      <div class="drop-content">
        <a title="Sair" href="/TechSUAS/config/logout">
          <span title="Sair" class="material-symbols-outlined">logout</span>
        </a>
        <a title="Alterar Usuário" href="/TechSUAS/views/geral/conta">
          <span class="material-symbols-outlined">manage_accounts</span>
        </a>
        <?php if ($_SESSION['funcao'] == '0') { ?>
          <a title="Suporte" href="/TechSUAS/config/back">
            <span class="material-symbols-outlined">rule_settings</span>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>

</body>

</html>