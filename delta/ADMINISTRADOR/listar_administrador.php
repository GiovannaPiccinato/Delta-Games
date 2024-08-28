<?php
session_start();
require_once('../conexao.php');

if (!isset($_SESSION['admin_logado'])) {
	header('Location:login.php');
	exit(); // se nao houver a permissão do usuario, irá parar o programa e nao aparecerá as demais informações.
}

if (isset($_GET['logout'])) {
	session_destroy();
	header('location: ../login.php');
  exit();
};

try {
	$stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR"); // * representa "todo mundo"
	$stmt->execute();
	$administrador = $stmt->fetchAll(PDO::FETCH_ASSOC); // irá voltar no formato de um array associativo - onde cada coluna será uma chave. ex: [id=1, nome=logo,]...
} catch (PDOException $e) {
	echo "Erro: " . $e->getMessage(); // getMessage irá deixar a msg de erro mais resumida.
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<link rel="stylesheet" href="../CSS/listar_administrador.css" />
	<link rel="stylesheet" href="../CSS/modal.css">
	<script src="../JS/listar_administrador.js"></script>
	<title>Listar Administradores</title>
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
				<div class="search-container">
					<button type="button" id="searchButton">
						<i class="bi bi-search"></i>
						<input type="text" id="searchInput" placeholder="Pesquisar...">
					</button>
					<img src="../fotos/usuario.png" alt="Barra de Carregamento do usuario" />
				</div>
			</header>


			<!-- <nav class="breadcrumb">
          <div class="phases">
            <p>Produtos</p>
            <p>Equipe</p>
          </div>
				</nav> -->

			<div class="cadastro">
				<button id="button_register" onclick="window.location.href = '../ADMINISTRADOR/cadastrar_administrador.php'">
					<i class="bi bi-person-add"></i>
					Cadastrar Administrador
				</button>
			</div>

			<section class="list">
				<table border="1" class="table_container">
					<thead class="table_head">
						<tr class="table_title">
							<td>ID</td>
							<td>Nome</td>
							<td>E-mail</td>
							<td>Senha</td>
							<td>Ativo</td>
							<td>Ações</td>
						</tr>
					</thead>
					<tbody class="table_body" id="table_body">
						<?php foreach ($administrador as $administradores) : // jogando de produtos para produto.
						?>
							<tr>
								<td><?php echo $administradores['ADM_ID']; ?></td>
								<td><?php echo $administradores['ADM_NOME']; ?></td>
								<td><?php echo $administradores['ADM_EMAIL']; ?></td>
								<td><?php echo $administradores['ADM_SENHA']; ?></td>
								<td id="ativo"><?php echo ($administradores['ADM_ATIVO'] == '0' ? "<p class='inactive''> <i class='bi bi-circle-fill'></i> </p> " : "<p class='active'> <i class='bi bi-circle-fill'></i> </p>") ?></td>
								<td class="acoes">
									<a href="editar_adm.php?id=<?php echo $administradores['ADM_ID']; ?>"> <i class="bi bi-pencil-square active"></i> </a>
									<button id="button_delet" onclick="confirm()"> <i class="bi bi-trash3-fill delet_color"></i> </button>
									<!-- <button id="button_delet" >
										<i class="bi bi-trash3-fill delet_color"></i>
									</button> -->
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</section>
		</section>
	</main>

	<div id="modal_close" class="modal">
		<div class="modal-content">
			<div class="close_x">
				<span onclick="fechar()">&times;</span>
			</div>
			<h3 class="modal_title">Deseja excluir este Jogador?</h3>
			<a id="yes" href="excluir_adm.php?id=<?php echo $administradores['ADM_ID']; ?>">Sim</a>
			<button id="no" onclick="fechar()">Não</button>
		</div>
	</div>

</body>

</html>