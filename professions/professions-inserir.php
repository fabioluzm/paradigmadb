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
	$sql = "SELECT * FROM players";
	
	#executa a query a base de dados
	$query=$ligacao->query($sql);
	
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query->fetchAll(PDO::FETCH_ASSOC);	

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
			<h1 align="center">Painel de Administração | Profissão</h1>

			<br>

			<?php
			include_once'../includes/players-menu.php';
			?>

			<br>

			<nav>
				<a href="professions-inserir.php">NOVA PROFISSÃO</a> |
				<a href="professions-alterar-eliminar.php">ALTERAR/ELIMINAR</a>
			</nav>
		</header>
		
		<br>
		<br>

		<section>

			<form align="center" action="professions-inserir-db.php" method="POST">
								
				<label><b>Profissão:</b></label><br>
					<select name="profname" required>
						<option value="Gathering" >Gathering</option>
						<option value="Processing">Processing</option>
						<option value="Cooking">Cooking</option>
						<option value="Alchemy">Alchemy</option>
						<option value="Training">Training</option>
						<option value="Fishing">Fishing</option>
						<option value="Hunting">Hunting</option>
						<option value="Trading">Trading</option>
						<option value="Farming">Farming</option>
						<option value="Sailing">Sailing</option>
					</select><br><br>


				<label><b>Rank:</b></label><br>
					<input type="text" name="proflvl" placeholder="&nbsp;&nbsp;&nbsp;ex: Master 2" size="10" required/><br><br>
				<label><b>Energia:</b></label><br>
					<input type="text" name="energy" placeholder="&nbsp;&nbsp;&nbsp;Energia" maxlength="3"  size="6" /><br><br>
				
				<br>
				
				<label><b>Familia:</b></label><br>
					
					<select name="family" required>
						<?php #imprimir os resultados retornados
							foreach($resultado as $family){ 
								echo "<option value=".$family['idplayer'].">".$family['familyname']."</option>";
							}
						?>
					</select>

				<br><br>
				
				<input type="submit" value="Inserir" />
			
			</form>
		
		</section>

		<br><br><br>

		<?php
		include_once'../includes/footer.php';
		?>
	</center>
</body>
</html>