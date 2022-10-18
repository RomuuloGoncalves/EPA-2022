<?php
require 'lib/conn.php';
require 'functions/atualizar_json.php';

atualizar_json('SELECT PORTA, ESTADO FROM LAMPADAS', 'json/lampadas.json');

$select = "SELECT * FROM LAMPADAS";
$stmt = $conn->query($select);
$lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($stmt->rowCount() == 0) {
    header('location: ./index.php');
}

unset($select);
unset($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lâmpadas</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/style_paginas.css">
    <link rel="stylesheet" href="assets/css/style_listas.css">
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
                <h1>Lâmpadas</h1>
            </div>
            <nav>
                <a href="cadastro_lampadas.php">
                    <img id="mais" src="assets/img/mais.png" alt="Mais">
                </a>

                <a href="index.php">
                    <img src="assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>

        <div class="content">
            <div class="container">
                <?php
                foreach ($lampadas as $lampada) {
                ?>
                    <div class="card">
                        <a class="remover" href="functions/excluir_lampada.php?id=<?= $lampada->ID_LAMPADA ?>&pag=listar_lampada">
                            <img class="icon_remover" src="assets/img/close.png" alt="X">
                        </a>

                        <a href="functions/mudar_estado_lampada.php?id=<?= $lampada->ID_LAMPADA ?>&est=<?= $lampada->ESTADO ?>&pag=listar_lampada">
                            <img src="./assets/img/lampada_<?= $lampada->ESTADO ?>.png" alt="Lampada <?= $lampada->ESTADO ?>" />
                        </a>
                        <a href="lampada.php?id=<?= $lampada->ID_LAMPADA ?>">
                            <p><?= $lampada->NOME ?></p>
                        </a>
                    </div>
                <?php
                }
                unset($lampadas);
                ?>
            </div>
        </div>
        </div>
    </main>
    <script src="assets/js/script.js"></script>
</body>

</html>