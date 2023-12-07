<?php
// Sair da conta de sistema


//Destruir as variáveis de sessão
session_start();
session_unset();
session_destroy();

// Redirecionamento para a página principal
header("location: ../../index.php");
?>