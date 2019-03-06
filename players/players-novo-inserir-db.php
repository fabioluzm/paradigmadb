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
	
	#query que verifica se a familia inserida já existe na tabela
	$sql_validar ='SELECT familyname FROM players WHERE familyname ="'.$_POST['familyname'].'"';
	
	#prepara um comando para execucao
	$query_validar=$ligacao->query($sql_validar);
	
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query_validar->fetch(PDO::FETCH_ASSOC);
	
	
	#query que verifica se o character inserido já existe na tabela
	$sql_charvalidar ='SELECT charname FROM characters WHERE charname ="'.$_POST['charname'].'"';
				
	#prepara um comando para execucao
	$query_charvalidar=$ligacao->query($sql_charvalidar);
				
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query_charvalidar->fetch(PDO::FETCH_ASSOC);
	
?>

<!DOCTYPE html>
<html lang=pt-pt>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Painel de Administração | Jogadores</title>	
</head>
<body>
		<?php
			
			#condição que valida a inserção dos dados, caso ele ainda não exista
			#caso o valor for 0 faz a inserção do registo
			if($query_validar->rowCount() == 0){
				
				if($query_charvalidar->rowCount() == 0){
					
					#comando sql para inserir dados na tabela
					$sqlfamily='INSERT INTO players(familyname, iduser) VALUES(:familyname, :users)';
			
					$queryfamily=$ligacao->prepare($sqlfamily); #prepara um comando para execucao

					#parametros de vinculação aos campos da tabela
					$queryfamily->bindParam(':familyname',$_POST['familyname']);
					$queryfamily->bindParam(':users',$_POST['users']);

					$queryfamily->execute(); #metodo usado para executar a declaracao para a inserção da familia

					
					#variavel que armazena o ultimo ID auto incrementado da tabela para ser usado como referência de ligação
					#esta variavel é a responsavel pela relação entre a tabela PLAYERS e as tabelas CHARACTERS e PROFESSIONS durante o preenchimento do formulario
					$idplayer = $ligacao->lastInsertId();
				
				
					#comando sql para inserir dados na tabela				
					$sqlchar='INSERT INTO characters(charname, classname, classlvl, classAP, classDP, idplayer) VALUES(:charname, :classname, :classlvl, :classAP, :classDP, :idplayer)';
			
					$querychar=$ligacao->prepare($sqlchar); #prepara um comando para execucao

					#parametros de vinculação aos campos da tabela
					$querychar->bindParam(':charname',$_POST['charname']);
					$querychar->bindParam(':classname',$_POST['classname']);
					$querychar->bindParam(':classlvl',$_POST['classlvl']);
					$querychar->bindParam(':classAP',$_POST['classAP']);
					$querychar->bindParam(':classDP',$_POST['classDP']);
					$querychar->bindParam(':classDP',$_POST['classDP']);
					$querychar->bindParam(':idplayer',$idplayer); #parametro que usa o ID previamente criado na tabela players para fazer a relação
			
					$querychar->execute(); #metodo usado para executar a declaracao para a inserção do character
				

					#comando sql para inserir dados na tabela
					$sqlprof='INSERT INTO professions(profname, proflvl, energy, idplayer) VALUES(:profname, :proflvl, :energy, :idplayer)';
			
					$queryprof=$ligacao->prepare($sqlprof); #prepara um comando para execucao

					#parametros de vinculação aos campos da tabela
					$queryprof->bindParam(':profname',$_POST['profname']);
					$queryprof->bindParam(':proflvl',$_POST['proflvl']);
					$queryprof->bindParam(':energy',$_POST['energy']);
					$queryprof->bindParam(':idplayer',$idplayer); #parametro que usa o ID previamente criado na tabela players para fazer a relação
			
					$queryprof->execute(); #metodo usado para executar a declaracao para a inserção da profissão
			
					#reencaminha para o registo do character
					include_once 'players.php';

					#echo retornado caso o registo seja efetuado
					echo '<center><h3 style="background-color: green; color: white; width:14% ">Novo membro registado!</h3></center>';
				}
				else{
					#volta a incluir a pagina de registo caso exista um registo com o mesmo nome
					include_once 'players-novo-inserir.php';

					#echo retornado caso exista um registo com o mesmo nome
					echo '<center><h3 style="background-color: red; width:14% ">O nome do character ja se encontra em uso!</h3></center><br>';
				}
			}
			else{
				#volta a incluir a pagina de registo caso exista um registo com o mesmo nome
				include_once 'players-novo-inserir.php';

				#echo retornado caso exista um registo com o mesmo nome
				echo '<center><h3 style="background-color: red; width:14% ">O nome de familia em uso!</h3></center><br>';
			}
		?>
	<br><br><br>
	</section>
	<?php
	include_once'../includes/footer.php';
	?>
</body>
</html>