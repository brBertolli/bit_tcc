$(document).ready(function () {
    $('#cpf').mask('000.000.000-00', { reverse: true });
    $('#rg').mask('00.000.000-0', { reverse: true })
    $('#celular').mask('(00) 00000-0000', { reverse: false });
    $('#cep').mask('00000-000', { reverse: true });
    $('#numero').mask('000000', { reverse: true });

    $('.contabil').maskMoney({
        prefix: 'R$ ',
        allowNegative: false,
        thousands: '.',
        decimal: ',',
        affixesStay: false
    });

    $('.celular').mask('(00) 00000-0000').on('blur', function () {
        var regex = /^\(\d{2}\) \d{5}-\d{4}$/;
        var numero = $(this).val();

        if (!regex.test(numero)) {
            $(this).val('');
        }
    });

    $("#cep").on("blur", function () {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep !== "") {
            var validacep = /^[0-9]{8}$/;

            if (validacep.test(cep)) {
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                    if (!("erro" in dados)) {
                        // Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                    } else {
                        // CEP pesquisado não foi encontrado.
                        alert("CEP não encontrado.");
                    }
                });
            } else {
                // CEP é inválido.
                alert("Formato de CEP inválido.");
            }
        } else {
            // CEP sem valor, limpa formulário.
            $("#rua").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#estado").val("");
        }

    });
});

