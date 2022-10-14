<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Lâmpada</title>
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/style_cadastro_lampadas.css">
</head>

<body>
    <header>
        <div id="container__logo">
            <img id="logo" src="./assets/img/Logo DS - EPA.png" alt="Logo" />
        </div>
        <h1>EPA-2022</h1>
    </header>

    <main>
        <div id="titulo__cadastro">
            <h1>Cadastro de lâmpadas</h1>
            <nav>
                <a href="./index.html">
                    <img src="./assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <form action="" method="post">
            <div class="campos">
                <label for="nome">Nome:*</label>
                <input type="text" id="nome" name="nome">
            </div>

            <div class="campos">
                <label for="porta_de_conexao">Porta de conexão:*</label>
                <input type="text" id="porta_de_conexao" name="porta_de_conexao">
            </div>

            <div class="campos">
                <label for="">Grupos:</label>
                <select name="Grupo" id="">
                    <option value="">Selecione</option>
                </select>
            </div>

            <div class="botoes">
                <button type="submit" class="botao" id="btn__submit">Cadastrar</button>
                <button type="reset" class="botao" id="btn__reset">Limpar</button>
            </div>
        </form>
    </main>
</body>

</html>