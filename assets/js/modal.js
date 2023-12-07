$(document).ready(function () {
    // Funções genéricas para mostrar e esconder modais
    function showModal(modalId) {
        $(modalId).removeClass('hidden').show();
    }

    function hideModal(modalId) {
        $(modalId).hide();
    }

    // Função para adicionar peças selecionadas à ordem de serviço
    function addSelectedPeca(pecaId, pecaNome, quantidade) {
        var pecaHtml = $('<div class="peca-item" data-peca-id="' + pecaId + '">' +
            '<span class="peca-nome">' + pecaNome + '</span>' +
            ' x <span class="peca-quantidade">' + quantidade + '</span>' +
            '<input type="hidden" name="peca_ids[]" value="' + pecaId + '">' +
            '<input type="hidden" name="peca_quantidades[]" value="' + quantidade + '">' +
            '<button type="button" class="remove-peca">Remover</button>' +
            '</div>');

        $('#pecasSelecionadas').append(pecaHtml);
    }

    // Manipuladores de eventos para abrir e fechar modais
    $(document).on('click', '#selecionarCliente', function () {
        showModal('#clienteModal');
    });

    $(document).on('click', '#selecionarPeca', function () {
        showModal('#pecaModal');
    });

    $(document).on('click', '.edit', function () {
        showModal('#editModal');
    });

    $(document).on('click', '.edit_os', function () {
        showModal('#editModal');
    });
    $(document).on('click', '.edit_peca', function () {
        showModal('#editModal');
    });

    $(document).on('click', '.delete_cliente', function () {
        showModal('#excluirModal');
    });

    $(document).on('click', '.delete_funcionario', function () {
        showModal('#excluirModal');
    });

    $(document).on('click', '.delete_peca', function () {
        showModal('#excluirModal');
    });

    $(document).on('click', '.delete_os', function () {
        showModal('#excluirModal');
    });
    $(document).on('click', '.edit_receive', function () {
        showModal('#editModal');
    });
    $(document).on('click', '.delete_receive', function () {
        showModal('#excluirModal');
    });
    $(document).on('click', '.finish_os', function () {
        showModal('#finalizarModal');
    });

    $(document).on('click', '.close', function () {
        var modalId = '#' + $(this).closest('.modal').attr('id');
        hideModal(modalId);
    });

    $(window).on('click', function (event) {
        if ($(event.target).hasClass('modal')) {
            hideModal('.modal');
        }
    });

    // Seleção de cliente

    $(document).on('click', '.select-button', function () {
        hideModal('.modal');
    });

    $(document).on('change', '#expandir', function () {
        var listaPeca = $('.peca-search');
        var btn = $('#expandirLabel');
        if ($(this).is(':checked')) {
            btn.html("<img src='../assets/img/minimize-icon.png' alt='Minimizar'>")
            listaPeca.addClass('show');
        } else {
            btn.html("<img src='../assets/img/expand-icon.png' alt='Expandir'>")
            listaPeca.removeClass('show');
        }
    });
    $(document).on('change', '#expandirPagamento', function () {
        var pagamentos = $('.pagamentos');
        var btn = $('#expandirLabelPagamento');
        if ($(this).is(':checked')) {
            btn.html("<img src='../assets/img/minimize-icon.png' alt='Minimizar'>")
            pagamentos.addClass('show');
            console.log("expandir")
        } else {
            btn.html("<img src='../assets/img/expand-icon.png' alt='Expandir'>")
            pagamentos.removeClass('show');
            console.log("minimizar")
        }
    });
});
