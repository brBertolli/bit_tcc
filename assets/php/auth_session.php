<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    $_SESSION['erro'] = "Sessão expirada. Faça login novamente!";
    header("location: ../index.php");
    exit;
}

function allowedUser()
{
    if (isset($_SESSION['cargo']) && ($_SESSION['cargo'] == 'Administrador' || $_SESSION['cargo'] == 'Suporte')) {
        return true;
    } else {
        return false;
    }
}
?>