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
	
	#query que verifica se o character inserido já existe na tabela
	$sql_validar ='SELECT charname FROM characters WHERE charname ="'.$_POST['charname'].'"';
				
	#prepara um comando para execucao
	$query_validar=$ligacao->query($sql_validar);
				
	#FETCH_ASSOC: retorna um array indexado pelo nome da coluna
	$resultado=$query_validar->fetch(PDO::FETCH_ASSOC);	
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
				
				#comando sql para a inserção de dados no campos da tabela
				$sql="INSERT INTO characters(charname, classname, classlvl, classAP, classDP, idplayer) VALUES(:charname, :classname, :classlvl, :classAP, :classDP, :family)";
				
				$query=$ligacao->prepare($sql); #prepara um comando para execucao
				
				#vinculação dos campos da tabela aos campos do formulário
				$query->bindParam(':charname',$_POST['charname']);
				$query->bindParam(':classname',$_POST['classname']);
				$query->bindParam(':classlvl',$_POST['classlvl']);
				$query->bindParam(':classAP',$_POST['classAP']);
				$query->bindParam(':classDP',$_POST['classDP']);
				$query->bindParam(':family',$_POST['family']);
				
				$query->execute(); #metodo usado para executar a declaracao
		
				#reencaminha para a pagina de consulta dos characters
				include_once 'index.php';

				#echo retornado caso o registo seja efetuado
				echo '<center><h3 style="background-color: green; color: white; width:16% ">Character registado com sucesso!</h3></center>';
			}
			else{
				#volta a incluir a pagina de registo caso exista um registo com o mesmo nome
				include_once 'characters-inserir.php';

				#echo retornado caso exista um registo com o mesmo nome
				echo '<center><h3 style="background-color: red; width:14% ">Nome do character já se encontra em uso!</h3></center><br>';
			}
		?>
	<br><br><br>
	</section>
	<?php
	include_once'../includes/footer.php';
	?>
</body>
</html>