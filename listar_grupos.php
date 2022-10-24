<?php
require 'lib/conn.php';

$select = "SELECT * FROM GRUPOS";
$stmt = $conn->query($select);
$grupos = $stmt->fetchAll(PDO::FETCH_OBJ);

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
    <title>Grupos</title>
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
                <h1>Grupos</h1>
            </div>
            <nav>
                <a href="cadastro_grupos.php">
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
                foreach ($grupos as $grupo) {
                ?>
                    <div class="card">
                        <a class="remover" href="functions/excluir_grp.php?id=<?=$grupo->ID_GRUPO ?>&pag=listar_grupos">
                            <img class="icon_remover" src="assets/img/close.png" alt="X">
                        </a>

                        <a href="grupo.php?id=<?=$grupo->ID_GRUPO?>">
                            <img src="./assets/img/pasta-aberta.png" alt="Grupo <?= $grupo->ESTADO ?>" />
                        </a>
                        <a href="grupo.php?id=<?= $grupo->ID_GRUPO ?>">
                            <p><?= $grupo->NOME ?></p>
                        </a>
                    </div>
                <?php
                }
                unset($grupos);
                ?>
            </div>
        </div>
        </div>
    </main>
    <script src="assets/js/script.js"></script>
</body>

</html>