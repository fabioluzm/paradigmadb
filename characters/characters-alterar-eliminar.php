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
	$sql = 'SELECT * FROM characters ORDER BY classlvl DESC';
	
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

			<br><br>
			<!-- Tabela de resultados -->
			<table>
				<tr>
					
					<th>|-- Character --|</th>
					<th>|-- Classe --|</th>
					<th>|-- Nivel --|</th>
					<th>|-- AP --|</th>
					<th>|-- DP --|</th>
								
					
				</tr>
				<?php 
					#adiciona uma linha em branco
					echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

					#imprimir os resultados retornados
					foreach($resultado as $characters){ 
						echo "<tr align='center'>
								<td>".$characters['charname']."</td>
								<td>".$characters['classname']."</td>
								<td>".$characters['classlvl']."</td>
								<td>".$characters['classAP']."</td>
								<td>".$characters['classDP']."</td>
								<td><a href='characters-alterar-form.php?id=".$characters['idchar']."'>
								<input type='button' value='Alterar'/></a>
								<td><a href='characters-eliminar-conf.php?id=".$characters['idchar']."'>
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