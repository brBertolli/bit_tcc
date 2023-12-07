<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo</title>
</head>

<body>
    <h2>Página para Testes</h2>
    <form action="" class="grid-template">
        <div class="extra-larger-field">
            <label for="textomuitogrande">extra-larger-field</label>
            <input type="text" name="textomuitogrande">
        </div>

        <div class="field larger-field">
            <label for="textogrande">larger-field</label>
            <input type="text" name="textogrande">
        </div>

        <div class="field normal-field">
            <label for="textonormal">normal-field</label>
            <input type="text" name="textonormal">
        </div>

        <div class="field small-field">
            <label for="textopequeno">small-field</label>
            <input type="text" name="textopequeno">
        </div>
        <div class="field extra-small-field">
            <label for="textomuitopequeno">extra-small-field a</label>
            <input type="text" name="textomuitopequeno">
        </div>

        <div class="textarea-field">
            <label for="areadetexto">textarea-field </label>
            <textarea name="areadetexto" id="areadetexto" cols="20" rows="10"></textarea>
        </div>

        <div class="textarea-field">
            <label for="areadetexto">textarea-field </label>
            <textarea name="areadetexto" id="areadetexto" cols="20" rows="10"></textarea>
        </div>


        <div class="field extra-small-field">
            <label for="textomuitopequeno">extra-small-field</label>
            <input type="text" name="textomuitopequeno">
        </div>
        <div class="field extra-small-field">
            <label for="textomuitopequeno">extra-small-field</label>
            <input type="text" name="textomuitopequeno">
        </div>


        <!-- FIELDSET -->
        <fieldset class="field fieldset-field">
            <legend>TESTE:</legend>
            <div>
                <label for="formatacao">Formatação</label>
                <input type="checkbox" id="formatacao" value="formatacao" />
            </div>

            <div>
                <label for="limpeza">Limpeza</label>
                <input type="checkbox" id="limpeza" value="limpeza" />
            </div>

            <div>
                <label for="trocadepeca">Troca de Peças</label>
                <input type="checkbox" id="trocadepeca" value="trocadepeca" />
            </div>

            <div>
                <label for="montagem">Montagem</label>
                <input type="checkbox" id="montagem" value="montagem" />
            </div>

            <div>
                <label for="instalacao">Instalação de Programas</label>
                <input type="checkbox" id="instalacao" value="instalacao" />
            </div>

            <div>
                <label for="restauracao">Recuperação de Arquivos</label>
                <input type="checkbox" id="restauracao" value="restauracao" />
            </div>
            </div>
        </fieldset>
        <div class="button-area">
            <button type="submit" name="salvar">Cadastrar</button>
        </div>

    </form>
</body>

</html>