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
	$stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA WHERE CATEGORIA_ATIVO = 1");
	$stmt_categoria->execute();
	$categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo "<p style='color:red;'> Erro ao buscar categorias" . $e->getMessage() . "</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   //$_SERVER['REQUEST_METHOD'] retorna o metodo usado para acessar a pagina

	//criar um formulario com os nomes dessas variaveis
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$preco = $_POST['preco'];
	$desconto = $_POST['desconto'];
	$categoria_id = $_POST['categoria_id'];
	$ativo = isset($_POST['ativo']) ? 1 : 0;
	$imagem_urls = $_POST['imagem_url'];
	$imagem_ordens = $_POST['imagem_ordem'];
	$quantidade = $_POST['quantidade'][0]; // Assumindo que sempre haverá apenas uma quantidade

	try {
		$sql = "INSERT INTO PRODUTO 
			(PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) 
			VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
		$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
		$stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
		$stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
		$stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_STR);
		$stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
		$stmt->execute();

		// Pegando o id do ultimo produto inserido
		$produto_id = $pdo->lastInsertID();

		// Inserindo imagens no BD
		foreach ($imagem_urls as $index => $url) {
			$ordem = $imagem_ordens[$index];
			$sql_imagem = "INSERT INTO PRODUTO_IMAGEM (IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM)
					VALUES (:imagem_url, :produto_id, :imagem_ordem)";

			$stmt_imagem = $pdo->prepare($sql_imagem);

			$stmt_imagem->bindParam(':imagem_url', $url, PDO::PARAM_STR);
			$stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
			$stmt_imagem->bindParam(':imagem_ordem', $ordem, PDO::PARAM_INT);
			$stmt_imagem->execute();
		}

		// Inserindo quantidade no estoque
		$sql_quantidade = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) VALUES (:produto_id, :quantidade)";
		$stmt_quantidade = $pdo->prepare($sql_quantidade);
		$stmt_quantidade->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
		$stmt_quantidade->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
		$stmt_quantidade->execute();

		echo "<p style='color:green;'> Produto cadastrado com sucesso!</p>";
	} catch (PDOException $e) {
		echo "<p style='color:red;'> Erro ao cadastrar o produto: " . $e->getMessage() . "</p>";
	}
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../CSS/cadastrar_produto.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="../JS/cadastrar_produto.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro de Produtos</title>
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
					<h1>Vamos cadastrar um <span>Novo Produto</span></h1>
					<img src="../fotos/usuario.png" alt="Barra de Carregamento do usuario" />
				</div>
			</header>

			<div class="form_register">
				<form action="" method="post" enctype="multipart/form-data" onsubmit="onSubmit(event)">
					<div class="form_column">
						<div class="form_box">
							<label for="nome">Nome do Produto: </label>
							<input type="text" name="nome" id="nome" placeholder="Digite o nome do Produto" required>
						</div>
						<div class="form_box">
							<label for="preco">Valor do Produto: </label>
							<input type="number" name="preco" id="preco" step="0.01" required placeholder="Digite o valor do Produto">
						</div>
						<div class="form_box">
							<label for="desconto">Desconto Aplicado: </label>
							<input type="number" name="desconto" id="desconto" step="0.01" placeholder="Digite o valor de desconto">
						</div>
						<div class="form_box">
							<label for="quantidade">Quantidade em estoque: </label>
							<input type="number" name="quantidade[]" id="quantidade" step="1.00" placeholder="Digite a quantidade de itens">
						</div>
						<div class="form_box">
							<label for="categoria_id">Categoria do Produto:</label>
							<select name="categoria_id" id="categoria_id" required>
								<option value="">Selecione...</option>
								<?php foreach ($categorias as $categoria) : ?>
									<option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOME']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form_column">
						<div class="form_box">
							<label for="imagem">URL da Imagem do Produto:</label>
							<div id="containerImagens">
								<div class="imagem_container">
									<input type="text" name="imagem_url[]" placeholder="URL Imagem">
									<input type="number" name="imagem_ordem[]" placeholder="Ordem Imagem" min="1">
									<a class="remove-icon" onclick="removerImagem(this)"><i class="bi bi-x-circle-fill"></i></a>
								</div>
							</div>
							<button type="button" onclick="adicionarImagem()">Adicionar Imagem</button>
						</div>
						<div class="form_box">
							<label for="descricao">Descrição do Produto: </label>
							<textarea name="descricao" id="descricao" required></textarea>
						</div>
						<div class="form_check">
							<label for="ativo">Produto Ativo: </label>
							<input type="checkbox" name="ativo" id="ativo" checked>
						</div>
						<div class="form_box" id="register_submit">
							<input class="register" type="submit" value="Cadastrar Produto">
						</div>
					</div>
				</form>
			</div>
		</section>
	</main>
</body>
<script>
	let numImagens = 1; // Inicializa com o número de imagens existentes
</script>
</html>
