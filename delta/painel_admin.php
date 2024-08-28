<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
  header('Location:login.php');
  exit(); // se nao houver a permissão do usuario, irá parar o programa e nao aparecerá as demais informações.
}

if (isset($_GET['logout'])) {
	session_destroy();
	header('location: ./login.php');
  exit();
};
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="CSS/painel_admin.css" />
  <script src="JS/painel_admin.js"></script>
  <title>Página Inicial Delta</title>
</head>

<body>
  <main>
    <nav class="lateral_menu">
      <div class="items">
        <ul>
          <li class="menu_item ativo">
            <a href="#">
              <span class="icon"><i class="bi bi-house"></i></span>
              <span class="text">HOME</span>
            </a>
          </li>

          <li class="menu_item">
            <a href="./PRODUTO/listar_produto.php">
              <span class="icon"><i class="bi bi-tags"></i></span>
              <span class="text">PRODUTOS</span>
            </a>
          </li>

          <li class="menu_item">
            <a href="./CATEGORIA/listar_categoria.php">
              <span class="icon"><i class="bi bi-controller"></i></span>
              <span class="text">CATEGORIA</span>
            </a>
          </li>

          <li class="menu_item">
            <a href="./ADMINISTRADOR/listar_administrador.php">
              <span class="icon"><i class="bi bi-person-gear"></i></span>
              <span class="text">ADMINISTRADOR</span>
            </a>
          </li>

          <!-- <li class="menu_item">
            <a href="#">
              <span class="icon"><i class="bi bi-person"></i></span>
              <span class="text">PERFIL</span>
            </a>
          </li> -->
        </ul>
      </div>

      <div class="close">
        <a class="btn-sair" href="./painel_admin.php?logout">
          <span class="icon"><i class="bi bi-door-closed"></i></span>
          <span class="text">SAIR</span>
        </a>
      </div>
    </nav>

    <section class="painel">
      <header>
        <div class="welcome">
          <h1>Seja Bem Vindo, <span>Jogador</span></h1>
          <img src="fotos/usuario.png" alt="Barra de Carregamento do usuario" />
        </div>
      </header>


      <section class="cards_conatiner">
        <div class="cards">
          <img src="./FOTOS/modalidades.png" alt="Modalidades mais jogadas">
          <h2>Jogos mais jogados</h2>
          <p>Os jogos mais jogados dos últimos anos inclui jogos como: Fortnite, League of Legends, CrossFire, Valorant, Lost Ark, Counter-Strike: Global Offensive.</p>
        </div>

        <div class="cards">
          <img src="./FOTOS/pausa.png" alt="Modalidades mais jogadas">
          <h2>Benefícios de Jogar</h2>
          <p>Ceder um tempo do seu dia para jogar algo que faz a sua serotonina aumentar é algo que irá te beneficiar de diversas maneiras, inclusive o seu desempenho na rotina do trabalho.</p>
        </div>

        <div class="cards">
          <img src="./FOTOS/jogados.png" alt="Modalidades mais jogadas">
          <h2>Principais Modalidades</h2>
          <p>As modalidades de jogos são diversas e tem uma para cada tipo de gosto de jogos, as mais conhecidas são: jogos de esportes,jogos de battle royale, jogos de luta, jogos de FPS, jogos de MOBA</p>
        </div>
      </section>


    </section>
    </section>
  </main>
</body>

</html>