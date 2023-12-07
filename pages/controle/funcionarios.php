<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Conexão
    require_once("../../assets/php/auth_session.php");
    include("../../assets/php/connection.php");
    function search($termSearch) {
        include("../../assets/php/connection.php");
        if($termSearch == 'all') {
            $stmt = $conexao->prepare("SELECT id, nome, cargo, usuario, email, celular FROM funcionario");
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $searchValue = "%$termSearch%";
            $stmt = $conexao->prepare("SELECT id, nome, cargo, usuario, email, celular FROM funcionario WHERE nome LIKE ?");
            $stmt->bind_param("s", $searchValue);
            $stmt->execute();
            $resultado = $stmt->get_result();
        }

        if($resultado->num_rows > 0) {
            while($row = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['nome']}</td>";
                echo "<td>{$row['cargo']}</td>";
                echo "<td>{$row['usuario']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['celular']}</td>";
                if(allowedUser()) {
                    echo "<td>
                    <div class='actions'>
                    <button class='edit_funcionario button-icon' data-id='".$row['id']."'><img src='../assets/img/edit-icon.png' alt='Editar'></button>
                    <button class='delete_funcionario button-icon' data-id='".$row['id']."'><img src='../assets/img/delete-icon.png' alt='Excluir'></button>
                    </div></td>";
                } else {
                    echo "<td>
                    <div class='actions'>
                    <button class='edit_funcionario button-icon' data-id='".$row['id']."'><img src='../assets/img/edit-icon.png' alt='Editar'></button>
                    </div></td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Nenhum funcionario encontrado.</td></tr>";
        }
    }

    // Função para atualizar os valores na tabela funcionario
    function updateData($id, $nome, $usuario, $cargo, $senha, $email, $celular) {
        include("../../assets/php/connection.php");
        $stmt = $conexao->prepare("UPDATE funcionario SET nome = ?, usuario = ?, cargo = ?, senha = ?, email = ?, celular = ? WHERE id = ?");

        $stmt->bind_param("ssssssi", $nome, $usuario, $cargo, $senha, $email, $celular, $id);

        if($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => $id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro: '.$stmt->error]);
        }

        $stmt->close();
        $conexao->close();
    }

    function deleteData($id) {
        include("../../assets/php/connection.php");

        if($id != "") {

            $stmt = $conexao->prepare("DELETE FROM funcionario WHERE id = ?");

            $stmt->bind_param("i", $id);

            if($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => $id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro: '.$stmt->error]);
            }

            $stmt->close();
        }
        $conexao->close();
    }

    // Quando houver um clique em .edit (botão de edição)
    if(isset($_POST['action']) && $_POST['action'] == 'getData') {
        $id = $_POST['id'];
        $stmt = $conexao->prepare("SELECT * FROM funcionario WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }


    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'updateEmployeeData') {

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $usuario = $_POST['usuario'];
        $cargo = $_POST['cargo'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        $celular = $_POST['celular'];

        updateData($id, $nome, $usuario, $cargo, $senha, $email, $celular);

        mysqli_close($conexao);
        exit;
    }



    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'deleteData') {
        deleteData($_POST['id']);
    }

    // Quando enviar o formulário de pesquisa
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['searchTerm'])) {
            $searchValue = $_POST['searchTerm'] ?? 'all';
            search($searchValue);
        }
        mysqli_close($conexao);
        exit;
    }

} else {
    // Acesso no diretório raiz
    header('HTTP/1.0 403 Forbidden');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Funcionários</title>

    <script src="../assets/js/masks.js"></script>
</head>

<body>
    <h2>Controle de Funcionários</h2>
    <div id="searchSection">
        <form class="search-form" id="searchForm" method="POST">
            <input class="search-input" type="text" name="searchTerm" placeholder="Digite para pesquisar...">
            <button class="search-button" type="submit"><img class="icons" src="../assets/img/search-icon.png"
                    alt="Icon"></button>
        </form>
    </div>

    <div id="editModal" class="modal hidden">
        <div class="modal-content">
            <span class="close close-btn">&times;</span>
            <form class="grid-template" id="editForm">
                <div class="extra-small-field field id">
                    <label for="id">ID</label>
                    <input type="text" name="id" id="id" placeholder="ID" readonly>
                </div>
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
                    <input type="password" name="confirmarSenha" id="confirmarSenha" placeholder="Confirmar Senha"
                        required>
                </div>

                <div class="normal-field">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="comercialexemplo@dominio.com">
                </div>

                <div class="small-field">
                    <label for="celular">Celular</label>
                    <input class="celular" type="text" name="celular" id="celular" placeholder="(XX) XXXXXX-XXXX">
                </div>

                <div class="actions">
                    <input class="success-btn" type="button" value="Salvar" id="salvar_funcionario">
                    <input class="close alert-btn" type="button" value="Cancelar">
                </div>
            </form>
        </div>
    </div>

    <div id="excluirModal" class="modal hidden">
        <div class="modal-content">
            <span class="close close-btn">&times;</span>
            <h3 class="confirm-msg">Você tem certeza que deseja excluir? ID:
                <input type="text" id="idFuncionario" readonly>
            </h3>
            <div class="button-area">
                <input class="alert-btn" id="excluir_funcionario" type="button" value="Confirmar">
                <input class="cancel-btn close" type="button" value="Cancelar">
            </div>
        </div>
    </div>

    <div id="funcionarioList">
        <table id="funcionarioTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="search-result">
                <tr>
                    <?php search('all'); ?>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Script para mostrar e esconder as senhas do Funcionário -->
    <script>
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