<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar nome da lâmpada</title>
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/style_cadastro_lampadas.css">
    <link rel="stylesheet" href="./assets/css/style_modal.css">
</head>

<body>
    <header>
        <a href="./index.php" id="container__logo">
            <img id="logo" src="./assets/img/Logo DS - EPA.png" alt="Logo" />
        </a>
        <h1>EPA-2022</h1>
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
            $sql_update = 'UPDATE LAMPADAS SET NOME = :nome WHERE ID_LAMPADA = :id';
            $stmt = $conn->prepare($sql_update);
            $stmt->bindValue(":nome", $nome);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            header("location: ./lampada.php?id=$id");
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
                        <div class="aviso" id="aviso__errado">
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
            <h1>Atualizar nome</h1>
            <nav>
                <a href="./lampada.php?id=<?= $_GET["id_lampada"] ?>">
                    <img src="./assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $_GET["id_lampada"] ?>">
            <div class="campos">
                <label for="nome">Novo nome:*</label>
                <input type="text" id="nome" name="nome">
            </div>

            <div class="botoes">
                <button type="submit" class="botao" id="btn__submit">Atualizar</button>
                <button type="reset" class="botao" id="btn__reset">Limpar</button>
            </div>
        </form>
    </main>

    <script src="./assets/js/script.js"></script>
</body>

</html>