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
	$sql  = 'SELECT players.familyname AS familyname, characters.charname AS name, characters.classname AS classname, characters.classlvl AS level FROM players, characters WHERE players.idplayer = characters.idplayer ORDER BY classname ASC';
	
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
			<h1>Painel de Administração | Paradigma</h1>
			<br>

			<?php
			#inclusão do menu de utilizadores
			include_once'../includes/players-menu.php';
			?>
			
			<br>
			<nav>
				<a href="players-novo-inserir.php">NOVO MEMBRO</a>
			</nav>

		</header>

		<section>

			<br><br>
			
			<table>
				<tr>
					
					<th >|-- Familia --|</th>
					<th>|-- Character --|</th>
					<th>|-- Classe --|</th>
					<th>|-- Nivel --|</th>					
					
				</tr>
				<?php 
					#adiciona uma linha em branco
					echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

					#imprimir os resultados retornados
					foreach($resultado as $players){ 
						echo "<tr align='center'>
								<td>".$players['familyname']."</td>
								<td>".$players['name']."</td>
								<td><strong>".$players['classname']."</strong></td>
								<td>".$players['level']."</td>
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