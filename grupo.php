<?php
    if (empty($_GET)) {
        header("location:index.php");
    }

    $id = (int)$_GET['id'];
    unset($_GET['id']);

	require 'lib/conn.php';
	require 'functions/atualizar_json.php';

	atualizar_json('SELECT PORTA, ESTADO FROM LAMPADAS', 'json/lampadas.json');

    $select = "SELECT * FROM GRUPOS WHERE ID_GRUPO = :id";
    $stmt = $conn->prepare($select);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $grupo = $stmt->fetch(PDO::FETCH_OBJ);

    if ($stmt->rowCount() == 0){
        header('location: ./index.php');
    }

    $select = "SELECT * FROM LAMPADAS INNER JOIN LAMPADAS_GRUPO ON LAMPADAS_GRUPO.ID_LAMPADA = LAMPADAS.ID_LAMPADA WHERE LAMPADAS_GRUPO.ID_GRUPO = :id";
    $stmt = $conn->prepare($select);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $lampadas = $stmt->fetchAll(PDO::FETCH_OBJ);

    unset($select);
    unset($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Grupo - <?=$grupo->NOME?></title>
	<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/style.css" />
	<link rel="stylesheet" href="assets/css/style_grupo.css">
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

                    <div class="modal" id="<?=$idModal?>">
                        <div class="texto">
                            <div class="titulo"><?=$idModal?></div>
                            <div class="close">
                                <img onclick="fecharModal('<?=$idModal?>')" src="assets/img/close.png" alt="X">
                            </div>
                        </div>
                        <div class="simbolo">
                            <img src="assets/img/<?=$idModal?>.png" alt="X">
                            <div class="erro">
                                <div class="aviso" id="aviso__<?=$idModal?>">
                                    <?=$txtModal?>
                                </div>
                            </div>
                        </div>
                        <div class="botaoModal">
                            <button onclick="fecharModal('<?=$idModal?>')" id="botao"> Fechar</button>
                        </div>
                    </div>
        <?php
            unset($idModal);
            unset($txtModal);
            }
        ?>
            <div class="page remover"></div>
            <div class="modal apagar" id="alterarNomeGrupo">
                <div class="texto">
                    <div class="titulo">Alterar nome do grupo</div>
                    <div class="close">
                        <img onclick="fecharModal('alterarNomeGrupo')" src="assets/img/close.png" alt="">
                    </div>
                </div>
                <div class="formsModal">
                    <form action="functions/mudar_nome_grp.php" method="post">
                        <div class="campos">
                            <label for="nomeNovo">Novo Nome</label>
                            <input id="nomeNovo" type="text" name="nomeNovo">
                        </div>
                        <input type="hidden" name="id" value="<?=$id?>">
                        <button type="submit" id="salvar">Salvar</button>
                    </form>
                </div>
            </div>
            <div id="titulo__grupo">
            <div class="wrapper_nome">
                <h1><?=$grupo->NOME?></h1>
                <img src="assets/img/editar.png" id="editar" onclick="abrirModal('alterarNomeGrupo');"/>
            </div>
            <nav>
                <a href="index.php">
                    <img src="assets/img/seta.png" alt="Voltar">
                </a>
            </nav>
        </div>
        </div>

        <div class="wrapper">
        <div class="titulo">
                <h2>Lâmpadas</h2>
                <a href="./adicionar_lampadas_grupo.php?id=<?=$grupo->ID_GRUPO?>">
                    <img src="./assets/img/mais.png" alt="adicionar">
                </a>
            </div>
            <div class="container_lampadas">
                <?php
					foreach($lampadas as $lampada) {
						?> 
                            <div class="card card__lampada">
                                <a class="remover" href="functions/remover_lampada_grp.php?idLampada=<?=$lampada->ID_LAMPADA?>&idGrupo=<?=$id?>">
                                    <img class="icon_remover" src="assets/img/close.png" alt="X">
                                </a>
                                <a href="functions/mudar_estado_lampada.php?id=<?=$lampada->ID_LAMPADA?>&est=<?=$lampada->ESTADO?>&pag=grupo&idGrupo=<?= $grupo->ID_GRUPO ?>">  
                                    <img src="./assets/img/lampada_<?= $lampada->ESTADO ?>.png" alt="Lampada <?= $lampada->ESTADO ?>" />
                                </a>
                                <a href="lampada.php?id=<?=$lampada->ID_LAMPADA?>">
                                    <p><?=$lampada->NOME?></p>
                                </a>
                            </div>
						<?php
					}
                    unset($lampadas);
				?>
            </div>
        </div>
        <a class="excluir" href="functions/excluir_grp.php?id=<?=$grupo->ID_GRUPO?>">
            <p>Excluir grupo</p>
            <img src="assets/img/lixeira.png" alt="exluir">
        </a>
	</main>
    <script src="assets/js/script.js"></script>
</body>

</html>