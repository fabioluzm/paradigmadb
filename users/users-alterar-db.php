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

	#conexao à base de dados
	require_once '../includes/ligacao-db.php';
	#comando sql para consulta da tabela
	$sql_validar = 'SELECT username FROM users WHERE username ="'.$_POST['username'].'"';
	
	#executa a query a base de dados
	$query_validar=$ligacao->query($sql_validar);
	
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query_validar->fetch(PDO::FETCH_ASSOC);	

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

		<?php 
			
			#condição que valida a inserção dos dados em caso de ainda não exista
			#em caso de o utilizador não existir, ou seja, o valor for 0, faz a inserção de um novo registo	
			if ($query_validar->rowCount() == 0) {
										
				#condição if que compara se os dois campos de password são iguais
				if($_POST['password1']==$_POST['password2']){

					#query para a alteração da base de dados
					$sql='UPDATE users SET username = :username, password = :password WHERE iduser = :id';
						
					$query=$ligacao->prepare($sql); #prepara um comando para execucao	
					
					#vinculação dos valores inseridos no formulario, aos campos da base de dados	
					$query->bindParam(':id',$_POST['iduser']);
					$query->bindParam(':username',$_POST['username']);
					$query->bindParam(':password',$_POST['password1']);
					
					$query->execute(); #metodo usado para executar a declaracao
					
					#inclui a pagina de consulta
					include_once 'index.php';

					#echo retornado caso o registo seja efetuado
					echo '<center><h3 style="background-color: green; color: white; width:16% ">Informação de Utilizador alterada!</h3></center>';
				}
				else {

					#inclui a pagina alterar/eliminar
					include_once 'users-alterar-eliminar.php';
					
					#echo retornado caso as duas passwords não sejam iguais
					echo '<center><h3 style="background-color: red; width:16% ">As palavras-passe não coincidem!</h3></center><br>';
				}
			}

			#processo que regista a alteração da password num user que já exista
			elseif ($_POST['password1']==$_POST['password2']) {

				#condição que serve para fazer a alteração da password de um utilizador
				$sql_pass='UPDATE users SET password = :password WHERE iduser = :id';

				$query_pass=$ligacao->prepare($sql_pass); #prepara um comando para execucao

				#vinculação dos valores inseridos no formulario, aos campos da base de dados	
				$query_pass->bindParam(':id',$_POST['iduser']);

				$query_pass->bindParam(':password',$_POST['password1']);
				
				$query_pass->execute(); #metodo usado para executar a declaracao
					
				#inclui a pagina de consulta
				include_once 'index.php';

				#echo retornado caso o registo seja efetuado
				echo '<center><h3 style="background-color: green; color: white; width:16% ">Password Alterada com sucesso!</h3></center>';
				echo '<center><h3 style="background-color: red; width:11% ">Utilizador em uso!</h3></center><br>';
			}
			else {

				#inclui a pagina alterar/eliminar
				include_once 'users-alterar-eliminar.php';
					
				#echo retornado caso as duas passwords não sejam iguais
				echo '<center><h3 style="background-color: red; width:16% ">As palavras-passe não coincidem!</h3></center><br>';
			}
		?>
	</center>
</body>
</html>