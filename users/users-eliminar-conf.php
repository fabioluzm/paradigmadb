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

?>

<!DOCTYPE html>
<html>
<head>
	<title>Painel de Administração | Utilizadores</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<center>
	
		<h1>Painel de Administração | Eliminar Utilizador</h1>

		<?php
			#inclusão do menu
			include_once'../includes/users-menu.php';
			
			#echo da mensagem ao dono da sessão
			echo '<center><h3 style="background-color: red; color: yellow; width:27% ">'.$_SESSION['username'].', tem a certeza que deseja eliminar o utilizador?<br>Este não poderá ser recuperado!</h3></center><br>';
		
			#echo do butao de confirmação da eliminação do user que está dentro do $_GET['id']
			echo "<form action='users-eliminar-db.php?id=".$_GET['id']."' method='POST'>
    				<input type='submit' name='sim' value='Sim'>
				</form>"
		?>
		<br>

		<!-- formulario de redirecionamento caso não seja desejada a eliminação -->
		<form action="users-alterar-eliminar.php" method="POST">
    		<input type="submit" name="não" value="Não">
		</form>

	

		<br>
		<br>
		<br>

		<?php
			#inclusão do footer
			include_once'../includes/footer.php';
		?>
	</center>
</body>
</html>