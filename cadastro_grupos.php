<?php
require 'lib/conn.php';
$selectLampadas = 'SELECT * FROM LAMPADAS';
$stmt = $conn->query($selectLampadas);
$lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de grupos</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_cadastros.css">
    <link rel="stylesheet" href="assets/css/style_modal.css">
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
        require 'lib/conn.php';
        $erros = false;


        foreach ($_POST as $chave => $valor) {
            if (!is_array($valor))
                $valor = trim(strip_tags($valor));
            $$chave = $valor;

            if (empty($valor)) {
                $erros .= "Campo '" . $chave . "' está em branco <br>";
            }
        }

        if (!$erros) {
            (empty($lampadas_selecionadas) || !isset($lampadas_selecionadas))
                ? $erros .= 'É necessário escolher as lâmpadas para este grupo'
                : $lampadas_selecionadas = array_filter($lampadas_selecionadas);
        }

        if (!$erros) {
            $idModal = 'sucesso';
            $txtModal = 'Grupo cadastrado com sucesso';

            $insert = 'INSERT INTO GRUPOS VALUES(0, :nome)';
            $stmt = $conn->prepare($insert);
            $stmt->bindValue(':nome', $_POST['nome']);
            $stmt->execute();

            $select = 'SELECT ID_GRUPO FROM GRUPOS ORDER BY ID_GRUPO DESC LIMIT 1';
            $stmt = $conn->query($select);
            $grupo = $stmt->fetch(PDO::FETCH_OBJ);
            $idGrupo = $grupo->ID_GRUPO;

            unset($grupo);

            foreach ($lampadas_selecionadas as $lampada) {
                $insert = 'INSERT INTO LAMPADAS_GRUPO VALUES(:idGrupo, :idLampada)';
                $stmt = $conn->prepare($insert);
                $stmt->bindValue(':idGrupo', $idGrupo);
                $stmt->bindValue(':idLampada', $lampada);
                $stmt->execute();
            }
        } else {
            $idModal = 'erro';
            $txtModal = $erros;
            unset($erros);
        }
    ?>
        <div class="page">
        </div>

        <div class="modal" id="<?= $idModal ?>">
            <div class="texto">
                <div class="titulo"><?= $idModal ?></div>
                <div class="close">
                    <img onclick="fecharModal('<?= $idModal ?>')" src="assets/img/close.png" alt="X">
                </div>
            </div>
            <div class="simbolo">
                <img src="assets/img/<?= $idModal ?>.png" alt="X">
                <div class="erro">
                    <div class="aviso" id="aviso__<?= $idModal ?>">
                        <?= $txtModal ?>
                    </div>
                </div>
            </div>
            <div class="botaoModal">
                <button onclick="fecharModal('<?= $idModal ?>')" id="botao"> Fechar</button>
            </div>
        </div>
    <?php
        unset($idModal);
        unset($txtModal);
    }
    ?>
    <main>
        <div id="titulo__cadastro">
            <h1>Cadastro de grupos:</h1>
            <nav>
                <a href="index.php">
                    <img src="assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <form action="" method="post">

            <div class="campos">
                <label for="nome">Nome:*</label>
                <input type="text" id="nome" name="nome">
            </div>

            <div class="campos">
                <label for="selecao">Selecione as lâmpadas que pertencerão a este grupo*</label>
                <div class="opcoes">
                    <?php
                    foreach ($lampadas as $lampada) {
                    ?>
                        <div class="opcao">
                            <label for="lampada-<?= $lampada->ID_LAMPADA ?>">
                                <input type="checkbox" id="lampada-<?= $lampada->ID_LAMPADA ?>" name="lampadas_selecionadas[]" value="<?= $lampada->ID_LAMPADA ?>">
                                <div class="card card__lampada">
                                    <img src="assets/img/lampada_<?= $lampada->ESTADO ?>.png" alt="Lampada">
                                    <p><?= $lampada->NOME ?></p>
                                </div>
                            </label>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="botoes">
                    <button type="submit" class="botao" id="btn__submit">Cadastrar</button>
                    <button type="reset" class="botao" id="btn__reset">Limpar</button>
                </div>
            </div>
        </form>
    </main>

    <script src="assets/js/script.js"></script>
</body>

</html>