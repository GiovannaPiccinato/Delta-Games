<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="./CSS/stars.css">
	<link rel="stylesheet" href="./CSS/style_login_adm.css">
	<title>Login Administrador</title>
</head>
<body>
<div id="stars"></div>
<div id="stars2"></div>
<div id="stars3"></div>

<div class="container_form">
	<div class="box">
		<form action="./processalogin.php" method="post">
			<!-- <h2>Login</h2> -->
			<div class="logo"> 
				<img src="fotos/logo.png" alt="logo"> 
			</div>
			<div class="inputbx">
				<span></span>
				<label for="email"></label>
				<input type="text" id="email" name="email" placeholder="E-mail" required>
			</div>

			<div class="inputbx">
				<span></span>
				<label for="senha"></label>
				<input type="password" id="senha" name="senha" placeholder="Senha" required>
			</div>


			<div class="form_box">
						<input class="register" type="submit" value="Entrar"  >
					</div>
<!-- 
			<div class="group">
				<a href="./cadastro_adm.php">Cadastrar-se</a>
			</div> -->
            <?php
            if(isset($_GET['erro'])){
            echo '<p style="color:red;">Nome de usuário ou senha incorretos!</p>';
            }
            ?>
		</form>
	</div>
</div>


</body>
</html>