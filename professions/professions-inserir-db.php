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
	
	#comando sql de inserção de dados nos campos da tabela
	$sql="INSERT INTO professions(profname, proflvl, energy, idplayer) VALUES(:profname, :proflvl, :energy, :family)";
	
	$query=$ligacao->prepare($sql); #prepara um comando para execucao
	
	#parametros de vinculação aos campos da tabela
	$query->bindParam(':profname',$_POST['profname']);
	$query->bindParam(':proflvl',$_POST['proflvl']);
	$query->bindParam(':energy',$_POST['energy']);
	$query->bindParam(':family',$_POST['family']);
	
	$query->execute(); #metodo usado para executar a declaracao

	
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
			if($query->rowCount() > 0){
	
		
				#inclui pagina de consulta das profissões
				include_once 'index.php';

				#echo retornado caso o registo seja efetuado
				echo '<center><h3 style="background-color: green; color: white; width:16% ">Profissão registada com sucesso!</h3></center>';
			}
			else{
				#volta a incluir a pagina de registo caso não seja possivel registar a profissão
				include_once 'professions-inserir.php';

				#echo retornado caso não seja possivel registar a profissão
				echo '<center><h3 style="background-color: red; width:14% ">Não foi possivel registar a profissão!</h3></center><br>';
			}
		?>
	<br><br><br>
	</section>
	<?php
	include_once'../includes/footer.php';
	?>
</body>
</html>