<?php
    if (empty($_GET)) {
        header('location:index.php');
    }
    
    require 'functions/formatarText12h.php';
	require 'lib/conn.php';
    $id = (int)$_GET['id'];

    $select = 'SELECT * FROM ROTINAS WHERE ID_ROTINA = :id';
    $stmt = $conn->prepare($select);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $rotina = $stmt->fetch(PDO::FETCH_OBJ);

    if ($stmt->rowCount() == 0){
        header('location: ./index.php');
    }

    $select = 'SELECT * FROM LAMPADAS INNER JOIN LAMPADAS_ROTINA ON LAMPADAS_ROTINA.ID_LAMPADA = LAMPADAS.ID_LAMPADA WHERE LAMPADAS_ROTINA.ID_ROTINA = :id';
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
	<title>Rotina - <?=$rotina->NOME?></title>
	<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style_modal.css">
	<link rel="stylesheet" href="assets/css/style.css" />
	<link rel="stylesheet" href="assets/css/style_paginas.css">
    <link rel="stylesheet" href="assets/css/style_grupo_rotina.css">
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
                <h1><?=$rotina->NOME?></h1>
                <img src="assets/img/editar.png" id="editar" onclick="abrirModal('alterarNomeRotina');"/>
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
                    $txtModal = $_GET['sucesso'];
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
            <div class="modal apagar" id="alterarNomeRotina">
                <div class="texto">
                    <div class="titulo">Alterar nome da rotina</div>
                    <div class="close">
                        <img onclick="fecharModal('alterarNomeRotina')" src="assets/img/close.png" alt="">
                    </div>
                </div>
                <div class="formsModal">
                    <form action="functions/mudar_nome_rotina.php?id=<?=$rotina->ID_ROTINA?>" method="post">
                        <div class="campos">
                            <label for="nomeNovo">Novo Nome</label>
                            <input id="nomeNovo" type="text" name="nomeNovo">
                        </div>
                        <input type="hidden" name="id" value="<?=$id?>">
                        <button type="submit" id="salvar">Salvar</button>
                    </form>
                </div>
            </div>

        <div class="page remover"></div>
        <div class="modal apagar" id="alterarHorarioRotina">
            <div class="texto">
                <div class="titulo">Alterar horário da rotina</div>
                <div class="close">
                    <img onclick="fecharModal('alterarHorarioRotina')" src="assets/img/close.png" alt="">
                </div>
            </div>
            <div class="formsModal">
                <form action="functions/mudar_horario_rotina" method="post">
                        <div class="campos">
                            <label for="hora_inicio_novo">Horário de início</label>
                            <input id="hora_inicio_novo" type="time" name="hora_inicio_novo">
                        </div>
                        <div class="campos">
                            <label for="hora_fim_novo">Horário de fim</label>
                            <input id="hora_fim_novo" type="time" name="hora_fim_novo">
                        </div>
                    <input type="hidden" name="id" value="<?=$id?>">
                    <button type="submit" id="salvar">Salvar</button>
                </form>
            </div>
        </div>

        <div class="content">
            <div class="informacoes">
                <div class="hora__rotina">
                    <div class="wrapper__nome">
                        <h2>Horários</h2>
                        <img src="assets/img/editar.png" id="editar" onclick="abrirModal('alterarHorarioRotina');"/>
                    </div>
                    <p>Início: <span><?=formatarText12h($rotina->H_INICIO)?></span></p>
                    <p>Fim: <span><?=formatarText12h($rotina->H_FIM)?></span></p>
                </div>
                <div class="estado__rotina">
                        <p>Estado: <?=($rotina->ESTADO==='0')?"Inativa":"Ativa" ?></p>
                        <img id="img__rotina" src="assets/img/rotina_<?=$rotina->ESTADO?>.png" alt="estado rotina"/>
                </div>
            </div>

            <div class="header__slider">
                <h2>Lâmpadas</h2>
                <nav>
                    <a href="./adicionar_lampadas_rotina.php?id=<?=$rotina->ID_ROTINA?>">
                        <img src="assets/img/mais.png" alt="mais" />
                    </a>
                </nav>
            </div>                    

            <div class="container_lampadas">
                <?php
					foreach($lampadas as $lampada) {
						?> 
                            <div class="card card__lampada">
                                <a class="remover" href="functions/remover_lampada_rotina.php?idLampada=<?=$lampada->ID_LAMPADA?>&idGrupo=<?=$id?>">
                                    <img class="icon_remover" src="assets/img/close.png" alt="X">
                                </a>
                                <a href="functions/mudar_estado_lampada.php?id=<?=$lampada->ID_LAMPADA?>&est=<?=$lampada->ESTADO?>&id_rotina=<?=$rotina->ID_ROTINA?>&pag=rotina&idGrupo=<?= $rotina->ID_ROTINA ?>">  
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
            <a class="excluir" href="functions/excluir_rotina.php?id=<?=$rotina->ID_ROTINA?>">
                <p>Excluir rotina</p>
                <img src="assets/img/lixeira.png" alt="exluir">
            </a>
        </div>
	</main>
    <script src="assets/js/script.js"></script>
</body>

</html>