<?php
	#comandos de fim de sessão
	#ao destruir todas as sessões, reencaminha para a pagina de login
    session_start();
    session_destroy();
    header("Location: login-form.php");
?>