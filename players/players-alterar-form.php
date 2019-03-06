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
	$sql = "SELECT * FROM players WHERE idplayer=".$_GET['id'];
	
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
	<title>Painel de Administração | Jogadores</title>	
</head>
<body>
	<center>
		<header>
			<h1>Painel de Administração | Familia</h1>
			<br>

			<?php
				#inclusão do menu de utilizadores
				include_once'../includes/players-menu.php';
			?>

			<br>
				
			<nav>
				<a href="players-novo-inserir.php">NOVA FAMILIA</a> |
				<a href="players-alterar-eliminar.php">ALTERAR/ELIMINAR</a>
			</nav>

		</header>
		
		<section>
		
			<br><br><br>
			
			<form align="center" action="players-alterar-db.php" method="POST">
				
				<input type="hidden" name="idplayer" value="<?php echo $resultado['idplayer']?>" />
				
				<input type="text" name="familyname" value="<?php echo $resultado['familyname']; ?>" required/>
				
				<input type="submit" value="Atualizar" />
			
			</form>
		
			<br><br><br>

		</section>

		<?php
		include_once'../includes/footer.php';
		?>

	</center>
</body>
</html>