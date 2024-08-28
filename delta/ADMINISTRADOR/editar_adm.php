<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
	header('Location: login.php');
	exit();
}

if (isset($_GET['logout'])) {
	session_destroy();
	header('location: ../login.php');
  exit();
};

require_once('../conexao.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		try {
			$stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :id");
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$administrador = $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "Erro: " . $e->getMessage();
		}
	} else {
		header('Location: listar_administrador.php');
		exit();
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$ativo = isset($_POST['ativo']) ? 1 : 0;

	try {
		$stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ATIVO = :ativo WHERE ADM_ID = :id");
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nome', $nome);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':senha', $senha);
		$stmt->bindParam(':ativo', $ativo);
		$stmt->execute();

		header('Location: listar_administrador.php');
		exit();
	} catch (PDOException $e) {
		echo "Erro: " . $e->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../CSS/editar_adm.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="../JS/ativo.js"></script>
	<title>Editar Administrador</title>
</head>

<body>

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

						<li class="menu_item">
							<a href="../CATEGORIA/listar_categoria.php">
								<span class="icon"><i class="bi bi-controller"></i></span>
								<span class="text">CATEGORIA</span>
							</a>
						</li>

						<li class="menu_item ativo">
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
						<h1>Vamos alterar os seus Dados, <span>Jogador</span></h1>
						<img src="../fotos/usuario.png" alt="Barra de Carregamento do usuario" />
					</div>
				</header>

				<div class="form_register">
					<form action="editar_adm.php" method="post" enctype="multipart/form-data">

						<div class="form_box">
							<input type="hidden" name="id" value="<?php echo $administrador['ADM_ID']; ?>">
						</div>

						<div class="form_box">
							<label for="nome">Nome:</label>
							<input type="text" name="nome" id="nome" value="<?php echo $administrador['ADM_NOME']; ?>">
						</div>

						<div class="form_box">
							<label for="email">E-mail:</label>
							<input type="email" name="email" id="email" value="<?php echo $administrador['ADM_EMAIL']; ?>">
						</div>

						<div class="form_box">
							<label for="senha">Senha:</label>
							<input type="password" name="senha" id="senha" value="<?php echo $administrador['ADM_SENHA']; ?>">
						</div>

						<div class="form_check">
							<label for="ativo"> Ativo:</label>
							<input id="check" type="checkbox" name="ativo" id="ativo" value="1" <?= $administrador['ADM_ATIVO'] ? 'checked' : '' ?>>
						</div>

						<div class="form_box">
							<input type="submit" value="Atualizar">
						</div>
					</form>

					<!-- <div><a href="./listar_administrador.php"> Listar Administradores</a></div> -->
				</div>
			</section>
		</main>
	</body>
</html>