<?php 
session_start();
require_once('../conexao.php');

if(!isset($_SESSION['admin_logado'])){
	header('Location:login.php');
	exit(); // se nao houver a permissão do usuario, irá parar o programa e nao aparecerá as demais informações.
}

if (isset($_GET['logout'])) {
	session_destroy();
	header('location: ../login.php');
  exit();
};

if($_SERVER['REQUEST_METHOD'] == 'POST' ) { // retorna o metod usado para acessar a página.

	$nome = $_POST ['nome'];
	$email = $_POST ['email'];
	$senha = $_POST ['senha'];
	$ativo = isset($_POST['ativo'])? 1 : 0;

try {
	$sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO)  VALUES (:nome, :email, :senha, :ativo)";

	$stmt = $pdo->prepare($sql); //Nessa linha, $stmt é um objeto que representa a instrução SQL preparada. Você pode então vincular parâmetros a essa instrução e executá-la.
	$stmt->bindParam(':nome',$nome,PDO::PARAM_STR);
	$stmt->bindParam(':email',$email,PDO::PARAM_STR);
	$stmt->bindParam(':senha',$senha,PDO::PARAM_STR);
	$stmt->bindParam(':ativo',$ativo,PDO::PARAM_INT);
	$stmt->execute();

	echo "<p style='color:green;'> Produto cadastrado com sucesso! </p>";
	} catch (PDOException $e) {
		echo "<p style='color=red;'> Erro ao cadastrar o produto" . $e->getMessage() . "</p>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../CSS/cadastrar_administrador.css">
	<script src="../JS/cadastrar_administrador.js"></script>
	<title>Cadastro de Administrador</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
					<h1>Seja Bem Vindo, <span>Novo Jogador</span></h1>
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
						<label for="email">E-mail: </label>
						<input type="email" name="email" id="email" required> </textarea>
					</div>

					<div class="form_box">
						<label for="senha">Senha: </label>
						<input type="password" name="senha" id="senha" step="0.01" required>
					</div>

					<div class="form_check">
						<label for="ativo">Ativo: </label>
						<input type="checkbox" name="ativo" id="ativo" checked>
					</div>

					<div class="form_box">
						<input class="register" type="submit" value="Cadastrar"  >
					</div>
				</form>

				<!-- <div><a href="./listar_administrador.php"> Listar Administradores</a></div> -->
			</div>
		</section>
	</main>
</body>
<script>
// voltar para a pagina de listagem quando clicar no cadastrar
	function onSubmit(event){
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
            window.location.href = "./listar_administrador.php";
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