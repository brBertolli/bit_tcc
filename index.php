<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['id'])) {
    header("location: pages/dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Login</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.ico">

    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="container">
        <img src="assets/img/logo_bit_200x100.png" alt="LOGO">
        <div class="login-form">
            <form action="assets/php/login.php" method="POST">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <p class="login-erro">
                    <?php
                    if (isset($_SESSION['erro'])) {
                        echo $_SESSION['erro'];
                        unset($_SESSION['erro']);
                    }
                    ?>
                </p>
                <button type="submit" name="submit">Entrar</button>

            </form>
        </div>
    </div>

    <footer>
        <p class="site-name">Bertolli Info Technology</p>
        <p class="copyright">Copyright © 2023 - Todos os direitos reservados.</p>
    </footer>
</body>

</html>