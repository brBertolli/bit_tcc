<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once("../../assets/php/auth_session.php");
  include("../../assets/php/connection.php");
  include("../../assets/php/cpf_validation.php");

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome']) && isset($_POST['cpf'])) {
      // Validação de CPF
      $cpf = $_POST['cpf'];

      if (!validaCPF($cpf)) {
        echo "cpf";
      } else {
        // Preparação da consulta para verificar se o CPF já existe
        $query = $conexao->prepare("SELECT * FROM cliente WHERE cpf = ?");
        $query->bind_param("s", $cpf);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
          echo "already";
        } else {
          $nome = strtoupper($_POST['nome']);
          $data_nascimento = $_POST['data_nascimento'];
          $rg = $_POST['rg'];
          // CPF já validado
          $celular = $_POST['celular'];
          $cep = $_POST['cep'];
          $estado = $_POST['estado'];
          $cidade = $_POST['cidade'];
          $bairro = $_POST['bairro'];
          $rua = $_POST['rua'];
          $numero = $_POST['numero'];

          $insert = $conexao->prepare("INSERT INTO cliente (nome, data_nascimento, rg, cpf, celular, cep, estado, cidade, bairro, rua, numero) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
          $insert->bind_param("sssssssssss", $nome, $data_nascimento, $rg, $cpf, $celular, $cep, $estado, $cidade, $bairro, $rua, $numero);

          if ($insert->execute()) {
            echo "success";
          } else {
            echo "error";
          }
        }
      }
      mysqli_close($conexao);
      exit;
    }
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
  <title>Cadastro - Cliente</title>

  <script src="../assets/js/masks.js"></script>
</head>

<body>
  <h2 class="page-title">Cadastrar Clientes</h2>
  <form class="grid-template" id="submitForm" method="POST">


    <div class="larger-field field">
      <label for="nome">Nome</label>
      <input type="text" name="nome" id="nome" placeholder="Nome Completo">
    </div>

    <div class="extra-small-field field">
      <label for="data_nascimento">Data nascimento</label>
      <input type="date" name="data_nascimento" id="data_nascimento">
    </div>

    <div class="extra-small-field field">
      <label for="rg">RG</label>
      <input type="text" name="rg" id="rg" placeholder="XX.XXX.XXX-X">
    </div>

    <div class="extra-small-field field">
      <label for="cpf">CPF</label>
      <input type="text" name="cpf" id="cpf" placeholder="XXX.XXX.XXX-XX">
    </div>

    <div class="small-field field">
      <label for="celular">Celular</label>
      <input class="celular" type="text" name="celular" id="celular" placeholder="(XX) XXXXXX-XXXX">
    </div>

    <div class="small-field field">
      <label for="cep">CEP</label>
      <input type="text" name="cep" id="cep" placeholder="XXXXX-XXX">
    </div>

    <div class="small-field field">
      <label for="estado">Estado</label>
      <select name="estado" id="estado">
        <option value="SC">Santa Catarina</option>
        <option value="PR">Paraná</option>
        <option value="SP">São Paulo</option>
      </select>
    </div>

    <div class="normal-field field">
      <label for="cidade">Cidade</label>
      <input type="text" name="cidade" id="cidade" placeholder="Cidade">
    </div>

    <div class="small-field field">
      <label for="bairro">Bairro</label>
      <input type="text" name="bairro" id="bairro" placeholder="Ex.: Centro">
    </div>

    <div class="larger-field field">
      <label for="rua">Rua</label>
      <input type="text" name="rua" id="rua" placeholder="Ex.: Av. Tecnologias / Rua das Caldeiras">
    </div>

    <div class="extra-small-field field">
      <label for="numero">N°</label>
      <input type="text" name="numero" id="numero" placeholder="Ex.: 1001">
    </div>

    <div class="button-area">
      <button class="submit-button" type="submit" name="salvar">Cadastrar</button>
    </div>
  </form>
</body>

</html>