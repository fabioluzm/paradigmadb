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
	#comando sql para consulta
	$sql_validar = 'SELECT familyname FROM players WHERE familyname ="'.$_POST['familyname'].'"';
	
	#executa a query a base de dados
	$query_validar=$ligacao->query($sql_validar);
	
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query_validar->fetch(PDO::FETCH_ASSOC);	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Painel de Administração | Jogadores</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<center>

		<?php
			#condição que valida a inserção dos dados, caso ele ainda não exista
			#caso o valor for 0 faz a inserção do registo 
			if ($query_validar->rowCount() == 0) {

				#comando sql para a alteração de dados na tabela
				$sql='UPDATE players SET familyname = :familyname WHERE idplayer = :id';
					
				$query=$ligacao->prepare($sql); #prepara um comando para execucao	
					
				#vinculação dos valores inseridos no formulario, aos campos da base de dados	
				$query->bindParam(':id',$_POST['idplayer']);
				$query->bindParam(':familyname',$_POST['familyname']);
					
				$query->execute(); #metodo usado para executar a declaracao
				
				#inclui a pagina de consulta das familias
				include_once 'players.php';

				#echo retornado caso o registo seja efetuado
				echo '<center><h3 style="background-color: green; color: white; width:16% ">Nome de familia alterado!</h3></center>';
			}
			else {

				#inclui a pagina de alterar/eliminar
				include_once 'players-alterar-eliminar.php';
					
				#echo retornado caso o nome de familia ja exista
				echo '<center><h3 style="background-color: red; width:14% ">Nome de Familia em uso!</h3></center><br>';
			}
		?>
	</center>
</body>
</html>