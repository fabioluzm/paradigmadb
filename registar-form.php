<!DOCTYPE html>
<html>
<head>
	<title>Registar</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<h1 align="center">Registar</h1>

	<form align="center" action="registar-db.php" method="POST">
		<label><b>Nome de utilizador:</b></label><br>
			<input type="text" name="username" placeholder="Nome de Utilizador" required><br><br>

		<label><b>Inserir Password :</b></label><br>
			<input type="password" name="password1" placeholder="Insira palavra-passe" required><br><br>
		
		<label><b>Confirmar Password:</b></label><br>
			<input type="password" name="password2" placeholder="Confirme palavra-passe" required><br><br><br>
		
		<button type="submit">Registar</button>
		<a href="login-form.php"><button type="button"> << Voltar </button></a>
	</form>

	<br><br><br>

<?php
	#inclusão do footer
	include_once'includes/footer.php';
?>

</body>
</html>