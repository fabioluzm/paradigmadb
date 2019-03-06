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

<?php 
	
	#conexao à base de dados
	require_once '../includes/ligacao-db.php';

	#query que verifica se o user inserido já existe na base de dados
	$sql_validar ='SELECT username FROM users WHERE username ="'.$_POST['username'].'"';
	
	#prepara um comando para execucao
	$query_validar=$ligacao->query($sql_validar);
	
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query_validar->fetch(PDO::FETCH_ASSOC);

	

	#condição que valida a inserção dos dados em caso de ainda não exista
	#em caso de o utilizador não existir, ou seja, o valor for 0, faz a inserção de um novo registo
	if($query_validar->rowCount() == 0){
			
		#condição if que compara se os dois campos de password são iguais
		if($_POST['password1']==$_POST['password2']){

			#query de inserção na base de dados
			$sql="INSERT INTO users(username, password) VALUES(:username , :password)";
				
			$query=$ligacao->prepare($sql); #prepara um comando para execucao	
			
			#vinculação dos valores inseridos no formulario, aos campos da base de dados	
			$query->bindParam(':username',$_POST['username']);
			$query->bindParam(':password',$_POST['password1']);
			
			$query->execute(); #metodo usado para executar a declaracao
			
			#inclui a pagina de login
			include_once 'index.php';

			#echo retornado caso o registo seja efetuado
			echo '<center><h3 style="background-color: green; color: white; width:11% ">Registo efetuado!</h3></center>';
		}
		else {
			
			#volta a incluir a pagina de registo caso as duas passwords não sejam iguais
			include_once 'users-inserir.php';

			#echo retornado caso as duas passwords não sejam iguais
			echo '<center><h3 style="background-color: red; width:16% ">As palavras-passe não coincidem!</h3></center><br>';
		}
	}
	else{

		#volta a incluir a pagina de registo caso exista um registo com o mesmo nome
		include_once 'users-inserir.php';

		#echo retornado caso exista um registo com o mesmo nome
		echo '<center><h3 style="background-color: red; width:11% ">O utilizador já existe!</h3></center><br>';
	}
?>
</body>
</html>