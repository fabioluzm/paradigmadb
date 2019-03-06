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
	$sql = "SELECT professions.idprof AS idprof, professions.profname AS profname, professions.proflvl AS proflvl, professions.energy AS energy, professions.idplayer AS idplayer, players.familyname AS familyname  FROM professions, players WHERE players.idplayer = professions.idplayer AND idprof=".$_GET['id'];
	
	#executa a query a base de dados
	$query=$ligacao->query($sql);
	
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query->fetch(PDO::FETCH_ASSOC);	

	#listagem de todas as familias excepto a do character selecionado para nao duplicar (sql que pertence ao select)
	$sql_players = "SELECT * FROM players WHERE idplayer <>".$resultado['idplayer'];
	$query_players=$ligacao->query($sql_players);
	$resultado_players=$query_players->fetchAll(PDO::FETCH_ASSOC);
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

			<form align="center" action="professions-alterar-db.php" method="POST">

				<input type="hidden" name="idprof" value="<?php echo $resultado['idprof']?>" />
								
				<label><b>Profissão:</b></label><br>
					<select name="profname" required>
						<option value="<?php echo $resultado['profname'];?>" selected><?php echo $resultado['profname']?></option>
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
					<input type="text" name="proflvl" value="<?php echo $resultado['proflvl']?>" size="10" required/><br><br>
				<label><b>Energia:</b></label><br>
					<input type="text" name="energy" value="<?php echo $resultado['energy']?>" maxlength="3"  size="6" required/><br><br>
				
				
				<label><b>Familia:</b></label><br>
					
					<select name="family" required>
					<?php
			            # primeira opção seleccionada (selected) referente ao registo 
			            echo "<option value='" . $resultado['idplayer'] . "' selected>" . $resultado['familyname'] . "</option>";
            
			            # listagem das familias, excepto a familia seleccionada
			            foreach ($resultado_players as $players) {
			                echo "<option value='" . $players['idplayer'] . "'>" . $players['familyname'] . "</option>";
			            }
					?>
					</select>

				<br><br>
				
				<input type="submit" value="Alterar" />
			
			</form>
		
		</section>

		<br><br><br>

		<?php
		include_once'../includes/footer.php';
		?>
	</center>
</body>
</html>