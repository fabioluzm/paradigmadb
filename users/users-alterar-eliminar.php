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
	<title>Painel de Administração | Utilizadores</title>

</head>
<body>
	<center>
		<header>
			<h1>Painel de Administração | Alterar/Eliminar Utilizador</h1>
			<br>

			<?php
			#inclusão do menu de utilizadores
			include_once'../includes/users-menu.php';
			?>

		</header>

		<section>

			<br><br><br>
			
			<table>
				<tr>
					<th style="visibility:hidden;"></th>
					<th>Utilizador</th>
					
				</tr>
				<?php 
					#adiciona uma linha em branco
					echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";

					#imprimir os resultados retornados da consulta
					foreach($resultado as $users){ 
						echo "<tr>
								<td style='visibility:hidden;'>".$users['iduser']."</td>
								<td>".$users['username']."</td>
								<td><a href='users-alterar-form.php?id=".$users['iduser']."'>
								<input type='button' value='Alterar'/></a>
								<td><a href='users-eliminar-conf.php?id=".$users['iduser']."'>
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