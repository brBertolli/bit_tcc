<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once("../../assets/php/auth_session.php");
  include("../../assets/php/connection.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['usuario'])) {
      $usuario = $_POST['usuario'];

      $query = $conexao->prepare("SELECT * FROM funcionario WHERE usuario = ?");
      $query->bind_param("s", $usuario);
      $query->execute();
      $result = $query->get_result();

      if ($result->num_rows > 0) {
        echo "already_registered_user";
      } else {
        $nome = $_POST['nome'];
        $cargo = $_POST['cargo'] ?? NULL;
        $senha = $_POST['senha'];
        $confirmarSenha = $_POST['confirmarSenha']; // Adicionado campo de confirmação de senha
        $email = $_POST['email'];
        $celular = $_POST['celular'];

        // Validar se as senhas coincidem
        if ($senha !== $confirmarSenha) {
          echo "password_mismatch";
        } else {
          $insert = $conexao->prepare("INSERT INTO funcionario (nome, cargo, usuario, senha, email, celular) VALUES (?, ?, ?, ?, ?, ?)");
          $insert->bind_param("ssssss", $nome, $cargo, $usuario, $senha, $email, $celular);

          if ($insert->execute()) {
            echo "success";
          } else {
            echo "error";
          }
        }
      }
    }
    mysqli_close($conexao);
    exit;
  }
} else {
  // Acesso não-AJAX, nega acesso
  header('HTTP/1.0 403 Forbidden');
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Funcionário</title>

  <script src="../assets/js/masks.js"></script>
</head>

<body>
  <h2>Cadastrar Funcionário</h2>
  <form class="grid-template" action="usuario.php" method="POST" id="submitForm">


    <div class="larger-field">
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" placeholder="Nome Completo" required>
    </div>

    <div class="small-field">
      <label for="cargo">Cargo</label>
      <select name="cargo" id="cargo">
        <option value="Membro">Membro</option>
        <option value="Técnico">Técnico</option>
        <option value="Administrador">Administrador</option>
        <option value="Gerente">Gerente</option>
        <option value="Suporte">Suporte</option>
        <option value="Vendas">Vendas</option>
        <option value="Atendimento">Atendimento ao Cliente</option>
      </select>
    </div>
    <div class="small-field">
      <label for="usuario">Usuário</label>
      <input type="text" name="usuario" id="usuario" placeholder="Usuário" required>
    </div>


    <div class="small-field">
      <label for="senha">Senha</label>
      <input type="password" name="senha" id="senha" placeholder="Senha" required>
    </div>

    <div class="small-field">
      <label for="confirmarSenha">Confirmar Senha <label class="change-label" for="mostrarSenhas"
          id="labelMostrarSenhas">(Mostrar)</label>
        <input type="checkbox" id="mostrarSenhas">
      </label>
      <input type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirmar Senha" required>
    </div>

    <div class="normal-field">
      <label for="email">E-mail</label>
      <input type="email" name="email" id="email" placeholder="comercialexemplo@dominio.com">
    </div>

    <div class="small-field">
      <label for="celular">Celular</label>
      <input class="celular" type="text" name="celular" id="celular" placeholder="(XX) XXXXXX-XXXX">
    </div>
    <div class="button-area">
      <button class="submit-button" type="submit" name="salvar">Cadastrar</button>
    </div>
  </form>

  <script>
    document.getElementById('submitForm').addEventListener('submit', function (event) {
      var senha = document.getElementById('senha').value;
      var confirmarSenha = document.getElementById('confirmarSenha').value;

      if (senha !== confirmarSenha) {
        alert('As senhas não coincidem. Por favor, tente novamente.');
        event.preventDefault(); // Impede o envio do formulário se as senhas não coincidirem
      }
    });
    document.getElementById('mostrarSenhas').addEventListener('change', function (event) {
      var senha = document.getElementById('senha');
      var confirmarSenha = document.getElementById('confirmarSenha');
      var label = document.getElementById('labelMostrarSenhas');

      // Já temos a referência do checkbox pelo event.target
      var isChecked = event.target.checked;

      // Atualize o tipo de campo de senha com base no estado do checkbox
      senha.type = isChecked ? 'text' : 'password';
      confirmarSenha.type = isChecked ? 'text' : 'password';

      // Atualize o texto da label com base no estado do checkbox
      label.textContent = isChecked ? "(Esconder)" : "(Mostrar)";
    });

  </script>
</body>

</html>