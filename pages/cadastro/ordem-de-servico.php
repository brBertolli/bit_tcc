<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once("../../assets/php/auth_session.php");
  include("../../assets/php/connection.php");


  // Fetch the latest order ID from the database
  $query = "SELECT MAX(id) AS max_id FROM ordem_de_servico";
  $result = mysqli_query($conexao, $query);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $latest_order_id = $row['max_id'];

    $id = $latest_order_id + 1;

  } else {
    $id = "Inválido";
  }


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['search-cliente'])) {
      $search = $_POST['search-cliente'];
      $search = "%$search%";

      $stmt = $conexao->prepare("SELECT id, nome FROM cliente WHERE nome LIKE ?");
      $stmt->bind_param("s", $search);
      $stmt->execute();
      $resultado = $stmt->get_result();

      while ($row = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['nome'] . "</td>";
        echo "<td><button class='select-cliente select-btn action-btn close' type='button' data-id='" . $row['id'] . "' data-nome='" . $row['nome'] . "'>Selecionar</button></td>";
        echo "</tr>";
      }
      exit;
    }


    $conexao->begin_transaction();

    try {
      $cliente_id = $_POST['clienteId'];
      $equipamento = $_POST['equipamento'];
      $problema_relatado = $_POST['problemarelatado'];

      $stmt = $conexao->prepare("INSERT INTO `ordem_de_servico` (`cliente_id`, `equipamento`, `problema_relatado`) VALUES (?, ?, ?)");
      $stmt->bind_param("iss", $cliente_id, $equipamento, $problema_relatado);

      if (!$stmt->execute()) {
        throw new Exception("Erro ao inserir ordem de serviço: " . $stmt->error);
      }

      $id = $conexao->insert_id;


      // Se tudo estiver ok, commit a transação
      $conexao->commit();
      echo "success";
    } catch (Exception $e) {
      // Se algo deu errado, rollback a transação
      $conexao->rollback();
      echo "error: " . $e->getMessage();
    } finally {
      $stmt->close();
      $conexao->close();
    }
    exit;
  }


} else {
  header('HTTP/1.0 403 Forbidden');
  exit;
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Cadastro - Ordem de Serviço</title>

  <script src="../assets/js/masks.js"></script>
  <script src="../assets/js/modal.js"></script>

</head>

<body>
  <h2>Cadastrar Ordem de Serviço</h2>
  <div id="clienteModal" class="modal hidden">
    <div class="modal-content">
      <form class="search-form" id="os_searchCliente">
        <input class="search-input" type="text" name="search-cliente" placeholder="Digite para pesquisar...">
        <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
            alt="Icon"></button>
        <span class="close">&times;</span>
      </form>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Selecionar</th>
          </tr>
        </thead>
        <tbody id="search-result"></tbody>
      </table>
    </div>
  </div>

  <div id="pecaModal" class="modal hidden">
    <div class="modal-content">
      <form class="search-form" id="searchPeca">
        <input class="search-input" type="text" name="search-peca" placeholder="Digite para pesquisar...">
        <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
            alt="Icon"></button>
        <span class="close">&times;</span>
      </form>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Valor</th>
            <th>Quantidade</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="search-result-peca"></tbody>
      </table>
    </div>
  </div>

  <form class="grid-template" id="submitForm" action="orderm-de-servico.php" method="POST">
    <div class="normal-field field">
      <label>Cliente</label>
      <input type="hidden" id="clienteId" name="clienteId" />
      <div class="search-div" id="selecionarCliente">
        <input class="search-input" type="text" id="clienteNome" name="clienteNome"
          placeholder="Clique para selecionar um cliente" readonly />
        <button class="search-button" type="button"><img class="icons" src="../assets/img/search-icon.png"
            alt="Icon"></button>
      </div>
    </div>


    <div class="small-field field">
      <label for="equipamento">Equipamento</label><br>
      <input type="text" name="equipamento" id="equipamento">
    </div>



    <div class="extra-small-field field">
      <label for="id">OS:</label>
      <input type="text" id="id" name="id" value="<?php echo $id ?>" readonly>
    </div>


    <div class="textarea-field field">
      <label for="problemarelatado">Probelema Relatado </label><br>
      <textarea id="problemarelatado" name="problemarelatado" cols="20" rows="10"></textarea>
    </div>


    <div class="button-area">
      <button class="submit-button" type="submit" name="salvar">Cadastrar</button>
    </div>

  </form>
</body>

</html>