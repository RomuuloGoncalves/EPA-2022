<?php
    if (empty($_GET))
        header('location:index.php');
    $id = (int) $_GET['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento grupo</title>
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
                $erros .= 'Campo "' . $chave . '" está em branco <br>';
            }
        }

        if (!$erros) {
            (empty($lampadas_selecionadas) || !isset($lampadas_selecionadas))
                ? $erros .= 'É necessário escolher as lâmpadas para este grupo'
                : $lampadas_selecionadas = array_filter($lampadas_selecionadas);
        }

        if (!$erros) {
            $idModal = 'sucesso';
            $txtModal = 'Lâmpadas adicionada com sucesso';

            foreach ($lampadas_selecionadas as $lampada) {
                $insert = 'INSERT INTO LAMPADAS_GRUPO VALUES(:idGrupo, :id)';
                $stmt = $conn->prepare($insert);
                $stmt->bindValue(':idGrupo', $id);
                $stmt->bindValue(':id', $lampada);
                $stmt->execute();
            }

            unset($insert);
            unset($stmt);
            unset($erros);
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
            <h1>Adicionar lâmpadas:</h1>
            <nav>
                <a href="grupo.php?id=<?=$id?>">
                    <img src="assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="campos">
                <label for="selecao">Selecione as lâmpadas que serão adicionadas a este grupo*</label>
                <div class="opcoes">
                <?php
                    require 'lib/conn.php';

                    $select = 'SELECT * FROM LAMPADAS l WHERE l.ID_LAMPADA NOT IN (SELECT ID_LAMPADA FROM LAMPADAS_GRUPO WHERE ID_GRUPO = :id)';
                    $stmt = $conn->prepare($select);
                    $stmt->bindValue(':id', $id);
                    $stmt->execute();
                    $qtddLampadas = $stmt->rowCount();
                    $lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);

                    unset($select);
                    unset($stmt);

                    if ($qtddLampadas === 0) {
                        ?>
                        <label style="margin-right: auto;">Não há lâmpadas disponiveis: todas as lâmpadas já estão neste grupo</label>
                        <?php
                    } else {
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
                        unset($lampadas);
                    }
                    ?>
                </div>

                <div class="botoes">
                    <button type="submit" class="botao" id="btn__submit">Cadastrar</button>
                    <button type="reset" class="botao" id="btn__reset">Limpar</button>
                </div>
        </form>
    </main>

    <script src="assets/js/script.js"></script>
</body>

</html>