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
    <title>Gerenciamento lâmpada</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_cadastros.css">
    <link rel="stylesheet" href="assets/css/style_cadastro_rotinas.css">
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
            (empty($rotinas_selecionados) || !isset($rotinas_selecionados))
                ? $erros .= 'É necessário escolher os rotinas para esta lâmpada'
                : $rotinas_selecionados = array_filter($rotinas_selecionados);
        }

        if (!$erros) {
            $idModal = 'sucesso';
            $txtModal = 'Rotinas adicionada com sucesso';

            foreach ($rotinas_selecionados as $rotina) {
                $insert = 'INSERT INTO LAMPADAS_ROTINA VALUES(:idGrupo, :id)';
                $stmt = $conn->prepare($insert);
                $stmt->bindValue(':idGrupo', $rotina);
                $stmt->bindValue(':id', $id);
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
                <a href="lampada.php?id=<?=$id?>">
                    <img src="assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="campos">
                <label for="selecao">Selecione os rotinas que adicionaram esta lâmpada*</label>
                <div class="opcoes">
                <?php
                    require 'lib/conn.php';

                    $select = 'SELECT * FROM ROTINAS WHERE ID_ROTINA NOT IN (SELECT ID_ROTINA FROM LAMPADAS_ROTINA WHERE ID_LAMPADA= :id)';
                    $stmt = $conn->prepare($select);
                    $stmt->bindValue(':id', $id);
                    $stmt->execute();
                    $qtddRotinas = $stmt->rowCount();
                    $rotinas = $stmt->fetchAll(PDO::FETCH_OBJ);

                    unset($select);
                    unset($stmt);

                    if ($qtddRotinas === 0) {
                        ?>
                        <label style="margin-right: auto;">Não há rotinas disponiveis: todos as rotinas já possuem esta lâmpada</label>
                        <?php
                    } else {
                        foreach ($rotinas as $rotina) {
                        ?>
                            <div class="opcao">
                                <label for="rotina-<?= $rotina->ID_ROTINA ?>">
                                    <input type="checkbox" id="rotina-<?= $rotina->ID_ROTINA ?>" name="rotinas_selecionados[]" value="<?= $rotina->ID_ROTINA ?>">
                                    <div class="card card__lampada">
                                        <p><?= $rotina->NOME ?></p>
                                    </div>
                                </label>
                            </div>
                    <?php
                        }
                        unset($rotinas);
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