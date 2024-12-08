<?php
if ($_SESSION['municipio'] == '9876543') {
  ?>
  <footer>
    <div class="municipio"><img src="" alt="noPhoto"></div>
    <div class="rodape"></div>
  </footer>
  <?php
} elseif ($_SESSION['municipio'] == '2613008') {
  ?>
  <footer>
    <div class="municipio"><img src="/TechSUAS/img/cadunico/logo_municipios/sbu.png" alt=""></div>
    <div class="rodape"></div>
  </footer>
  <?php
} elseif ($_SESSION['municipio'] == '3500758' || $_SESSION['municipio'] == '4121257') {
  
  ?>
  <!-- MUNICÍPIOS SEM LOGO -->
  <footer>
    <div class="municipio"><img src="/TechSUAS/img/cadunico/logo_municipios/cadunico.png" alt=""></div>
    <div class="rodape"></div>
  </footer>
  <?php
} elseif ($_SESSION['municipio'] == '2306801') {
  ?>
  <footer>
    <div class="municipio"><img src="/TechSUAS/img/cadunico/logo_municipios/capoeiras.png" alt=""></div>
    <div class="rodape"></div>
  </footer>
  <?php
}