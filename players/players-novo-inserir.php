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
	$sql = "SELECT * FROM users";
	
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
			<h1 align="center">Painel de Administração | Familia</h1>

			<br>

			<?php
			include_once'../includes/players-menu.php';
			?>

			<br>
			<h2 style="color: red;">NOVO MEMBRO</h2>

		</header>
		

		<section>

			<form align="center" action="players-novo-inserir-db.php" method="POST">
				
				<label><b>Nome de familia:</b></label><br>
					<input type="text" name="familyname" placeholder="&nbsp;&nbsp;Inserir nome de familia" required/><br><br>
					<input type="hidden" name="idplayer" required/>			
				
				<label><b>Nome do Character:</b></label><br>
					<input type="text" name="charname" placeholder="&nbsp;&nbsp;Inserir nome do character"  / required><br><br>
				
				<label><b>Classe:</b></label><br>
					<select name="classname" required>
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
					
					&nbsp;&nbsp;<input type="text" name="classlvl" placeholder=" Nivel" maxlength="2" size="1" required/>&nbsp;&nbsp;
					
					<input type="text" name="classAP" placeholder="  AP" maxlength="3" size="1" required/>&nbsp;&nbsp;
						
					<input type="text" name="classDP" placeholder="  DP" maxlength="3" size="1" required/>

				<br><br>

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
					<input type="text" name="energy" placeholder="&nbsp;&nbsp;&nbsp;Energia" maxlength="3"  size="6" required/><br><br>
				

				<label><b>Utilizador:</b></label><br>
					<select name="users">
						<?php #imprimir os resultados retornados
							foreach($resultado as $users){ 
								echo "<option value=".$users['iduser'].">".$users['username']."</option>";
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