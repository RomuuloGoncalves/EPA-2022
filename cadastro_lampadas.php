
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

    <?php
        if (!empty($_POST)) {
            require_once './lib/conn.php';
            $erros = false;

            foreach ($_POST as $chave => $valor) {
                $valor = trim(strip_tags($valor));
                $$chave = $valor;

                if (empty($valor)) {
                    $erros .= "Campo $chave está em branco";
                }
            }

            if (!$erros) {
                require_once './functions/porta_cadastrada.php';

                if (!is_numeric($porta)) {
                    $erros = "Campo porta deve ser um número inteiro";
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
                    <script>alert("Cadastro realizado com sucesso :)");</script>
                    <meta http-equiv="refresh" content="0; url=./index.php">
                <?php
            } else {
                ?>
                    <script>alert("<?=$erros?>");</script>
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
</body>

</html>