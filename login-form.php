<?php 

	#previne a criação de uma sessão, se já existir uma sessão criada
	#caso contrario cria uma sessão
	if (!isset($_SESSION)) {	
		session_start();
	}
 ?>
 
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<h1 align="center">Login</h1>

	<form align="center" action="login-db.php" method="POST">
		<label><b>Utilizador:</b></label><br>
		<input type="text" name="username" placeholder="Nome de Utilizador" required><br><br>
		
		<label><b>Password:</label></b><br>
		<input type="password" name="password" placeholder="Palavra-passe" required><br><br><br>
		
		<button type="submit">Login</button>
		<a href="registar-form.php"><button type="button">Registar</button></a>
	</form>

<br><br><br>

<?php
	#inclusão do footer
	include_once'includes/footer.php';
?>

</body>
</html>