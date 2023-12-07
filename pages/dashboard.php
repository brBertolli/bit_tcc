<?php
require_once('../assets/php/auth_session.php');

// Mensagem de Alerta para formulários
$formMessage = null;
if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    if ($status == 'success') {
        $formMessage = "<h1 class='alert alert-success'>Cliente cadastrado com sucesso!</h1>";
    } else {
        $formMessage = "<h1 class='alert alert-danger'>Erro ao cadastrar cliente.</h1>";
    }
    unset($_SESSION['status']);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/logo.ico">

    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/style.css">


    <script src="../assets/js/jquery/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/jquery/jquery.maskMoney.min.js"></script>
    <script src="../assets/js/jquery/jquery.mask.min.js"></script>
    <script src="../assets/js/modal.js"></script>

</head>

<body>

    <header>
        <div class="user-primary-info">
            <a class="user-profile-img " href="?perfil">
                <img src="<?php $_img ?>" alt="">
            </a>
            <div class="user-identify">
                <a class="user-info user-name" href="">Nome:
                    <p>
                        <!-- Escaping Output para evitar ataques de cross-site scripting (XSS) -->
                        <?php echo htmlspecialchars($_SESSION['nome']);
                        ?>
                    </p>
                </a>
            </div>
        </div>
        <img class="logo restore-default-content" src="../assets/img/logo_bit_200x100.png" alt="Logo">







        <div>
            <a class="logout-button" href="../assets/php/exit.php">Sair</a>

            <div class="mobile-menu" id="mobileMenu">
                <div class="ref-icon" id="refIcon">

                    <div class="mobile-menu-icon" id="mobileMenuIcon">
                        <div class="mobile-central-bar" id="mobileMenuBar"></div>
                    </div>
                </div>

                <div class="mobile-menu-items" id="mobileMenuItems">
                    <h1 class="mobile-menu-title restore-default-content" id="mobileMenuTitle">Painel de Controle</h1>
                    <ul class="mobile-menu-list">
                        <h2>Cadastro</h2>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#cadastro/exemplo">Exemplo</a></li>';
                        }
                        ?>
                        <li><a class="menu-item" href="#cadastro/cliente">Cliente</a></li>
                        <li><a class="menu-item" href="#cadastro/ordem-de-servico">Ordem de Serviço</a></li>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#cadastro/funcionario">Funcionário</a></li>';
                        }
                        ?>
                        <li><a class="menu-item" href="#cadastro/peca">Peças</a></li>
                    </ul>
                    <ul class="mobile-menu-list">
                        <h2>Controle</h2>
                        <li><a class="menu-item" href="#controle/clientes">Clientes</a></li>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#controle/funcionarios">Funcionários</a></li>';
                        }
                        ?>
                        <li><a class="menu-item" href="#controle/ordem-de-servico">Ordem de Serviço</a></li>
                        <li><a class="menu-item" href="#controle/recebimentos">Recebimentos</a></li>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#controle/peca">Peças</a></li>';
                        }
                        ?>
                    </ul>
                    <a class="mobile-logout" href="../assets/php/exit.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>










    </header>
    <main>








        <!-- Menu Desktop -->
        <div class="desktop-menu" id="desktopMenu">
            <div class="desktop-menu-header">
                <!-- Header para Titulo e Icon -->
                <h1 class="desktop-menu-title restore-default-content" id="desktopMenuTitle">Painel de Controle</h1>
                <div class="desktop-menu-icon" id="desktopMenuIcon">
                    <div class="desktop-central-bar" id="desktopMenuBar"></div>
                </div>
            </div>
            <?php
            if (isset($_SESSION['cargo'])) {
                ?>
                <div class="desktop-menu-items" id="desktopMenuItems">
                    <ul class="desktop-menu-list">
                        <h2>Cadastro</h2>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#cadastro/exemplo">Exemplo</a></li>';
                        }
                        ?>
                        <li><a class="menu-item" href="#cadastro/cliente">Cliente</a></li>
                        <li><a class="menu-item" href="#cadastro/ordem-de-servico">Ordem de Serviço</a></li>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#cadastro/funcionario">Funcionário</a></li>';
                        }
                        ?>
                        <li><a class="menu-item" href="#cadastro/peca">Peças</a></li>
                    </ul>
                    <ul class="desktop-menu-list">
                        <h2>Controle</h2>
                        <li><a class="menu-item" href="#controle/clientes">Clientes</a></li>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#controle/funcionarios">Funcionários</a></li>';
                        }
                        ?>
                        <li><a class="menu-item" href="#controle/ordem-de-servico">Ordem de Serviço</a></li>
                        <li><a class="menu-item" href="#controle/recebimentos">Recebimentos</a></li>
                        <?php if (allowedUser()) {
                            echo '<li><a class="menu-item" href="#controle/peca">Peças</a></li>';
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
            ?>

        </div>










        <!-- Conteúdo -->
        <div id="status"></div>

        <div class="content" id="content">
            <h1>Bem-vindo ao sistema</h1>
            <p>Olá,
                <?php echo $_SESSION['nome'] ?>! Esperamos que aproveite sua experiência.
            </p>
            <h2>Dicas Rápidas</h2>
            <ul>
                <li id="dica-01"></li>
                <li id="dica-02"></li>
                <li id="dica-03"></li>
                <li id="dica-04"></li>
                <li id="dica-05"></li>
            </ul>

            <p>Aproveite essas orientações para facilitar suas tarefas e assegurar a operação eficiente do sistema.</p>
            <h2>Sobre o Nosso Sistema</h2>
            <div class="feature">
                <p>Explore todas as possibilidades que nosso sistema de ponta oferece para otimizar as operações da sua
                    empresa. Nossa solução abrangente aborda diversos aspectos da gestão empresarial:</p>
                <ul>
                    <li><strong>Ordens de Serviço Eficientes:</strong> Gerencie suas ordens de serviço de maneira
                        eficaz, garantindo um fluxo de trabalho contínuo e organizado.</li>
                    <li><strong>Inventário Sempre Atualizado:</strong> Mantenha controle total sobre as peças e
                        componentes, evitando atrasos e interrupções desnecessárias.</li>
                    <li><strong>Segurança de Dados Priorizada:</strong> Assegure a confidencialidade dos dados dos
                        clientes e da empresa por meio de medidas de segurança avançadas.</li>
                    <li><strong>Agendamento Simplificado:</strong> Facilite a vida dos clientes permitindo que agendem
                        serviços online, proporcionando comodidade e eficiência.</li>
                    <li><strong>Registro Detalhado das Atividades:</strong> Tenha um histórico completo de todas as
                        atividades no sistema para rastreabilidade e auditorias precisas.</li>
                </ul>


            </div>

    </main>
    <!-- AJAX para content e formulários -->
    <script src="../assets/js/content-ajax.js"></script>
    <script src="../assets/js/form-ajax.js"></script>
    <!-- Dicas aleatórias -->
    <script src="../assets/js/randomTips.js"></script>
    <!-- Menus -->
    <script src="../assets/js/desktop-menu.js"></script>
    <script src="../assets/js/mobile-menu.js"></script>
</body>

</html>