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

	#comando sql para apagar dados da tabela	
	$sql="DELETE FROM characters WHERE idchar =".$_GET['id'];
	
	$query=$ligacao->prepare($sql); #prepara um comando para execucao
	
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
			if ($query->rowCount() > 0) {
				#funcao que retorna o nr de linhas afetadas pelo ultimo DELETE
				#se o valor for superior a 0 significa que pelo menos um DELETE na base dados foi efetuado

				#inclui a pagina de consulta dos characters
				include_once 'index.php';

				#echo retornado caso o character seja eliminado
				echo '<center><h3 style="background-color: green; color: white; width:16% ">Character eliminado com sucesso!</h3></center>';

			}
			else {

				#inclui a pagina alterar/eliminar
				include_once 'characters-alterar-eliminar.php';
			
				#se o valor retornado for 0 significa que nenhuma operacao foi realizada na base de dados
				#echo da mensagem de erro se não foi possivel eliminar o character.
				echo '<center><h3 style="background-color: red; width:16% ">Erro na eliminação do Character!</h3></center><br>';
				
			}
		?>
	<br><br><br>

	<?php
	include_once'../includes/footer.php';
	?>
</body>
</html>