<?php
session_start();
require_once('../conexao.php');

if (!isset($_SESSION['admin_logado'])) {
	header('Location:login.php');
	exit();
}

if (isset($_GET['logout'])) {
	session_destroy();
	header('location: ../login.php');
  exit();
};

// bloco de consultas para buscar categorias. a variavem $categorias criada será utilizada no form para mostrar as categorias disponiveis.

try {
	$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
	$stmt_categoria->execute();
	$categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "<p style='color=red;'> Erro ao buscar categorias" . $e->getMessage() . "</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   //$_SERVER['REQUEST_METHOD'] retorna o metodo usado para acessar a pagina

	//criar um formulario com os nomes dessas variaveis
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$ativo = isset($_POST['ativo']) ? 1 : 0;

	try {
		$sql = "INSERT INTO CATEGORIA 
			(CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ID, CATEGORIA_ATIVO) 
			VALUES (:nome, :descricao, :categoria_id, :ativo)";

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
		$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
		$stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
		$stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
		$stmt->execute();

		//pegando o id do ultimo produto inserido
		$categoria_id = $pdo->lastInsertID();
	} catch (PDOException $e) {
		echo "<p style='color:red;'> Erro ao cadastrar o produto: " . $e->getMessage() . "</p>";
	}
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../CSS/cadastrar_categoria.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="../JS/cadastrar_categoria.js"></script>
	<title>Cadastro de Categoria</title>
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
					<h1>Vamos cadastrar uma, <span>Nova Categoria</span></h1>
					<img src="../fotos/usuario.png" alt="Barra de Carregamento do usuario" />
				</div>
			</header>

			<div class="form_register">
				<form action="" method="post" enctype="multipart/form-data" onsubmit="onSubmit(event)">
					<div class="form_box">
						<label for="nome">Nome: </label>
						<input type="text" name="nome" id="nome" required>
					</div>

					<div class="form_box">
						<label for="descricao">Descrição: </label>
						<textarea name="descricao" id="descricao" required> </textarea>
					</div>

					<div class="form_check">
						<label for="ativo">Ativo: </label>
						<input type="checkbox" name="ativo" id="ativo" checked>
					</div>

					<div class="form_box">
						<input class="register" type="submit" value="Cadastrar">
					</div>
				</form>
			</div>
		</section>
	</main>
</body>

<script>
	// voltar para a pagina de listagem quando clicar no cadastrar
	function onSubmit(event) {
		event.preventDefault(); // Evita o envio automático do formulário

		const form = document.querySelector("form");
		const formData = new FormData(form); // Obtem os dados do formulário

		// Envia uma requisição assíncrona para submeter o formulário
		fetch(form.action, {
				method: form.method,
				body: formData
			})
			.then(response => {
				if (response.ok) {
					// Redireciona para a página de listagem de administradores
					window.location.href = "./listar_categoria.php";
				} else {
					// Se houver um erro na requisição, exibe uma mensagem de erro
					console.error('Erro ao enviar formulário:', response.statusText);
				}
			})
			.catch(error => {
				console.error('Erro inesperado:', error);
			});
	}
</script>

</html>