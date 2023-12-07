<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Conexão
    require_once("../../assets/php/auth_session.php");
    include("../../assets/php/connection.php");

    function search($termSearch)
    {
        include("../../assets/php/connection.php");

        // Ordena primeiro por status ('Pendente' vem antes de 'Finalizado'), depois por ID da ordem de serviço.
        $orderClause = "ORDER BY FIELD(os.status, 'Pendente', 'Finalizado'), os.id ASC";

        if ($termSearch == 'all') {
            $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, os.equipamento, os.valor_total, os.status, (SELECT MAX(data_recebimento) FROM recebimento WHERE ordem_servico_id = os.id) AS ultimo_recebimento FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id WHERE os.status IN ('Pendente', 'Finalizado') " . $orderClause);
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $searchValue = "%$termSearch%";
            $stmt = $conexao->prepare("SELECT os.id, c.nome AS cliente_nome, os.equipamento, os.valor_total, os.status, (SELECT MAX(data_recebimento) FROM recebimento WHERE ordem_servico_id = os.id) AS ultimo_recebimento FROM ordem_de_servico os INNER JOIN cliente c ON os.cliente_id = c.id WHERE c.nome LIKE ? AND os.status IN ('Pendente', 'Finalizado') " . $orderClause);
            $stmt->bind_param("s", $searchValue);
            $stmt->execute();
            $resultado = $stmt->get_result();
        }

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                if ($row['status'] == "Finalizado") {
                    echo "<tr class='lin_success'>";
                } else {
                    echo "<tr>";
                }
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['cliente_nome']}</td>";
                echo "<td class='status_data'>{$row['status']}</td>";
                // Verifica se existe data de último recebimento e a exibe, caso contrário, mostra uma mensagem
                echo "<td>" . ($row['ultimo_recebimento'] ? $row['ultimo_recebimento'] : "Nenhum pagamento") . "</td>";
                echo "<td>R$ " . number_format($row['valor_total'], 2, ',', '.') . "</td>";
                echo "<td>R$ " . number_format($row['valor_total'], 2, ',', '.') . "</td>";
                // A coluna valor_pago não está presente na sua seleção, então esta linha foi removida.
                echo "<td>
                    <div class='actions'>
                    <button class='edit_receive button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/edit-icon.png' alt='Editar'></button>
                    <button class='delete_receive button-icon' data-id='" . $row['id'] . "'><img src='../assets/img/delete-icon.png' alt='Editar'></button>
                    </div>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhuma ordem de serviço encontrada.</td></tr>";
        }

        $stmt->close();
        $conexao->close();
    }

    function getData($id) {
        include("../../assets/php/connection.php");
    
        // Prepare statement
        $stmt = $conexao->prepare("
            SELECT 
                os.id AS os_id, 
                c.nome AS cliente_nome, 
                os.valor_total AS os_valor_total, 
                r.id AS recebimento_id, 
                r.valor_recebimento AS valor_recebimento, 
                r.forma_pagamento AS forma_pagamento,
                r.data_recebimento AS data_recebimento
            FROM 
                ordem_de_servico os 
            INNER JOIN 
                cliente c ON os.cliente_id = c.id
            LEFT JOIN 
                recebimento r ON os.id = r.ordem_servico_id
            WHERE 
                os.id = ?
        ");
    
        // Bind parameter
        $stmt->bind_param("i", $id);
    
        // Execute query
        if($stmt->execute()) {
            $resultado = $stmt->get_result();
    
            // Fetch all data
            $data = $resultado->fetch_all(MYSQLI_ASSOC);
    
            // Return JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            // Handle error
            echo json_encode(["error" => "Erro na execução da consulta"]);
        }
    }
    
    // Handling AJAX request
    if (isset($_POST['action']) && $_POST['action'] == 'getData') {
        $id = $_POST['id'];
        getData($id);
        exit;
    }
    
    


    function deleteData($id)
    {
        include("../../assets/php/connection.php");

        // Inicia uma transação para garantir que todas as operações sejam concluídas com sucesso
        $conexao->begin_transaction();

        try {
            // Primeiro, exclui todos os recebimentos relacionados com a ordem de serviço
            $stmt = $conexao->prepare("DELETE FROM recebimento WHERE ordem_servico_id = ?");
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao excluir recebimentos relacionados: ' . $stmt->error);
            }
            $stmt->close();

            $stmt = $conexao->prepare("DELETE FROM ordem_de_servico_peca WHERE ordem_de_servico_id = ?");
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao excluir peças relacionadas: ' . $stmt->error);
            }
            $stmt->close();

            $stmt = $conexao->prepare("DELETE FROM ordem_de_servico WHERE id = ?");
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao excluir ordem de serviço: ' . $stmt->error);
            }
            $stmt->close();

            // Se tudo ocorreu bem, confirma as operações
            $conexao->commit();
            echo json_encode(['success' => true, 'message' => 'Ordem de serviço e dados relacionados excluídos com sucesso.']);
        } catch (Exception $e) {
            // Se algo der errado, desfaz as operações
            $conexao->rollback();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

        $conexao->close();
    }


    // Faz a chamada de exclusão passando o ID
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'deleteData') {
        deleteData($_POST['id']);
    }


    // Quando enviar o formulário de pesquisa
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['searchTerm'])) {
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
    <title>Controle de Clientes</title>

    <script src="../assets/js/masks.js"></script>
</head>

<body>
    <h2>Controle de Recebimentos</h2>
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
                    <div class="extra-small-field field">
                        <label for="ordem_servico_id">OS:</label>
                        <input type="text" id="ordem_servico_id" name="ordem_servico_id" readonly>
                    </div>
                    <div class="small-field field">
                        <label for="nome">Nome</label><br>
                        <input type="text" name="nome" id="cliente_nome" readonly>
                    </div>

                    <h1>Pagamentos</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Valor Pago</th>
                                <th>Forma de Pagamento</th>
                                <th>Data do Pagamento</th>
                            </tr>
                        </thead>
                        <tbody id="recebimentoList">
                        </tbody>
                    </table>

                    <div class="extra-small-field field">
                        <label for="valor_total">Valor Pago: </label>
                        <input class="contabil" type="text" placeholder="R$ 0,00" name="valor_total" id="os_valor_total" value="" readonly>
                    </div>
                    <div class="extra-small-field field">
                        <label for="valor_total">Total: </label>
                        <input class="contabil" type="text" placeholder="R$ 0,00" name="valor_total" id="valor_total" value="" readonly>
                    </div>

                    <div class="actions">
                        <input class="success-btn" type="button" value="Salvar" id="salvar">
                        <input class="close alert-btn" type="button" value="Cancelar">
                    </div>
                </div>
            </div>


    <div id="excluirModal" class="modal hidden">
        <div class="modal-content">
            <span class="close close-btn">&times;</span>
            <h3 class="confirm-msg">Você tem certeza que deseja excluir? OS:
                <input type="text" id="idRecebimento" readonly>
            </h3>
            <div class="button-area">
                <input class="alert-btn" id="excluir_recebimento" type="button" value="Confirmar">
                <input class="cancel-btn close" type="button" value="Cancelar">
            </div>
        </div>
    </div>

    <!-- Tabela Principal para exibir as ordens de serviço finalizadas -->
    <div>
        <table>
            <thead>
                <tr>
                    <th>OS</th>
                    <th>Nome Cliente</th>
                    <th>Pagamento</th>
                    <th>Último Pagamento</th>
                    <th>Valor Total OS</th>
                    <th>Valor Total Pago</th>
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
</body>

</html>