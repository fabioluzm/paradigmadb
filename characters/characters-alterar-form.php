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
	$sql = "SELECT characters.idchar AS idchar, characters.charname AS charname, characters.classname as classname, characters.classlvl AS classlvl, characters.classAP AS classAP,
	characters.classDP AS classDP, characters.idplayer AS idplayer, players.familyname AS familyname 
	FROM characters, players WHERE players.idplayer = characters.idplayer AND idchar=".$_GET['id'];
	
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
			<h1>Painel de Administração | Character</h1>
			<br>

			<?php
				#inclusão do menu de utilizadores
				include_once'../includes/players-menu.php';
			?>

			<br>
				
			<nav>
				<a href="characters-inserir.php">NOVO CHARACTER</a> |
				<a href="characters-alterar-eliminar.php">ALTERAR/ELIMINAR</a>
			</nav>

		</header>
		
		<section>
		
			<br><br><br>

			<form align="center" action="characters-alterar-db.php" method="POST">

				<input type="hidden" name="idchar" value="<?php echo $resultado['idchar']?>" />
				
				<label><b>Nome do Character:</b></label><br>
					<input type="text" name="charname" value="<?php echo $resultado['charname']?>" required/><br><br>
				
				<label><b>Classe:</b></label><br>
					<select name="classname" required>
						<option value="<?php echo $resultado['classname'];?>" selected><?php echo $resultado['classname']?></option>
						<option value="Warrior" >Warrior</option>
						<option value="Ranger">Ranger</option>
						<option value="Sorceress">Sorceress</option>
						<option value="Berserker">Berserker</option>
						<option value="Tamer">Tamer</option>
						<option value="Striker">Striker</option>
						<option value="Musa">Musa</option>
						<option value="Maehwa">Maehwa</option>
						<option value="Valkyrie">Valkyrie</option>
						<option value="Kunoichi">Kunoichi</option>
						<option value="Ninja">Ninja</option>
						<option value="Dark_Knight">Dark Knight</option>
						<option value="Wizard">Wizard</option>
						<option value="Witch">Witch</option>
					</select><br><br>		


				<label><b>Nivel:&nbsp;&nbsp;</b></label>
				
				<label><b>&nbsp;&nbsp;AP:</b></label>
				
				<label><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DP:</b></label><br>
					
					&nbsp;&nbsp;<input type="text" name="classlvl" value="<?php echo $resultado['classlvl']?>" maxlength="2" size="1" required/>&nbsp;&nbsp;
					
					<input type="text" name="classAP" value="<?php echo $resultado['classAP']?>" maxlength="3" size="1" required/>&nbsp;&nbsp;
						
					<input type="text" name="classDP" value="<?php echo $resultado['classDP']?>" maxlength="3" size="1" required/>

					<br><br>
				
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
		
			<br><br><br>

		</section>

		<?php
		include_once'../includes/footer.php';
		?>

	</center>
</body>
</html>