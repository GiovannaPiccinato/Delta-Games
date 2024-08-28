<?php
session_start();
require_once('../conexao.php');

if(!isset($_SESSION['admin_logado'])){ //se nao existeir um adm logado, vamos direcionar ele para pagina de login
    header('Location:login.php');
    exit(); 
}

if (isset($_GET['logout'])) {
	session_destroy();
	header('location: ../login.php');
  exit();
};

$message = '';

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    $id = $_GET['id'];
    try{
        $stmt = $pdo->prepare("DELETE FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM PRODUTO_IMAGEM WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $pdo->prepare("DELETE FROM PRODUTO WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $message = "<p>Produto excluído com sucesso!</p>";
        }else{
            $message = "Erro ao excluir o produto!";
    }
} catch (PDOException $e){
    $message = "<p style='color:white;'> Não Foi Possível Excluir o Produto Selecionado </p>";
}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/excluir_produto.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="../JS/ativo.js"></script>
    <title>Excluir Produto</title>
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

					<li class="menu_item ativo">
						<a href="../PRODUTO/listar_produto.php">
							<span class="icon"><i class="bi bi-tags"></i></span>
							<span class="text">PRODUTOS</span>
						</a>
					</li>

					<li class="menu_item">
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
<!-- 
					<li class="menu_item">
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
			<p><?php echo $message; ?></p>
			<!-- <a href="./listar_administrador.php"> Voltar à listagem de administradores </a> -->
			<button id="button_back" onclick="window.location.href = '../PRODUTO/listar_produto.php'">Voltar</button>
		</section>
		</section>
</body>
</html>