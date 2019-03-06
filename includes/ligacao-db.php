<?php
	try{
		//variavel responsavel pela conexão feita à base de dados
		$ligacao=new PDO('mysql:host=localhost;dbname=paradigmadb;charset=utf8;',"root","");
		#echo "Ligação à base de dados estabelecida com sucesso!";
	}
	catch(PDOException $e){
		//apresenta mensagem de erro retornada
		die("Erro na ligação à base de dados: ".$e->getMessage()." || Erro: ".$e->getCode());
		#$e->getCode(); // apresenta código do erro retornado
	}
?>