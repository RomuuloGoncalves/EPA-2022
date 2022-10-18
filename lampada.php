<?php
if (empty($_GET)) {
    header('location: ./index.php');
}
require 'lib/conn.php';

$id = (int)$_GET['id'];

$select = 'SELECT * FROM LAMPADAS WHERE ID_LAMPADA = :id';
$stmt = $conn->prepare($select);
$stmt->bindValue(':id', $id);
$stmt->execute();
$lampada = $stmt->fetch(PDO::FETCH_OBJ);

if ($stmt->rowCount() == 0) {
    header('location: ./index.php');
}

$select = 'SELECT G.ID_GRUPO, G.NOME FROM LAMPADAS L INNER JOIN LAMPADAS_GRUPO LG INNER JOIN GRUPOS G ON L.ID_LAMPADA = LG.ID_LAMPADA AND LG.ID_GRUPO = G.ID_GRUPO WHERE L.ID_LAMPADA = :id';
$stmt = $conn->prepare($select);
$stmt->bindValue(':id', $id);
$stmt->execute();
$grupos = $stmt->fetchAll(PDO::FETCH_OBJ);

$select = 'SELECT R.ID_ROTINA, R.NOME FROM LAMPADAS L INNER JOIN LAMPADAS_ROTINA LR INNER JOIN ROTINAS R ON L.ID_LAMPADA = LR.ID_LAMPADA AND LR.ID_ROTINA = R.ID_ROTINA WHERE L.ID_LAMPADA = :id';
$stmt = $conn->prepare($select);
$stmt->bindValue(':id', $id);
$stmt->execute();
$rotinas = $stmt->fetchAll(PDO::FETCH_OBJ);

unset($select);
unset($stmt);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lâmpada - <?= $lampada->NOME ?></title>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_paginas.css">
    <link rel="stylesheet" href="assets/css/style_lampada.css">
    <link rel="stylesheet" href="assets/css/style_modal.css">
</head>

<body>
    <header>
        <a href="index.php" id="container__logo">
            <img id="logo" src="assets/img/Logo DS - EPA.png" alt="Logo" />
            <h1>EPA-2022</h1>
        </a>
    </header>

    <main>
        <div id="titulo__grupo">
            <div class="wrapper__nome">
                <h1><?= $lampada->NOME ?></h1>
                <img src="assets/img/editar.png" id="editar" onclick="abrirModal('alterarNomeLampada');" /> </a>
            </div>
            <nav>
                <a href="./index.php">
                    <img src="./assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>
        <?php
        if (isset($_GET['erros']) || isset($_GET['sucesso'])) {
            if (isset($_GET['erros'])) {
                $idModal = 'erro';
                $txtModal = $_GET['erros'];
            } else {
                $idModal = 'sucesso';
                $txtModal = 'Nome alterado com sucesso';
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
        <div class="page remover"></div>
        <div class="modal apagar" id="alterarNomeLampada">
            <div class="texto">
                <div class="titulo">Alterar nome da lâmpada</div>
                <div class="close">
                    <img onclick="fecharModal('alterarNomeLampada')" src="assets/img/close.png" alt="X">
                </div>
            </div>
            <div class="formsModal">
                <form action="functions/mudar_nome_lampada.php" method="post">
                    <div class="campos">
                        <label for="nomeNovo">Novo Nome</label>
                        <input id="nomeNovo" type="text" name="nomeNovo">
                    </div>
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit" id="salvar">Salvar</button>
                </form>
            </div>
        </div>
        <div class="content">
            <div class="imagem">
                <a href="functions/mudar_estado_lampada.php?id=<?= $lampada->ID_LAMPADA ?>&est=<?= $lampada->ESTADO ?>&pag=lampada">
                    <img src="assets/img/lampada_<?= $lampada->ESTADO ?>.png" alt="">
                </a>
            </div>
            <div class="informacoes">
                <div class="grupos__pertencentes">
                    <div class="header__slider">
                        <h2>Grupos:</h2>
                        <nav>
                            <a href="adicionar_grupos_lampada.php?id=<?= $id ?>">
                                <img src="assets/img/mais.png" alt="mais" />
                            </a>
                        </nav>
                    </div>

                    <div class="containers grupos">
                        <?php
                        foreach ($grupos as $grupo) {
                        ?>
                            <div class="campo__informacoes campo__grupo">
                                <p><?= $grupo->NOME ?></p>
                                <div class="links">
                                    <a href="grupo.php?id=<?=$grupo->ID_GRUPO?>">
                                        <img src="assets/img/info.png" alt="info">
                                    </a>
                                    <a href="functions/remover_lampada_grupo.php?id_lampada=<?= $lampada->ID_LAMPADA ?>&id_grupo=<?= $grupo->ID_GRUPO ?>">
                                        <img src="assets/img/close.png" alt="X">
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        unset($grupos);
                        ?>
                    </div>
                </div>
                <div class="rotinas__pertencentes">
                    <div class="header__slider">
                        <h2>Rotinas:</h2>
                        <nav>
                            <a href="adicionar_rotinas_lampada.php?id=<?= $id ?>">
                                <img src="assets/img/mais.png" alt="mais" />
                            </a>
                        </nav>
                    </div>

                    <div class="containers rotinas">
                        <?php
                        foreach ($rotinas as $rotina) {
                        ?>
                            <div class="campo__informacoes campo__grupo">
                                <p><?= $rotina->NOME ?></p>
                                <div class="links">
                                    <a href="rotina.php?id=<?= $rotina->ID_ROTINA ?>">
                                        <img src="assets/img/info.png" alt="info">
                                    </a>
                                    <a href="functions/remover_lampada_rotina.php?idLampada=<?= $id ?>&idRotina=<?= $rotina->ID_ROTINA ?>">
                                        <img src="assets/img/close.png" alt="X">
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        unset($rotinas);
                        ?>
                    </div>
                </div>
                <a class="excluir" href="functions/excluir_lampada.php?id=<?= $id ?>">
                    <p>Excluir lâmpada</p>
                    <img src="assets/img/lixeira.png" alt="exluir">
                </a>
            </div>
        </div>
    </main>
    <script src="assets/js/script.js"></script>
</body>

</html>