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
			
			#condição que retorna o nr de linhas afetadas pelo ultimo ISERT, UPDATE ou DELETE
			#caso o valor for 0 faz a inserção do registo
			if($query_validar->rowCount() == 0){
	
				#comando sql para a alteração dos campos da tabela	
				$sql="UPDATE characters SET charname = :charname, classname = :classname, classlvl = :classlvl, classAP = :classAP, classDP = :classDP, idplayer = :family WHERE idchar = :id";
				
				$query=$ligacao->prepare($sql); #prepara um comando para execucao
				
				#vinculação dos campos da tabela aos campos do formulario
				$query->bindParam(':id',$_POST['idchar']);
				$query->bindParam(':charname',$_POST['charname']);
				$query->bindParam(':classname',$_POST['classname']);
				$query->bindParam(':classlvl',$_POST['classlvl']);
				$query->bindParam(':classAP',$_POST['classAP']);
				$query->bindParam(':classDP',$_POST['classDP']);
				$query->bindParam(':family',$_POST['family']);
				
				$query->execute(); #metodo usado para executar a declaracao
				
				#inclui a pagina de consulta
				include_once 'index.php';

				#echo retornado caso o registo seja efetuado
				echo '<center><h3 style="background-color: green; color: white; width:16% ">Character alterado com sucesso!</h3></center>';
			}
			else{
				#volta a incluir a pagina de alterar/eliminar caso não seja possivel fazer a alteração
				include_once 'characters-alterar-eliminar.php';
					
				#echo retornado caso não seja possivel fazer a alteração
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