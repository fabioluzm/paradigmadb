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

	#ligacao a base de dados
	require_once'../includes/ligacao-db.php';
	
	#comando sql para consulta 
	$sql = "SELECT * FROM users WHERE iduser=".$_GET['id'];
	
	#executa a query a base de dados
	$query=$ligacao->query($sql);
	
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query->fetch(PDO::FETCH_ASSOC);
	
	
?>

<!DOCTYPE html>
<html lang=pt-pt>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Painel de Administração | Utilizadores</title>	
</head>
<body>
	<header>
		<h1 align="center">Painel de Administração | Alterar Utilizador</h1>
		<?php
		include_once'../includes/users-menu.php';
		?>
	</header>
	<section>
	<br><br><br>
		<form align="center" action="users-alterar-db.php" method="POST">
			<input type="hidden" name="iduser" value="<?php echo $resultado['iduser']?>" />
			
			<label><b>Nome de utilizador:</b></label><br>
			<input type="text" name="username" value="<?php echo $resultado['username']; ?>" required /><br><br>

			<label><b>Inserir Password:</b></label><br>
			<input type="password" name="password1" value="<?php echo $resultado['password']; ?>" required/><br><br>

			<label><b>Confirmar Password:</b></label><br>
			<input type="password" name="password2" value="<?php echo $resultado['password']; ?>" required /><br><br>

			<input type="submit" value="Atualizar" />
		</form>
	<br><br><br>
	</section>
	<?php
	include_once'../includes/footer.php';
	?>
</body>
</html>