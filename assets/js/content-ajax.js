$(document).ready(function () {
    // Verifica o caminho e carrega o conteúdo de acordo com o link de acesso
    var $path;

    $('a.menu-item').click(function (e) {
        e.preventDefault();

        var href = $(this).attr('href').substring(1);
        $path = href + ".php";

        $('.content').load($path, function (response, status, xhr) {
            if (status == "error") {
                var msg = "Desculpe, ocorreu um erro: ";
                $(".content").html("<p class='content-error'>" + msg + xhr.status + " " + xhr.statusText + "</p>");
            }
        });
    });


    // Trata formulário para enviar o cadastro nas páginas de acesso
    $(document).on('submit', '#submitForm', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        if (!$path) {
            console.log("Caminho para o formulário não definido.");
            return;
        }

        $.ajax({
            type: "POST",
            url: $path,
            data: formData,
            success: function (data) {
                alertMessage(data.trim())
            }
            ,
            error: function (xhr, status, error) {
                console.log("Error: " + error)
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
            }
        });
    })

    // Trata formulários que precisam de uma busca de dados no banco de dados
    $(document).on('submit', '#searchForm', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        if (!$path) {
            console.log("Caminho para o formulário não definido.");
            return;
        }

        $.ajax({
            type: "POST",
            url: $path,
            data: formData,
            success: function (data) {
                $("#search-result").html(data);
            }
            ,
            error: function (xhr, status, error) {
                console.log("Error: " + error)
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro inesperado!</p>');
            }
        });
    })


    // Mensagens de Erros que devem ser exibidas na página
    function alertMessage($response) {
        switch ($response) {
            case "success": {
                $("#status").html('<p class="slide-mensage success">Operação realizada com sucesso!</p>');
                break;
            };
            case "already_registered_user": {
                $("#status").html('<p class="slide-mensage alert">Este usuário já está cadastrado!</p>');
                break;
            }
            case "already": {
                $("#status").html('<p class="slide-mensage alert">CPF já cadastrado!</p>');
                break;
            };
            case "cpf": {
                $("#status").html('<p class="slide-mensage alert">CPF inválido!</p>');
                break;
            }
            case "pesquisa_cliente": {
                $("#status").html('<p class="slide-mensage sucess"> Pesquisa de cliente</p>')
                break;
            }
            default: {
                console.log($response);
                $("#status").html('<p class="slide-mensage alert">Ocorreu um erro ao enviar o formulário.</p>');
            }
        }
    }
});

