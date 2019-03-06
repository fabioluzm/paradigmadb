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
	$sql = 'SELECT players.familyname AS familyname, professions.idprof AS idprof, professions.profname AS profname, professions.proflvl AS proflvl, professions.energy AS energy 
	FROM players, professions WHERE players.idplayer = professions.idplayer ORDER BY profname ASC';
	
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
			<h1>Painel de Administração | Profissão</h1>
			<br>

			<?php
			#inclusão do menu de utilizadores
			include_once'../includes/players-menu.php';
			?>
			
			<br>
			<nav>
				<a href="professions-inserir.php">NOVA PROFISSÃO</a> |
				<a href="professions-alterar-eliminar.php">ALTERAR/ELIMINAR</a>
			</nav>

		</header>

		<section>

			<br><br>
			
			<table>
				<tr>
					
					<th>|-- Familia --|</th>
					<th>|-- Profissão --|</th>
					<th>|-- Rank --|</th>
					<th>|-- Energia --|</th>
								
					
				</tr>
				<?php 
					#adiciona uma linha em branco
					echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

					#imprimir os resultados retornados
					foreach($resultado as $professions){ 
						echo "<tr align='center'>
								<td>".$professions['familyname']."</td>
								<td>".$professions['profname']."</td>
								<td>".$professions['proflvl']."</td>
								<td>".$professions['energy']."</td>
								<td><a href='professions-alterar-form.php?id=".$professions['idprof']."'>
								<input type='button' value='Alterar'/></a>
								<td><a href='professions-eliminar-conf.php?id=".$professions['idprof']."'>
								<input type='button' value='Eliminar'/></a>
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