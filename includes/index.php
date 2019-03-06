<?php
	#este ficheiro foi criado como protocolo de segurança da pasta includes
	
	#se não existir uma sessao com estas credenciais é redirecionado para a pagina logout
	if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
		
		#redirecionamento para a pagina de logout
		header("location: ../logout.php");
	}
