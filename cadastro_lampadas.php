<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Lâmpada</title>
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/style_cadastros.css">
    <link rel="stylesheet" href="./assets/css/style_cadastro_lampadas.css">
    <link rel="stylesheet" href="./assets/css/style_modal.css">
</head>

<body>
    <header>
        <a href="index.php" id="container__logo">
            <img id="logo" src="assets/img/Logo DS - EPA.png" alt="Logo" />
            <h1>EPA-2022</h1>
        </a>
	</header>

    <?php
    if (!empty($_POST)) {
        require_once './lib/conn.php';
        $erros = false;

        foreach ($_POST as $chave => $valor) {
            $valor = trim(strip_tags($valor));
            $$chave = $valor;

            if (empty($valor)) {
                $erros .= "Campo '$chave' está em branco <br>";
            }
        }

        if (!$erros) {
            require_once './functions/porta_cadastrada.php';

            if (!is_numeric($porta)) {
                $erros = "Campo da porta de conexão deve ser um número inteiro";
            } else if ($porta <= 0) {
                $erros = "Porta deve ser maior que zero";
            } else if (porta_cadastrada($porta)) {
                $erros = "Porta já cadastrada";
            }
        }

        if (!$erros) {
            $sqlInsert = 'INSERT INTO LAMPADAS VALUES(0, :nome, :porta, 0)';
            $stmt = $conn->prepare($sqlInsert);
            $stmt->bindValue(":nome", $nome);
            $stmt->bindValue(":porta", (int)$porta);
            $stmt->execute();
    ?>
            <div class="page">
            </div>
            <div class="modal" id="sucesso">
                <div class="texto">
                    <div class="titulo">Cadastrado!!!!</div>
                    <div class="close">
                        <img onclick="fecharModal('sucesso')" src="./assets/img/close.png" alt="">
                    </div>
                </div>
                <div class="simbolo">
                    <img src="./assets/img/sucesso.png" alt="">
                    <div class="erro">
                        <div class="aviso" id="aviso__sucesso">
                            Lâmpada cadastrada com sucesso!!!
                        </div>
                    </div>
                </div>
                <div class="botaoModal">
                    <button onclick="fecharModal('sucesso')" id="botao" style="background-color: rgba(79, 204, 79, 0.719);border:2px solid rgb(68, 131, 68);">Fechar</button>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="page">
            </div>

            <div class="modal" id="erro">
                <div class="texto">
                    <div class="titulo">Erro!!!!</div>
                    <div class="close">
                        <img onclick="fecharModal('erro')" src="./assets/img/close.png" alt="">
                    </div>
                </div>
                <div class="simbolo">
                    <img src="./assets/img/erro.png" alt="">
                    <div class="erro">
                        <div class="aviso" id="aviso__erro">
                            <?= $erros ?>
                        </div>
                    </div>
                </div>
                <div class="botaoModal">
                    <button onclick="fecharModal('erro')" id="botao"> Fechar</button>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <main>
        <div id="titulo__cadastro">
            <h1>Cadastro de lâmpadas</h1>
            <nav>
                <a href="./index.php">
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
                <label for="porta">Porta de conexão:*</label>
                <input type="number" id="porta" name="porta" min="1">
            </div>

            <div class="botoes">
                <button type="submit" class="botao" id="btn__submit">Cadastrar</button>
                <button type="reset" class="botao" id="btn__reset">Limpar</button>
            </div>
        </form>
    </main>

    <script src="./assets/js/script.js"></script>
</body>

</html>