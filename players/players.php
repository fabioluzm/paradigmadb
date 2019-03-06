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
	
	#comando sql para consulta de todos os campos, mais a função soma dos campos (classAP+classDP)
	$sql  = 'SELECT *,(classAP+classDP) AS gearscore FROM players, characters, professions WHERE players.idplayer = characters.idplayer AND players.idplayer = professions.idplayer ORDER BY familyname ASC';
	
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

			<br><br>
			
			<table>
				<tr>
					
					<th >|-- Familia --|</th>
					<th>|-- Character --|</th>
					<th>|-- Classe --|</th>
					<th >|-- Nivel --|</th>
					<th>|-- AP --|</th>
					<th>|-- DP --|</th>
					<th >|-- Gear Score --|</th>
					<th>|-- Profissão --|</th>
					<th>|-- Rank --|</th>
					<th >|-- Energia --|</th>					
					
				</tr>
				<?php 
					#adiciona uma linha em branco
					echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

					#imprimir os resultados retornados
					foreach($resultado as $players){ 
						echo "<tr align='center'>
								<td><strong>".$players['familyname']."</strong></td>
								<td>".$players['charname']."</td>
								<td>".$players['classname']."</td>
								<td>".$players['classlvl']."</td>
								<td>".$players['classAP']."</td>
								<td>".$players['classDP']."</td>
								<td>".$players['gearscore']."</td>
								<td>".$players['profname']."</td>
								<td>".$players['proflvl']."</td>
								<td>".$players['energy']."</td>
								
							 </tr>";
					}
				?>	
			</table>

			<br><br><br>
			
			<form action="../index.php" method="POST">
    			<input type="submit" name="admuser" value="Voltar ao Painel de Administração Principal">
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