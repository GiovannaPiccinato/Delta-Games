<?php
//uma sessão é iniciada e verifica-se se um administrador está logado. Se não estiver, ele é redirecionado para a página de login.
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

//o script faz uma conexão com o banco de dados, usando os detalhes de configuração especificados em conexao.php
require_once('../conexao.php');

// Se a página foi acessada via método GET, o script tenta recuperar os detalhes do produto com base no ID passado na URL.
if ($_SERVER['REQUEST_METHOD'] == 'GET') { //A superglobal $_SERVER é um array que contém informações sobre cabeçalhos, caminhos e locais de scripts. O REQUEST_METHOD é um dos índices deste array e é usado para determinar qual método de requisição foi utilizado para acessar a página, seja ele GET, POST, PUT, entre outros

	if (isset($_GET['id'])) { //$_GET é uma superglobal em PHP, o que significa que ela está disponível em qualquer lugar do seu script, sem necessidade de definição ou importação global. Ela contém dados enviados através da URL (também conhecidos como parâmetros de query string). Quando um usuário acessa uma URL como http://exemplo.com/pagina.php?id=123, o valor 123 é passado para o script pagina.php através do método GET, e você pode acessá-lo com $_GET['id'].
		$id = $_GET['id'];
		try {
			$stmt = $pdo->prepare("SELECT * FROM CATEGORIA WHERE CATEGORIA_ID = :id"); //Quando você executa uma consulta SELECT no banco de dados usando PDO e utiliza o método fetch(PDO::FETCH_ASSOC), o resultado é um array associativo, onde cada chave do array é o nome de uma coluna da tabela no banco de dados, e o valor associado a essa chave é o valor correspondente daquela coluna para o registro selecionado
			$stmt->bindParam(':id', $id, PDO::PARAM_INT); //PDO::PARAM_INT especifica que o valor é um inteiro. Isso é útil para o PDO saber como tratar o valor antes de enviá-lo ao banco de dados.  Especificar o tipo de dado pode melhorar o desempenho e a segurança da sua aplicação. É uma constante da classe PDO que representa o tipo de dado inteiro para ser usado com métodos como bindParam()
			$stmt->execute();
			$categoria = $stmt->fetch(PDO::FETCH_ASSOC); //$produto é um array associativo que contém os detalhes do produto que foi recuperado do banco de dados. Por exemplo, se a tabela de produtos tem colunas como ID, NOME, DESCRICAO, PRECO, e URL_IMAGEM, então o array $produto terá essas chaves, e você pode acessar os valores correspondentes usando a sintaxe de colchetes, 
		} catch (PDOException $e) {
			echo "Erro: " . $e->getMessage();
		}
	} else {
		header('Location: listar_categoria.php');
		exit();
	}
}

// Se o formulário de edição foi submetido, a página é acessada via método POST, e o script tenta atualizar os detalhes do produto no banco de dados com as informações fornecidas no formulário.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$ativo = isset($_POST['ativo']) ? 1 : 0;

	try {
		$stmt = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_NOME = :nome, CATEGORIA_DESC = :descricao, CATEGORIA_ATIVO = :ativo WHERE CATEGORIA_ID = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
		$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
		$stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
		$stmt->execute();

		header('Location: listar_categoria.php');
		exit();
	} catch (PDOException $e) {
		echo "Erro: " . $e->getMessage();
	}
}
?>
<!-- Um formulário de edição é apresentado ao administrador, preenchido com os detalhes atuais do produto, permitindo que ele faça modificações e submeta o formulário para atualizar os detalhes do produto -->
<!DOCTYPE html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../CSS/editar_categoria.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="../JS/ativo.js"></script>
	<title>Editar Categoria</title>
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
					<h1>Vamos alterar os Dados da, <span>Categoria</span></h1>
					<img src="../fotos/usuario.png" alt="Barra de Carregamento do usuario" />
				</div>
			</header>

			<div class="form_register">
				<form action="editar_categoria.php" method="post" enctype="multipart/form-data">

					<div class="form_box">
						<input type="hidden" name="id" value="<?php echo $categoria['CATEGORIA_ID']; ?>">
					</div>

					<div class="form_box">
						<label for="nome">Nome:</label>
						<input type="text" name="nome" id="nome" value="<?php echo $categoria['CATEGORIA_NOME']; ?>">
					</div>

					<div class="form_box">
						<label for="descricao">Descricao:</label>
							<textarea name="descricao" id="descricao"><?php echo $categoria['CATEGORIA_DESC']; ?></textarea>
					</div>

					<div class="form_check">
						<label for="ativo"> Ativo:</label>
						<input id="check" type="checkbox" name="ativo" id="ativo" value="1" <?= $categoria['CATEGORIA_ATIVO'] ? 'checked' : '' ?>>
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