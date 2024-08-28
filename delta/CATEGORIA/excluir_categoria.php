<?php
    session_start();

    if(!isset($_SESSION['admin_logado'])){
        header("Location:login.php");
        exit();
    }

		if (isset($_GET['logout'])) {
			session_destroy();
			header('location: ../login.php');
			exit();
		};

    require_once('../conexao.php');
    
    $mensagem = '';

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
        $id = $_GET['id'];
        try{
            $stmt = $pdo->prepare('DELETE FROM CATEGORIA WHERE CATEGORIA_ID = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $mensagem = "Categoria excluída com sucesso!";
            } else {
                $mensagem = "Erro ao excluir a Categoria " . $id . "!";
            }
        } catch (PDOException $e){
            $e;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/excluir_categoria.css">
		<script src="../JS/ativo.js"></script>
    <title>Excluir Categoria</title>
</head>
<body>
	<main>
		<nav class="lateral_menu">
			<div class="items">
				<ul>
					<li class="menu_item">
						<a href="../painel_admin.php">
							<span class="icon"><i class="bi bi-house"></i></span>
							<span class="text">HOME</span>
						</a>
					</li>

					<li class="menu_item">
						<a href="../PRODUTO/listar_produto.php">
							<span class="icon"><i class="bi bi-tags"></i></span>
							<span class="text">PRODUTOS</span>
						</a>
					</li>

					<li class="menu_item ativo">
						<a href="../CATEGORIA/listar_categoria.php">
							<span class="icon"><i class="bi bi-controller"></i></span>
							<span class="text">CATEGORIA</span>
						</a>
					</li>

					<li class="menu_item">
						<a href="../ADMINISTRADOR/listar_administrador.php">
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
        <a class="btn-sair" href="../painel_admin.php?logout">
          <span class="icon"><i class="bi bi-door-closed"></i></span>
          <span class="text">SAIR</span>
        </a>
      </div>
		</nav>

		<section class="painel">
			<header>
				<div class="welcome">
					<h1>Olá <span> Jogador</span></h1>
					<img src="../fotos/usuario.png" alt="Barra de Carregamento do usuario" />
				</div>
			</header>

			<section class="list">
			<img src="../FOTOS/excluir.png" alt="excluir">
			<p>Não Foi Possível Excluir a Categoria Selecionada</p>
			<button id="button_back" onclick="window.location.href = '../CATEGORIA/listar_categoria.php'">Voltar</button>
		</section>
		</section>
</body>
</html>