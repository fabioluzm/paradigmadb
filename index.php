<?php
	
	#previne a criação de uma sessão, se já existir uma sessão criada
	#caso contrario cria uma sessão
	if (!isset($_SESSION)) {	
		session_start();
	}
	
	#se não existir uma sessao com estas credenciais é redirecionado para a pagina logout
	if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
	
	#redirecionamento para a pagina de logout
	header("location: logout.php");
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Painel de Administração</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<center>
		<h1>Painel de Administração</h1>


		<?php

		#condiçao que verifica se existe uma sessão criada com as credenciais escolhidas
		if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
			
			#echo de boas vindas ao user que faz login
			echo '<center><h3 style="background-color: green; color: white; width:11% ">Bem vindo, '.$_SESSION['username'].'!</h3></center>';

		}

		?>

		<br>
	
		<form action="users/index.php" method="POST">
    		<input type="submit" name="admuser" value="<<< Administração de Utilizadores">
		</form>

		<br>
		<br>


		<form action="players/index.php" method="POST">
    		<input type="submit" name="admplayer" value="Administração de Jogadores  >>>">
		</form>

		<br>
		<br>

		<form action="logout.php" method="POST">
    		<input type="submit" name="logout" value="Terminar a sessão!">
		</form>
	</center>

	<br>
	<br>
	<br>

	<?php
		#inclusão do footer
		include_once'includes/footer.php';
	?>

</body>
</html>