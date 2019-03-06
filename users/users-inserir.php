<?php
	
	#previne a criação de uma sessão, se já existir uma sessão criada
	#caso contrario cria uma sessão
	if (!isset($_SESSION)) {	
		session_start();
	}
	
	#se não existir uma sessao com estas credenciais é redirecionado para a pagina logout
	if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
	
	#redirecionamento para a pagina de logout
	header("location: ../logout.php");
	}

?>

<!DOCTYPE html>
<html lang=pt-pt>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Painel de Administração | Utilizadores</title>	
</head>
<body>
<center>
	<header>
		<h1>Painel de Administração | Registar Utilizador</h1>
			<br>

			<?php
				#inclusão do menu de utilizadores
				include_once'../includes/users-menu.php';
			?>

	</header>
	<section>

	<br><br><br>

		<form action="users-inserir-db.php" method="POST">
			<label><b>Nome de utilizador:</b></label><br>
				<input type="text" name="username" placeholder="Nome de Utilizador" required><br><br>

			<label><b>Inserir Password :</b></label><br>
				<input type="password" name="password1" placeholder="Insira palavra-passe" required><br><br>
			
			<label><b>Confirmar Password:</b></label><br>
				<input type="password" name="password2" placeholder="Confirme palavra-passe" required><br><br><br>
			
			<button type="submit">Criar novo utilizador</button>
	</form>
	
	<br><br>

	<form action="../index.php" method="POST">
		<button type="submit"> Voltar ao Painel de Administração Principal </button>
	</form>

	<br><br><br>

	</section>

	<?php
		#inclusão do footer
		include_once'../includes/footer.php';
	?>

</center>
</body>
</html>