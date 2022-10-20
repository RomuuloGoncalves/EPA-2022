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
    <title>Cadastro de rotinas</title>
    <link rel="shortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
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
            $erros = false;

            foreach ($_POST as $chave => $valor) {
                if (!is_array($valor))
                    $valor = trim(strip_tags($valor));
                $$chave = $valor;

                if (empty($valor)) {
                    $erros .= 'Campo "'.$chave.'" está em branco <br>';
                }
            }

            if (!$erros) {
                require 'functions/valida_horas.php';

                $hora_inicio = explode(':', $hora_inicio);
                $hora_inicio[0] = (int)$hora_inicio[0];
                $hora_inicio[1] = (int)$hora_inicio[1];

                $hora_fim = explode(':', $hora_fim);
                $hora_fim[0] = (int)$hora_fim[0];
                $hora_fim[1] = (int)$hora_fim[1];

                if (!valida_horas($hora_inicio)) {
                    $erros = 'Hora de inicio invalído';
                } else if (!valida_horas($hora_fim)) {
                    $erros = 'Hora de fim invalído';
                }
                
                (empty($lampadas_selecionadas) || !isset($lampadas_selecionadas))
                    ? $erros .= 'É necessário escolher as lâmpadas para este grupo'
                    : $lampadas_selecionadas = array_filter($lampadas_selecionadas);
            }

            if (!$erros) {
                require 'lib/conn.php';
                require 'functions/formatar12h.php';
                
                $hora_inicio = formatar12h($hora_inicio);
                $hora_fim = formatar12h($hora_fim);

                $insert = 'INSERT INTO ROTINAS VALUES(0, :nome, 0, :h_inicio, :h_fim)';
                $stmt = $conn->prepare($insert);
                $stmt->bindValue(':nome', $nome);
                $stmt->bindValue(':h_inicio', $hora_inicio);
                $stmt->bindValue(':h_fim', $hora_fim);

                $stmt->execute();
                $select = 'SELECT ID_ROTINA FROM ROTINAS ORDER BY ID_ROTINA DESC LIMIT 1';
                $stmt = $conn->query($select);
                $rotina = $stmt->fetch(PDO::FETCH_OBJ);
                $idRotina = $rotina->ID_ROTINA;

                unset($rotina);

                foreach ($lampadas_selecionadas as $lampada) {
                    $insert = 'INSERT INTO LAMPADAS_ROTINA VALUES(:idRotina, :idLampada)';
                    $stmt = $conn->prepare($insert);
                    $stmt->bindValue(':idRotina', $idRotina);
                    $stmt->bindValue(':idLampada', $lampada);
                    $stmt->execute();
                }

                $idModal = 'sucesso';
                $txtModal = 'Rotina cadastrada com sucesso';
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
            <h1>Cadastro de rotinas:</h1>
            <nav>
            <a href="index.php">
            <img src="assets/img/seta.png" alt="Voltar">
        </a>
        </nav>
        </div>

        <form action="" method="POST">
        <div class="campos">
            <label for="nome">Nome:*</label>
            <input type="text" id="nome" name="nome">

            <div class="campo__horario">
                <div class="campo">
                    <label for="hora_inicio">Horário de inicio:*</label>
                    <input type="time" id="hora_inicio" name="hora_inicio">
                </div>
                <div class="campo">
                    <label for="hora_fim">Horário de fim:*</label>
                    <input type="time" id="hora_fim" name="hora_fim">
                </div>
            </div>
        </div>

        <div class="campos">
            <label for="selecao">Selecione as lâmpadas que pertencerão a esta rotina*</label>
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
        </div>

        <div class="botoes">
            <button type="submit" class="botao" id="btn__submit">Cadastrar</button>
            <button type="reset" class="botao" id="btn__reset">Limpar</button>
        </div>
        </form>
    </main>
</body>
<script src="assets/js/script.js"></script>
</html>