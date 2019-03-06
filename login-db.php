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
<?php 

	#conexao à base de dados
	require_once 'includes/ligacao-db.php';

	#comando sql para consulta da tabela dos users onde o username e a password são iguais ao que foi digitado no formulario					
	$sql ='SELECT * FROM users WHERE username ="'.$_POST['username'].'" and password ="'.$_POST['password'].'"';
		
	#executa a query a base de dados
	$query=$ligacao->query($sql);
		

	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	#verificação se existe ou não um resultado na base de dados correspondentes à consulta
	if (!$resultado=$query->fetch(PDO::FETCH_ASSOC)){

		#volta a incluir a pagina de login caso a combinação de utilizador/password esteja incorreta
		include_once 'login-form.php';

		#echo retornado caso a combinação de utilizador/password esteja incorreta
		echo '<center><h3 style="background-color: red; width:15% ">Utilizador/Password incorretos!<br>Tente Novamente!</h3></center><br>';
    }
	else {
		
		#criação de uma nova sessão com as credenciais escolhidas
		$_SESSION['username'] = $_POST['username'];
	    $_SESSION['password'] = $_POST['password'];

	    #condiçao que verifica se existe uma sessão criada com as credenciais escolhidas
	    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		
		#redireciona para a pagina index.php caso o login e a sessão sejam bem sucedidos
	    header("location: index.php");

	    }
	    
	}
?>
</body>
</html>